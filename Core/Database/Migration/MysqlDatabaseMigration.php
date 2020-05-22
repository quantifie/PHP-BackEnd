<?php

namespace Core\Database\Migration;

use Core\Database\MysqlDatabaseConnectorFactory;
use Core\Database\MysqlTableProxy;
use Core\Database\DbContext;
use Core\Database\IDatabaseConnector;
use Core\Database\TableColumnAnnotation;
use Core\Database\TableUtils;
use Core\Entities\ErrorCodes;
use Core\Http\HttpResponse;
use Core\Reflections\Annotations\AnnotationModel;
use Exception;
use PDO;
use PDOException;

/**
 * Class MysqlMigrations
 * @package Core\Enums
 */
class MysqlDatabaseMigration implements IDatabaseMigration
{
	#region Public Fields
    #endregion
    
    #region Private Fields
    /**
     * @var IDatabaseConnector
     */
    private IDatabaseConnector $_connection;

    /**
     * @var DbContext
     */
    private DbContext $_context;

    private IMigrationAnnotation $_migrationAnnotation;
    #endregion
    
    #region Constructor
    /**
     * MysqlMigrations constructor.
     * @param DbContext $dbContext
     */
    public function __construct(DbContext $dbContext)
    {
        $connectorFactory = new MysqlDatabaseConnectorFactory();
        $this->_connection = $connectorFactory->GetAdminConnector();

        $this->_context = $dbContext;

        $this->_migrationAnnotation = new MysqlMigrationAnnotation();
    }
    #endregion
    
    #region Public Methods
    /**
     * @param string $databaseName
     * @param string $schemaName
     * @param string $collation
     * @return bool
     */
    public function CreateDatabase(string $databaseName, string $schemaName, string $collation): bool
    {
        $sql = "CREATE DATABASE IF NOT EXISTS {$databaseName} COLLATE " . $collation;

        try {
            $this->_connection->Pdo->exec($sql);
            return true;
        } catch (PDOException $e) {
            HttpResponse::Error($e->getMessage(), ErrorCodes::$Migration);
            return false;
        }
    }

    /**
     * @param string $databaseName
     * @return bool
     */
    public function DropDatabase(string $databaseName): bool
    {
        $sql = "DROP DATABASE IF EXISTS . {$databaseName}";

        try {
            $this->_connection->Pdo->exec($sql);
            return true;
        } catch (PDOException $e) {
            HttpResponse::Error($e->getMessage(), ErrorCodes::$Migration);
            return false;
        }
    }

    /**
     * @param string $userName
     * @param string $password
     * @param string $host
     * @return bool|mixed
     */
    public function AddUser(string $userName, string $password, string $host)
    {
        $userSql = "CREATE USER '{$userName}'@'{$host}' IDENTIFIED BY '{$password}'";
        try {
            $this->_connection->Pdo->exec($userSql);

            return true;
        } catch (PDOException $e) {
            HttpResponse::Error($e->getMessage(), ErrorCodes::$Migration);
            return false;
        }
    }

    /**
     * @param string $userName
     * @param string $host
     * @return bool|mixed
     */
    public function DropUser(string $userName, string $host)
    {
        $userSql = "DROP USER '{$userName}'@'{$host}'";
        try {
            $this->_connection->Pdo->exec($userSql);
        } catch (PDOException $e) {
            HttpResponse::Error($e->getMessage(), ErrorCodes::$Migration);
            return false;
        }
        return true;
    }

    /**
     * @param string $userName
     * @param string $host
     * @param string $databaseName
     * @return bool
     */
    public function GrantUser(string $userName, string $host, string $databaseName)
    {
        $grantSql = "GRANT ALL PRIVILEGES ON {$databaseName}.* TO '{$userName}'@'{$host}' WITH GRANT OPTION";

        try {
            $this->_connection->Pdo->exec($grantSql);
        } catch (PDOException $e) {
            HttpResponse::Error($e->getMessage(), ErrorCodes::$Migration);
            return false;
        }
        return true;
    }

    /**
     * @param string $databaseName
     * @param string $collation
     * @return bool
     * @throws Exception
     */
    public function CreateTables(string $databaseName, string $collation): bool
    {

        $allTablesCreated = true;
        /** @var MysqlTableProxy $table */
        foreach ($this->_context as $table) {
            $this->CreateTable($table, $databaseName, $collation);
        }

        return $allTablesCreated;
    }

    /**
     * @param TableColumnAnnotation $annotation
     * @return string
     */
    public function PrepareColumn(TableColumnAnnotation $annotation): string
    {
        $columnSql = '';
        if (isset($annotation->DataType)) {
            $columnSql .= " " . strtoupper($annotation->DataType);
        }

        if (isset($annotation->AutoIncrement)) {
            if (filter_var($annotation->AutoIncrement, FILTER_VALIDATE_BOOLEAN) === true)
                $columnSql .= " AUTO_INCREMENT";
        }

        if (isset($annotation->IsNullable)) {
            if (filter_var($annotation->IsNullable, FILTER_VALIDATE_BOOLEAN) === false)
                $columnSql .= " NOT NULL";
        }

        if (isset($annotation->Key)) {
            $columnSql .= " " . TableUtils::ColumnKeyToKeyType($annotation->Key);
        }

        if (isset($annotation->DefaultValue))
            $columnSql .= " DEFAULT {$annotation->DefaultValue}";

        return $columnSql;
    }

    /**
     * @param MysqlTableProxy $table
     * @param string $databaseName
     * @param string $collation
     * @throws Exception
     */
    public function CreateTable(MysqlTableProxy $table, string $databaseName, string $collation)
    {
        $tableExists = $this->CheckTableExists($table->TableName(), $databaseName);
        if ($tableExists) {
            $this->AlterTable($table, $databaseName);
        } else {
            $this->CreateTableFromScratch($table, $databaseName, $collation);
        }

    }
    #endregion
    
    #region Private Methods
    /**
     * @param string $tableName
     * @param string $databaseName
     * @return bool
     */
    private function CheckTableExists(string $tableName, string $databaseName)
    {
        $tableSql = "SELECT * FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$databaseName}' AND TABLE_NAME = '{$tableName}'";

        $query = $this->_connection->Pdo->prepare($tableSql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_OBJ);
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param MysqlTableProxy $table
     * @param string $databaseName
     * @param string $collation
     * @return bool
     * @throws Exception
     */
    private function CreateTableFromScratch(MysqlTableProxy $table, string $databaseName, string $collation)
    {
        $tableSql = "CREATE TABLE IF NOT EXISTS {$databaseName}.{$table->TableName()}";

        $tableSql .= " (";

        /** @var TableColumnAnnotation[] $annotations */
        $annotations = $this->_migrationAnnotation->GetTableColumnAnnotations($table->ClassName());

        foreach ($annotations as $annotation) {
            if ($annotation->NoSerialize === false) {
                $tableSql .= $annotation->Name;
                $tableSql .= $this->PrepareColumn($annotation);
                $tableSql .= ", ";
                if ($annotation->Indexed === true) {
                    $tableSql .= " INDEX  '{$annotation->Name}' Index ('{$annotation->Name}'),";
                }
            }
        }

        $tableSql = rtrim($tableSql, ", ");

        $tableSql .= " ) COLLATE=" . $collation;

        try {
            $this->_connection->Pdo->exec($tableSql);
        } catch (PDOException $e) {
            throw new PDOException('MySQL Table: ' . $table->TableName() . ' has not been created');
        }
        return true;
    }

    /**
     * @param MysqlTableProxy $table
     * @param string $databaseName
     * @throws Exception
     */
    private function AlterTable(MysqlTableProxy $table, string $databaseName)
    {
        $tableName = $table->TableName();
        // Get All Columns
        $columnsSql = "SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '{$databaseName}' AND TABLE_NAME = '{$tableName}'";
        $query = $this->_connection->Pdo->prepare($columnsSql);
        $query->execute();
        $columnsInTable = $query->fetchAll(PDO::FETCH_OBJ);

        if (count($columnsInTable) === 0) {
            return;
        }

        $annotations = $this->_migrationAnnotation->GetTableColumnAnnotations($table->ClassName());
        foreach ($annotations as $annotation) {
            if ($annotation->NoSerialize === false) {
                $isPropertyInColumns = $this->FindInColumns($columnsInTable, $annotation->Name);
                if ($isPropertyInColumns === true) {
                    $addSql = "ALTER TABLE {$databaseName}.{$tableName}";
                    $addSql .= " CHANGE COLUMN {$annotation->Name} {$annotation->Name} ";
                    $addSql .= $this->PrepareColumn($annotation);
                    $addSql .= ", ";
                    if ($annotation->Indexed === true) {
                        $addSql .= " ADD INDEX  '{$annotation->Name}' Index ('{$annotation->Name}'),";
                    }
                    $addSql = rtrim($addSql, ", ");
                    $this->_connection->Pdo->exec($addSql);
                } else {
                    $addSql = "ALTER TABLE {$databaseName}.{$tableName}";
                    $addSql .= " ADD COLUMN {$annotation->Name} ";
                    $addSql .= $this->PrepareColumn($annotation);
                    $addSql .= ", ";
                    if ($annotation->Indexed === true) {
                        $addSql .= " ADD INDEX  '{$annotation->Name}' Index ('{$annotation->Name}'),";
                    }
                    $addSql = rtrim($addSql, ", ");
                    $this->_connection->Pdo->exec($addSql);
                }
            }
        }

        foreach ($columnsInTable as $columnInTable) {
            $isColumnInClass = $this->FindInClassProperties($annotations, $columnInTable->COLUMN_NAME);
            if (!$isColumnInClass) {
                $dropSql = "ALTER TABLE {$databaseName}.{$tableName}";
                $dropSql .= " DROP COLUMN {$columnInTable->COLUMN_NAME}";
                $this->_connection->Pdo->exec($dropSql);
            }
        }

    }

    /**
     * @param AnnotationModel[] $properties
     * @param string $value
     * @return bool
     */
    private function FindInClassProperties(array $properties, string $value)
    {
        foreach ($properties as $property) {
            if ($property->Name === $value) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param array $columns
     * @param string $value
     * @return bool
     */
    private function FindInColumns(array $columns, string $value)
    {
        foreach ($columns as $column) {
            if (trim($column->COLUMN_NAME) === trim($value)) {
                return true;
            }
        }

        return false;
    }
    
    /**
     * @param MysqlTableProxy $table
     * @param string $databaseName
     * @return bool|mixed
     * @throws Exception
     */
    public function DropTable(MysqlTableProxy $table, string $databaseName)
    {
        $tableSql = "DROP TABLE IF EXISTS " . $databaseName . ".'{$table->TableName()}'";
        try {
            $this->_connection->Pdo->exec($tableSql);
        } catch (PDOException $e) {
            throw new PDOException('MySQL Table: ' . $table->TableName() . ' has not been dropped');
        }

        return true;
    }
    #endregion
    
    #region Helpers
        #endregion
}
