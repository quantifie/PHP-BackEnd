<?php
	
	namespace Core\Database\TableActionContainers;
	
	/**
	 * Class SelectTableData
	 * @package Libs\Enums
	 */
	class SelectTableData extends BaseTable
	{
        /**
         * @var int
         */
        public int $ReturnType;
        
        /**
         * @var IncludeTableData[]
         */
        public array $IncludeTablesData;

        /**
         * SelectTableData constructor.
         * @param string $tableName
         * @param string $alias
         * @param IncludeTableData[] $includeTablesData
         * @param Column[] $columns
         * @param int $resultType
         */
        public function __construct(string $tableName,
                                    string $alias = "",
                                    array $includeTablesData = [],
                                    array $columns = [],
                                    int $resultType = 0 )
		{
			if ( $alias === "" ) {
				$alias = "{$tableName}Alias";
			}

			parent::__construct( $tableName, $alias, $columns );
			
			$this->ReturnType = $resultType;
			$this->IncludeTablesData = $includeTablesData;
		}
	}
