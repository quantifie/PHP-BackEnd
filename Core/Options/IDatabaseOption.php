<?php


namespace Core\Options;


interface IDatabaseOption
{
    function __construct(
        string $host,
        string $databaseName,
        string $databaseUser,
        string $databasePassword,
        string $databaseAdmin,
        string $databaseAdminPassword,
        string $databaseScheme,
        string $collation,
        string $charSet);

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