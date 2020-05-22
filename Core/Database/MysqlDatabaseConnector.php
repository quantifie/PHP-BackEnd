<?php

namespace Core\Database;

    use Core\Http\HttpResponse;
    use Core\Options\IDatabaseOption;
    use PDO;
    use PDOException;

    /**
     * Class MysqlConnection
     * @package Core\Enums
     */
    class MysqlDatabaseConnector implements IDatabaseConnector
    {
        #region Public Fields
        #endregion

        #region Private Fields
        #endregion

        #region Public Methods
        private static MysqlDatabaseConnector $_instance;
        #endregion

        #region Private Methods
        #endregion

        #region Helpers
        #endregion

        public PDO $Pdo;

        /**
         * MysqlConnection constructor.
         * @param IDatabaseOption $databaseOption
         */
        private function __construct(IDatabaseOption $databaseOption)
        {
            try {
                $this->Pdo = new PDO(
                    $databaseOption->HostDSN() . ';dbname=' . $databaseOption->DBName(),
                    $databaseOption->DbUser(),
                    $databaseOption->DbPassword(),
                    [PDO::MYSQL_ATTR_INIT_COMMAND => $databaseOption->CharSet()]);

            } catch (PDOException $th) {
                HttpResponse::Error("User connection {$th->getMessage()}", 101);
            }
        }

        public static function Get(IDatabaseOption $databaseOption){
            if (!isset(self::$_instance))
                self::$_instance = new MysqlDatabaseConnector($databaseOption);

            return self::$_instance;
        }
    }
