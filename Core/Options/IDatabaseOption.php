<?php


namespace Core\Options;


interface IDatabaseOption
{
    function __construct(
        string $host = null,
        string $databaseName = null,
        string $databaseUser = null,
        string $databasePassword = null,
        string $databaseAdmin = null,
        string $databaseAdminPassword = null,
        string $databaseScheme = null,
        string $collation = null,
        string $charSet = null);

    function Type();
    function Host();
    function DbName();
    function DbUser();
    function DbPassword();
    function AdminUserName();
    function AdminPassword();
    function SchemaName();
    function Collation();
    function Charset();
    function HostDSN();
}