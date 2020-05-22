<?php
	
	namespace Core\Database\Enums;

    /**
     * Class JoinTypes
     * @package Core\Database\Enums
     */
    abstract class JoinTypes
	{
        /**
         * @var string
         */
        public static string $Inner = 'INNER';
        /**
         * @var string
         */
        public static string $Right = 'RIGHT';
        /**
         * @var string
         */
        public static string $Left = 'LEFT';
        /**
         * @var string
         */
        public static string $Full = 'FULL';
	}
