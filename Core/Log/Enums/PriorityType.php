<?php
	
	namespace Core\Log\Enums;

    /**
     * Class PriorityTypes
     * @package Core\Log\Enums
     */
    abstract class PriorityType
	{
        /**
         * @var string
         */
        public static string $Warning = "Warning";

        /**
         * @var string
         */
        public static string $Info = "Info";

        /**
         * @var string
         */
        public static string $Error = "Error";

        /**
         * @var string
         */
        public static string $FatalError = "Fatal Error";
	}
