<?php
	
	namespace Core\Database\TableActionContainers;
	
	/**
	 * Class DeleteTableData
	 * @package Libs\Enums
	 */
	class DeleteTableData extends BaseTable
	{
		/**
		 * DeleteTableData constructor.
		 * @param string $tableName
		 */
		public function __construct( string $tableName )
		{
			parent::__construct( $tableName, '', [] );
		}
	}
