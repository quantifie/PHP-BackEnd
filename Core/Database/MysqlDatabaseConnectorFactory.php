<?php


namespace Core\Database;


use Core\Database\Migration\MysqlAdminDatabaseConnector;
use Core\Options\IDatabaseOption;

class MysqlDatabaseConnectorFactory implements IDatabaseConnectorFactory
{
    private static IDatabaseOption $_databaseOption;

    public function __construct()
    {
    }

    public function SetDatabaseOption(IDatabaseOption $databaseOption)
    {
        self::$_databaseOption = $databaseOption;
    }

    public function GetConnector(): IDatabaseConnector
    {
        return MysqlDatabaseConnector::Get(self::$_databaseOption);
    }

    public function GetAdminConnector(): IDatabaseConnector
    {
        return MysqlAdminDatabaseConnector::Get(self::$_databaseOption);
    }
}