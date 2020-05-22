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
    private string $_type ;

    /**
     * @var string
     * Hostname
     */
    private string $_host = "localhost";

    /**
     * @var string
     * Database Name
     */
    private string $_dBName = "DefaultDatabase";

    /**
     * @var string
     * Scheme Name
     */
    private string $_schemaName = "private";

    /**
     * @var string
     * Database User
     */
    private string $_dbUser= "DefaultUser";

    /**
     * @var string
     * User Password
     */
    private string $_dbPassword = "DefaultPassword";

    /**
     * @var string
     * Charset of database
     */
    private string $_charSet = "SET NAMES UTF8";

    /**
     * @var string
     * System User of database
     */
    private string $_adminUserName = "";

    /**
     * @var string
     * Password of System User
     */
    private string $_adminPassword = "";

    /**
     * @var string
     */
    private string $_collation = "utf8mb4_bin";

    #endregion
    
    #region Private Fields
    #endregion
    
    #region Constructor
    /**
     * Initializes Database configs
     * @param string|null $databaseType
     * @param string|null $host
     * @param string|null $databaseName
     * @param string|null $databaseUser
     * @param string|null $databasePassword
     * @param string|null $databaseAdmin
     * @param string|null $databaseAdminPassword
     * @param string|null $databaseScheme
     * @param string|null $collation
     * @param string|null $charSet
     */
    public function __construct(
        string $host = null,
        string $databaseName = null,
        string $databaseUser = null,
        string $databasePassword = null,
        string $databaseAdmin = null,
        string $databaseAdminPassword = null,
        string $databaseScheme = null,
        string $collation = null,
        string $charSet = null)
    {
        $this->_type = DatabaseTypes::$MySql;

        if(isset($host))
            $this->_host = $host;

        if(isset($databaseName))
            $this->_dBName = $databaseName;

        if(isset($databaseUser))
            $this->_dbUser = $databaseUser;

        if(isset($databasePassword))
            $this->_dbPassword = $databasePassword;

        if(isset($databaseAdmin))
            $this->_adminUserName = $databaseAdmin;

        if(isset($databaseAdminPassword))
            $this->_adminPassword = $databaseAdminPassword;

        if(isset($databaseScheme))
            $this->_schemaName = $databaseScheme;

        if(isset($collation))
            $this->_collation = $collation;

        if(isset($charSet))
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
