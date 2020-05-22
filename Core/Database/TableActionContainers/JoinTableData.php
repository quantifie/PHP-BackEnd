<?php
	
	namespace Core\Database\TableActionContainers;
	
	/**
	 * Class JoinTableData
	 * @package Libs\Enums
	 */
	class JoinTableData extends BaseTable
	{
        /**
         * @var string
         */
        public string $FirstTableName;

        /**
         * @var string
         */
        public string $FirstTableAlias;

        /**
         * @var string
         */
        public string $FirstTableColumn;

        /**
         * @var string
         */
        public string $SecondTableName;

        /**
         * @var string
         */
        public string $SecondTableAlias;

        /**
         * @var string
         */
        public string $SecondTableColumn;

        /**
         * @var array
         */
        public array $FirstTableSelectColumns;
        /**

        /**
         * @var array
         */
        public array $SecondTableSelectColumns;

        /**
         * @var string
         */
        public string $JoinType;


        /**
         * JoinTableData constructor.
         * @param string $firstTableName
         * @param string $firstTableAlias
         * @param string $firstTableColumn
         * @param string $joinType
         * @param string $secondTableName
         * @param string $secondTableAlias
         * @param string $secondTableColumn
         * @param array $firstTableSelectColumns
         * @param array $secondTableSelectColumns
         */
        public function __construct(string $firstTableName,
                                    string $firstTableAlias,
                                    string $firstTableColumn,
                                    string $joinType,
                                    string $secondTableName,
                                    string $secondTableAlias,
                                    string $secondTableColumn,
                                    array $firstTableSelectColumns = [],
                                    array $secondTableSelectColumns = [])
		{
		    parent::__construct($firstTableName, $firstTableAlias, $firstTableSelectColumns);
            $this->FirstTableName = $firstTableName;
            $this->FirstTableAlias = $firstTableAlias;
            $this->FirstTableColumn = $firstTableColumn;
            $this->FirstTableSelectColumns = $firstTableSelectColumns;

            $this->SecondTableName = $secondTableName;
            $this->SecondTableAlias = $secondTableAlias;
            $this->SecondTableColumn = $secondTableColumn;
            $this->SecondTableSelectColumns = $secondTableSelectColumns;

			$this->JoinType = $joinType;
		}
	}
