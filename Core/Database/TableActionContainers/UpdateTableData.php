<?php
	
	namespace Core\Database\TableActionContainers;
	
	/**
	 * Class UpdateTableData
	 * @package Libs\Enums
	 */
	class UpdateTableData extends BaseTable
	{
        /**
         * @var array
         */
        public array $ColumnsWithValues;

        /**
         * UpdateTableData constructor.
         * @param string $tableName
         * @param string $alias
         * @param array $columnsWithValues
         */
        public function __construct(string $tableName, string $alias, array $columnsWithValues )
		{
			if ( $alias === '' ) {
				$alias = $tableName.'Alias';
			}
			
			parent::__construct( $tableName, $alias, [] );
			$this->ColumnsWithValues = $columnsWithValues;
		}
	}
