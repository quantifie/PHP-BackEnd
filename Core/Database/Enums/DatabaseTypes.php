<?php
	
	namespace Core\Database\Enums;

    /**
     * Class DatabaseTypes
     * @package Core\Database\Enums
     */
    abstract class DatabaseTypes
	{
        /**
         * @var string
         */
        public static string $Postgres = 'pgsql';
        /**
         * @var string
         */
        public static string $MySql = 'mysql';
	}
