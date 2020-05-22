<?php
	
	namespace Core\Database\Migration;

    use Core\Database\IDatabaseConnector;
    use Core\Entities\ErrorCodes;
    use Core\Http\HttpResponse;
    use Core\Options\IDatabaseOption;
    use PDO;
	use PDOException;
	
	/**
	 * Class MysqlConnection
	 * @package Core\Enums
	 */
	class MysqlAdminDatabaseConnector implements IDatabaseConnector
	{
		#region Public Fields
        /**
         * @var PDO
         */
        public PDO $Pdo;
        #endregion
        
        #region Private Fields
        private static MysqlAdminDatabaseConnector $_instance;
        #endregion

        #region Constructor
        /**
         * MysqlAdminConnection constructor.
         * @param IDatabaseOption $databaseOption
         */
        private function __construct(IDatabaseOption $databaseOption)
        {
            try {
                $this->Pdo = new PDO(
                    $databaseOption->HostDSN(),
                    $databaseOption->AdminUserName(),
                    $databaseOption->AdminPassword() );

            } catch ( PDOException $th ) {
                HttpResponse::Forbidden("Admin connection Error: {$th->getMessage()}", ErrorCodes::$Connection);
            }
        }
        #endregion

        #region Public Methods
        public static function Get(IDatabaseOption $databaseOption){
            if (!isset(self::$_instance))
                self::$_instance = new MysqlAdminDatabaseConnector($databaseOption);

            return self::$_instance;
        }
        #endregion
        
        #region Private Methods
        #endregion
        
        #region Helpers
        #endregion
	}
