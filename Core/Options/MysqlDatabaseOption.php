<?php

namespace Core\Options;

use Core\Database\Enums\DatabaseTypes;

/**
 * Class DatabaseConfigs
 * @package Options
 */
class MysqlDatabaseOption implements IDatabaseOption
{
	#region Public Fields
	/**
     * @var string
     * Database Type [mysql, pgsql]
     */
    private string $_type;

    /**
     * @var string
     * Hostname
     */
    private string $_host;

    /**
     * @var string
     * Database Name
     */
    private string $_dBName;

    /**
     * @var string
     * Scheme Name
     */
    private string $_schemaName;

    /**
     * @var string
     * Database User
     */
    private string $_dbUser;

    /**
     * @var string
     * User Password
     */
    private string $_dbPassword;

    /**
     * @var string
     * Charset of database
     */
    private string $_charSet;

    /**
     * @var string
     * System User of database
     */
    private string $_adminUserName;

    /**
     * @var string
     * Password of System User
     */
    private string $_adminPassword;

    /**
     * @var string
     */
    private string $_collation;

    #endregion
    
    #region Private Fields
    #endregion
    
    #region Constructor
    /**
     * Initializes Database configs
     * @param string $host
     * @param string $databaseName
     * @param string $databaseUser
     * @param string $databasePassword
     * @param string $databaseAdmin
     * @param string $databaseAdminPassword
     * @param string $databaseScheme
     * @param string $collation
     * @param string $charSet
     */
    public function __construct(
        string $host,
        string $databaseName,
        string $databaseUser,
        string $databasePassword,
        string $databaseAdmin,
        string $databaseAdminPassword,
        string $databaseScheme = "private",
        string $collation = "utf8mb4_bin",
        string $charSet = "SET NAMES UTF8")
    {
        $this->_type = DatabaseTypes::$MySql;

        $this->_host = $host;
        $this->_dBName = $databaseName;
        $this->_dbUser = $databaseUser;
        $this->_dbPassword = $databasePassword;
        $this->_adminUserName = $databaseAdmin;
        $this->_adminPassword = $databaseAdminPassword;
        $this->_schemaName = $databaseScheme;
        $this->_collation = $collation;
        $this->_charSet = $charSet;

    }
    #endregion
    
    #region Public Methods
    public function Type() { return $this->_type; }
    public function Host() { return $this->_host; }
    public function DbName() { return $this->_dBName; }
    public function DbUser() { return $this->_dbUser; }
    public function DbPassword() { return $this->_dbPassword; }
    public function AdminUserName() { return $this->_adminUserName; }
    public function AdminPassword() { return $this->_adminPassword; }
    public function SchemaName() { return $this->_schemaName; }
    public function Collation() { return $this->_collation; }
    public function Charset() { return $this->_charSet; }
    public function HostDSN() { return $this->_type . ": host=" . $this->_host; }
    #endregion
    
    #region Private Methods
    #endregion
    
    #region Helpers
    #endregion
}
