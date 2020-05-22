<?php
	
	namespace Core\Log\Enums;

    /**
     * Class LogTypes
     * @package Core\Log\Enums
     */
    abstract class LogType
	{
        /**
         * @var string
         */
        public static string $General = 'General';

        /**
         * @var string
         */
        public static string $ReflectionClass = 'Reflection Class';

        /**
         * @var string
         */
        public static string $Application = 'Application';

        /**
         * @var string
         */
        public static string $IO = 'Input / Output';

        /**
         * @var string
         */
        public static string $Migration = 'Migration';

        /**
         * @var string
         */
        public static string $Connection = 'Connection';

        /**
         * @var string
         */
        public static string $TableActions = 'Table Actions';

        /**
         * @var string
         */
        public static string $Utilities = 'Helpers';
	}
