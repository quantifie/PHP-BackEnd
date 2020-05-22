<?php
	
	namespace Core\Database\Enums;

    /**
     * Class ColumnKeyTypes
     * @package Core\Database\Enums
     */
    abstract class ColumnKeyTypes
	{
        /**
         * @var string
         */
        public static string $None = '';
        /**
         * @var string
         */
        public static string $Primary = 'PRI';
        /**
         * @var string
         */
        public static string $Unique = 'UNI';
        /**
         * @var string
         */
        public static string $Multiple = 'MUL';
	}
