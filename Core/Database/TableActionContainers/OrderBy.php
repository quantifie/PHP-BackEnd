<?php
	
	namespace Core\Database\TableActionContainers;
	
	/**
	 * Class OrderBy
	 * @package Libs\Enums
	 */
	class OrderBy
	{
        /**
         * @var string
         */
        public string $Column;

        /**
         * @var string
         */
        public string $OrderType;

        /**
         * OrderBy constructor.
         * @param string $columnName
         * @param string $orderType
         */
        public function __construct(string $columnName, string $orderType )
		{
			$this->Column = $columnName;
			$this->OrderType = $orderType;
		}
	}
