<?php /** @noinspection SqlWithoutWhere */

namespace Core\Database;

use Core\Database\Enums\KeyValueOperators;
use Core\Database\Enums\SelectResultTypes;
use Core\Database\TableActionContainers\BaseTable;
use Core\Database\TableActionContainers\DeleteTableData;
use Core\Database\TableActionContainers\IncludeTableData;
use Core\Database\TableActionContainers\InsertTableData;
use Core\Database\TableActionContainers\Limit;
use Core\Database\TableActionContainers\OrderBy;
use Core\Database\TableActionContainers\SelectTableData;
use Core\Database\TableActionContainers\UpdateTableData;
use Core\Database\TableActionContainers\Where;
use Core\Log\Enums\LogType;
use Core\Log\Enums\PriorityType;
use Core\Log\ILogger;
use Core\Log\MysqlLogger;
use \PDO;
use PDOException;
use PDORow;
use PDOStatement;

/**
 * Table Actions (CRUD) on MySQL database
 * This class does only the preparations of Sql String
 * the actual execution of sql statement is going to be done via MysqlTableActions
 * @package Core\Database
 */
class MysqlSqlAdapter implements ISqlAdapter
{
	#region Public Fields
    #endregion

    #region Private Fields
    /**
     * @var MysqlDatabaseConnector
     */
    private IDatabaseConnector $_mysqlConnection;
    private ILogger $logger;
    #endregion

    #region Constructor
    /**
     * MysqlTableActions constructor.
     * @param IDatabaseConnector $databaseConnector
     */
    public function __construct()
    {
        $connectorFactory = new MysqlDatabaseConnectorFactory();
        $this->_mysqlConnection = $connectorFactory->GetConnector();
        $context = new DbContext();
        $this->logger = new MysqlLogger($context->Logs);
    }
    #endregion

    #region Public Methods
    /**
     * @param SelectTableData $tableData
     * @param Limit $limit
     * @param Where[] $wheres
     * @param OrderBy[] $orderBys
     * @return array|null|object
     */
    public function Select(SelectTableData $tableData, ?Limit $limit, $wheres = [], $orderBys = [])
    {
        $selectString = "SELECT ";

        $selectString .= $this->CorrectColumns($tableData);

        $selectString = trim($selectString, " \,");
        $selectString .= " FROM {$tableData->Name} AS {$tableData->Alias}";
        $selectString = trim($selectString, " ");
        $selectString .= $this->PrepareWhere($tableData, $wheres);
        $selectString .= $this->PrepareOrderBy($tableData, $orderBys);

        if (isset($limit) && $limit->Limit > 0) {
            $selectString .= " LIMIT {$limit->Offset} , {$limit->Limit}";
        }
        if (!isset($this->_mysqlConnection->Pdo)){
            return [];
        }

        $query = $this->_mysqlConnection->Pdo->prepare($selectString);

        $this->BindValuesWithWhere($wheres, $query);

        try {
            $query->execute();
        } catch (PDOException $ex) {
            $this->logger->Write("MySql Select clause", "Select Sql execution error on {$tableData->Name} table",
                LogType::$TableActions, PriorityType::$Error, $ex->getMessage());
            return null;
        }

        $selectResult = $query->fetchAll(PDO::FETCH_OBJ);

        if(count($tableData->IncludeTablesData) > 0) {
            $selectResult = $this->PrepareIncludes($selectResult, $tableData->IncludeTablesData);
        }

        if (count($selectResult) === 0 && $tableData->ReturnType === SelectResultTypes::$List) {
            return [];
        }

        if ($tableData->ReturnType === SelectResultTypes::$Single)
            if (count($selectResult) > 0)
                $selectResult = $selectResult[0];
            else $selectResult = null;


        return $selectResult;
    }

    /**
     * @param InsertTableData $tableData
     * @return PDORow|null
     */
    public function Insert(InsertTableData $tableData)
    {
        $insertString = "INSERT INTO {$tableData->Name} {$tableData->Alias} (";

        if (count($tableData->ColumnsWithValues) > 0) {
            foreach ($tableData->ColumnsWithValues as $key => $value) {
                if ($tableData->Alias !== "") $insertString .= "{$tableData->Alias}.";
                $insertString .= $key;
                $insertString .= ",";
            }
            $insertString = trim($insertString, "\,");
        }
        $insertString .= ") VALUES(";

        if (count($tableData->ColumnsWithValues) > 0) {
            foreach ($tableData->ColumnsWithValues as $key => $value) {
                if ($tableData->Alias !== "") $insertString .= "{$tableData->Alias}.";
                $insertString .= ":" . $key;
                $insertString .= ",";
            }
            $insertString = trim($insertString, "\,");
        }

        $insertString .= ") ";

        if (!isset($this->_mysqlConnection->Pdo) )
            return null;

        $query = $this->_mysqlConnection->Pdo->prepare($insertString);

        foreach ($tableData->ColumnsWithValues as $key => $value) {
            $query->bindValue(":{$key}", $value);
        }

        try {
            $query->execute();
        } catch (PDOException $ex) {
            throw new PDOException($ex);
        }

        $result = $query->rowCount();

        if ($result > 0) {
            return $this->ReturnLastRecord($tableData->Name, "Id")[0];
        } else {
            return null;
        }
    }

    /**
     * @param UpdateTableData $tableData
     * @param Where[] $wheres
     * @return int|null
     */
    public function Update(UpdateTableData $tableData, $wheres = [])
    {
        $updateString = "UPDATE {$tableData->Name} {$tableData->Alias} SET ";

        if (count($tableData->ColumnsWithValues) > 0) {
            foreach ($tableData->ColumnsWithValues as $key => $value) {
                if ($tableData->Alias !== "") $updateString .= "{$tableData->Alias} .";
                $updateString .= $key . " = :" . $key;
                $updateString .= ", ";
            }
            $updateString = trim($updateString, "\, ");
        }

        $updateString .= $this->PrepareWhere($tableData, $wheres);

        if (!isset($this->_mysqlConnection->Pdo) )
            return null;

        $query = $this->_mysqlConnection->Pdo->prepare($updateString);

        foreach ($tableData->ColumnsWithValues as $key => $value) {
            $query->bindValue(":" . $key, $value);
        }

        $this->BindValuesWithWhere($wheres, $query);

        try {
            $query->execute();
        } catch (PDOException $ex) {
            $this->logger->Write("MySql Update clause", "Update Sql execution error on {$tableData->Name} table",
                LogType::$TableActions, PriorityType::$Error, $ex->getMessage());
            return null;
        }

        return $query->rowCount();
    }

    /**
     * @param DeleteTableData $tableData
     * @param Where[] $wheres
     * @return int|bool
     */
    public function Delete(DeleteTableData $tableData, $wheres = [])
    {
        $deleteString = "DELETE FROM {$tableData->Name} {$tableData->Alias}";

        $deleteString .= $this->PrepareWhere($tableData, $wheres);

        if (!isset($this->_mysqlConnection->Pdo) )
            return null;

        $query = $this->_mysqlConnection->Pdo->prepare($deleteString);

        $this->BindValuesWithWhere($wheres, $query);

        try {
            $query->execute();
        } catch (PDOException $ex) {
            $this->logger->Write("MySql Delete clause", "Delete Sql execution error on {$tableData->Name} table",
                LogType::$TableActions, PriorityType::$Error, $ex->getMessage());
            return null;
        }

        return $query->rowCount();
    }

    /**
     * @inheritDoc
     */
    public function Join($selectTableData, $joinedTablesData, $limit, $wheres = [], $orderBys = [])
    {
        // TODO: Implement Join() method.
    }
    #endregion

    #region Private Methods
    /**
     * @param array $selectRecords
     * @param IncludeTableData[] $includeTablesData
     * @return array|object
     */
    private function PrepareIncludes(array $selectRecords, array $includeTablesData): array {
        foreach ($selectRecords as $selectRecord){
            foreach ($includeTablesData as $includeTableData) {

                $selectTableData = new SelectTableData($includeTableData->Name, "", $includeTableData->IncludeTableData,
                    $includeTableData->Columns, $includeTableData->ResultType);

                if ($includeTableData->Recursive) {
                    $newIncludes = new IncludeTableData($includeTableData->Name,
                        $includeTableData->IncludeComparisonColumn,  $includeTableData->Property, $includeTableData->ComparisonColumn,
                        true, $includeTableData->ResultType, $includeTableData->Columns, $includeTableData->IncludeTableData, $includeTableData->Wheres);
                    array_push($selectTableData->IncludeTablesData, $newIncludes);
                }

                $wheres = [];
                foreach ($includeTableData->Wheres as $includeWhere) {
                    array_push($wheres, $includeWhere);
                }

                $where = new Where($includeTableData->IncludeComparisonColumn, KeyValueOperators::$Equal, $selectRecord->{$includeTableData->ComparisonColumn});
                array_push($wheres, $where);

                $resultForInclude = $this->Select($selectTableData, null, $wheres);
                if ($resultForInclude === false)
                    $selectRecord->{$includeTableData->Property} = null;
                else{
                    $selectRecord->{$includeTableData->Property} = $resultForInclude;
                }
            }
        }

        return $selectRecords;
    }
    /**
     * @param BaseTable $tableData
     * @param Where[] $wheres
     * @return string
     */
    private function PrepareWhere($tableData, $wheres = [])
    {
        $whereString = "";
        if (count($wheres) > 0) {
            $whereString .= " WHERE ";
            foreach ($wheres as $where) {
                if ($tableData->Alias !== "") {
                    $whereString .= "{$tableData->Alias}.";
                }

                if ($where->Operator === KeyValueOperators::$In || $where->Operator === KeyValueOperators::$NotIn) {
                    $items = explode(",", $where->Value);
                    $inItemString = "";
                    foreach ($items as $item) {
                        $inItemString .= ":{$item},";
                    }
                    $inItemString = rtrim($inItemString, ",");
                    $whereString .= "{$where->Column} {$where->Operator}({$inItemString})";
                } else {
                    $whereString .= "{$where->Column}{$where->Operator}:$where->Column";
                }
                if (isset($where->LogicalOperator)) {
                    $whereString .= " {$where->LogicalOperator} ";
                }
            }
        }
        return $whereString;
    }

    /**
     * @param BaseTable $tableData
     * @param OrderBy[] $orderBys
     * @return string
     */
    private function PrepareOrderBy($tableData, $orderBys = [])
    {
        $orderByString = " ";

        if (count($orderBys) > 0) {
            $orderByString .= " ORDER BY ";
            foreach ($orderBys as $orderBy) {
                if ($tableData->Alias !== "") {
                    $orderByString .= "{$tableData->Alias}.";
                } else {
                    $orderByString .= "{$tableData->Name}.";
                }

                $orderByString .= "{$orderBy->Column} {$orderBy->OrderType}, ";
            }
            $orderByString = rtrim($orderByString, " \,");
        }

        return $orderByString;
    }

    /**
     * @param BaseTable $tableData
     * @return string
     */
    private function CorrectColumns(BaseTable $tableData)
    {
        $returnString = "";
        if (count($tableData->Columns) > 0) {
            foreach ($tableData->Columns as $column) {
                if ($tableData->Alias !== "")
                    $returnString .= "{$tableData->Alias}.";
                $returnString .= $column->Name;
                if ($column->Alias !== "") $returnString .= " AS {$column->Alias}";
                $returnString .= ", ";
            }
        } else {
            $returnString .= "*";
        }
        return $returnString;
    }

    /**
     * @param string $tableName
     * @param string $key
     * @return array
     */
    private function ReturnLastRecord(string $tableName, string $key): array
    {
        $newRecordSql = "SELECT * FROM {$tableName} WHERE {$key}={$this->_mysqlConnection->Pdo->lastInsertId()}";

        if (!isset($this->_mysqlConnection->Pdo) )
            return [];

        $recordQuery = $this->_mysqlConnection->Pdo->prepare($newRecordSql);
        $recordQuery->execute();
        return $recordQuery->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @param Where[] $wheres
     * @param PDOStatement $query
     * @return PDOStatement
     */
    private function BindValuesWithWhere(array $wheres, PDOStatement &$query){
        foreach ($wheres as $where) {
            if ($where->Operator === KeyValueOperators::$In || $where->Operator === KeyValueOperators::$NotIn) {
                $items = explode(",", $where->Value);
                foreach ($items as $item) {
                    $query->bindValue(":{$item}", $item);
                }
            } else {
                $query->bindValue(":{$where->Column}", $where->Value);
            }
        }

        return $query;
    }
    #endregion
}
