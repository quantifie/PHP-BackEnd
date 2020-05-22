<?php
	
	namespace Core\Database\Enums;
	
	/**
	 * Class ActionTypes
	 * @package Entities\Enums\Enums
	 */
	abstract class ActionTypes
	{
        /**
         * @var int
         */
        public static int $Select = 0;
        /**
         * @var int
         */
        public static int $Insert = 1;
        /**
         * @var int
         */
        public static int $Update = 2;
        /**
         * @var int
         */
        public static int $Delete = 3;

        /**
         * @var int
         */
        public static int $Join = 4;

        /**
         * @var int
         */
        public static int $Execute = 5;
	}
