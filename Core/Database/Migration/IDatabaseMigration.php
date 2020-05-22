<?php
	
namespace Core\Database\Migration;


use Core\Database\MysqlTableProxy;
use Core\Database\TableColumnAnnotation;

/**
 * Class BaseDatabaseActions
 * @package Core\Database
 */
interface IDatabaseMigration
{
    /**
     * @param string $databaseName
     * @param string $schemaName
     * @param string $collation
     * @return mixed
     */
    function CreateDatabase(string $databaseName, string $schemaName, string $collation);

    /**
     * @param string $databaseName
     * @return mixed
     */
    function DropDatabase(string $databaseName );

    /**
     * @param string $userName
     * @param string $password
     * @param string $host
     * @return mixed
     */
    function AddUser(string $userName, string $password, string $host );

    /**
     * @param string $userName
     * @param string $host
     * @param string $databaseName
     * @return mixed
     */
    function GrantUser(string $userName, string $host, string $databaseName );

    /**
     * @param string $databaseName
     * @param string $collation
     * @return mixed
     */
    function CreateTables(string $databaseName, string $collation);

    /**
     * @param MysqlTableProxy $table
     * @param string $databaseName
     * @param string $collation
     * @return mixed
     */
    function CreateTable(MysqlTableProxy $table, string $databaseName, string $collation);

    /**
     * @param MysqlTableProxy $table
     * @param string $databaseName
     * @return mixed
     */
    function DropTable(MysqlTableProxy $table, string $databaseName );

    /**
     * @param TableColumnAnnotation $annotation
     * @return mixed
     */
    function PrepareColumn(TableColumnAnnotation $annotation );
}
