<?php
	
	namespace Core\Database\Enums;

    /**
     * Class KeyValueOperators
     * @package Core\Database\Enums
     */
    abstract class KeyValueOperators
	{
        /**
         * @var string
         */
        public static string $Equal = "=";

        /**
         * @var string
         */
        public static string $NotEqual = "!=";

        /**
         * @var string
         */
        public static string $Greater = ">";
        /**
         * @var string
         */
        public static string $GreaterEqual = ">=";
        /**
         * @var string
         */
        public static string $Less = "<";
        /**
         * @var string
         */
        public static string $LessEqual = "<=";
        public static string $In = "IN";
        public static string $NotIn = "NOT IN";
	}
