<?php
	
	namespace Core\Database\TableActionContainers;
	
	
	/**
	 * Class Where
	 * @package Libs\Enums
	 */
	class Where
	{
        /**
         * @var string
         */
        public string $Column;

        /**
         * @var string
         */
        public string $Operator;

        /**
         * @var string
         */
        public string $Value;

        /**
         * @var string
         */
        public string $LogicalOperator;

        /**
         * Where constructor.
         * @param string $columnName
         * @param string $operator
         * @param string $value
         * @param string $logicalOperator
         */
        public function __construct(string $columnName, string $operator, string $value, string $logicalOperator = "" )
		{
			$this->Column = $columnName;
			$this->Operator = $operator;
			$this->Value = $value;
			$this->LogicalOperator = $logicalOperator;
		}
	}
