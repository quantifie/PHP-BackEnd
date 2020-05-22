<?php
	
	namespace Core\Database\TableActionContainers;
	
	/**
	 * Class InsertTableData
	 * @package Libs\Enums
	 */
	class InsertTableData extends BaseTable
	{
        /**
         * @var array
         */
        public array $ColumnsWithValues;

        /**
         * InsertTableData constructor.
         * @param string $tableName
         * @param array $columnsWithValues
         */
        public function __construct(string $tableName, $columnsWithValues = [] )
		{
			parent::__construct( $tableName, '', [] );
			$this->ColumnsWithValues = $columnsWithValues;
		}
	}
