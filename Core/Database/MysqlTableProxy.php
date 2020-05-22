<?php
	
	namespace Core\Database;
	
    use Core\Database\Enums\ActionTypes as ActionTypesAlias;
    use Core\Database\Enums\SelectResultTypes;
    use Core\Database\TableActionContainers\Column;
    use Core\Database\TableActionContainers\DeleteTableData;
    use Core\Database\TableActionContainers\IncludeTableData;
    use Core\Database\TableActionContainers\InsertTableData;
    use Core\Database\TableActionContainers\Limit;
    use Core\Database\TableActionContainers\OrderBy;
    use Core\Database\TableActionContainers\SelectTableData;
    use Core\Database\TableActionContainers\UpdateTableData;
    use Core\Database\TableActionContainers\Where;
    use Core\Reflections\Reflections;
    use Exception;

    /**
     * Base Class of every Data Model
     * It contains all Table Actions (CRUD-J)
     * This class does only the preparations of Sql Statements
     * the actual execution of sql statements is going to be done via MysqlTableActions or PostgresTableActions
	 * @package Core
	 */
	class MysqlTableProxy implements ITableProxy
	{
	    #region Public fields
        #endregion
        
        #region Private fields
        private string $_tableName;
        private string $_className;
        /**
         * All data that Select Claus needs
         * @var SelectTableData
         */
        private ?SelectTableData $_selectTable;

        /**
         * All data that Update Claus needs
         * @var UpdateTableData
         */
        private ?UpdateTableData $_updateTable;

        /**
         * All data that Insert Claus needs
         * @var InsertTableData
         */
        private ?InsertTableData $_insertTable;

        /**
         * All data that Delete Claus needs
         * @var DeleteTableData
         */
        private ?DeleteTableData $_deleteTable;

        /**
         * All data that Where Clauses needs
         * @var array
         */
        private ?array $_wheres = [];

        /**
         * All data that Limit Claus needs
         * @var Limit
         */
        private ?Limit $_limit;

        /**
         * All data that Order By Claus needs
         * @var array
         */
        private ?array $_orderBys = [];

        /**
         * Current action type that Result method executes
         * @var int
         */
        private int $_actionType;

        #endregion
        
        #region Constructor
        /**
         * DbSet constructor.
         * @param string $tableName
         * @throws Exception
         */
        public function __construct(string $tableName)
		{
            $this->_className = $tableName;
			$this->Reset();

			// Set table name to plural for better consistency
			$this->_tableName = $this->SetTableNamePlural($tableName);
            $this->_limit = new Limit(0,0);
		}
        #endregion
        
        #region Public Methods
        public function TableName(){
            return $this->_tableName;
        }

        public function ClassName() {
            return $this->_className;
        }
		
        /**
         * @param string[] $columns Name of the columns to select
         * @param string $alias Alias of table name
         * @param IncludeTableData[] $includeTablesData
         * @return MysqlTableProxy
         */
		public function Select(array $columns = [], array $includeTablesData = [], string $alias = '')
		{
            $tableColumns = $this->PrepareTableColumnsForSelect($columns);
            
            foreach ($includeTablesData as $subIncludeTableData) {
                $subIncludeTableData->Columns = $this->PrepareTableColumnsForSelect($subIncludeTableData->Columns);
            }

			// Populate all data for Select Clause
			$this->_selectTable = new SelectTableData( $this->_tableName, $alias, $includeTablesData, $tableColumns);

			// Set action type to select
			$this->_actionType = ActionTypesAlias::$Select;

			// Return this class for fluent interface
            return $this;
		}

		/**
		 * @return bool|MysqlTableProxy|MysqlTableProxy[]|int
		 */
		public function List()
		{
			$this->_selectTable->ReturnType = SelectResultTypes::$List;
			return $this->Result();
		}

		/**
		 * @return MysqlTableProxy|int|bool|MysqlTableProxy[]
		 */
		public function Result()
		{
            $tableAdapter = new MysqlSqlAdapter();
            $result = "";

            switch ( $this->_actionType ) {
				case ActionTypesAlias::$Select:
					{
						$result = $tableAdapter->Select( $this->_selectTable, $this->_limit, $this->_wheres, $this->_orderBys);
						break;
					}
				case ActionTypesAlias::$Insert:
					{
                        $result = $tableAdapter->Insert( $this->_insertTable );
						break;
					}
				case ActionTypesAlias::$Update:
					{
						$result = $tableAdapter->Update( $this->_updateTable, $this->_wheres );
						break;
					}
				case ActionTypesAlias::$Delete:
					{
						$result = $tableAdapter->Delete( $this->_deleteTable, $this->_wheres );
						break;
					}
					/*
				case ActionTypesAlias::$Join:
					{
						$result = $databaseActions->Join( $this->SelectTable,
							$this->JoinedTables,
							$this->Limit,
							$this->Wheres,
							$this->OrderBys );
						break;
					}*/
				default:
					break;
			}
			$this->Reset();
			return $result;
		}

		/**
		 * @return bool|MysqlTableProxy|MysqlTableProxy[]|int
		 */
		public function Single()
		{
			$this->_selectTable->ReturnType = SelectResultTypes::$Single;
			return $this->Result();
		}
		
		/**
		 * @param array $columnsWithValues
		 * @return bool|int|object|object[]
		 */
		public function Insert( array $columnsWithValues )
		{

            $this->_insertTable = new InsertTableData( $this->_tableName, $columnsWithValues );
			$this->_actionType = ActionTypesAlias::$Insert;

            return $this->Result();
        }
		
		/**
		 * @param array $columnsWithValues
		 * @param string $tableAlias
		 * @return MysqlTableProxy
		 */
		public function Update( array $columnsWithValues, $tableAlias = '' )
		{
			$this->_updateTable = new UpdateTableData( $this->_tableName, $tableAlias, $columnsWithValues );
			
			$this->_actionType = ActionTypesAlias::$Update;
			
			return $this;
		}
		
        /**
         * @return MysqlTableProxy
         */
		public function Delete()
		{
			$this->_deleteTable = new DeleteTableData( $this->_tableName );
			
			$this->_actionType = ActionTypesAlias::$Delete;
			
			return $this;
		}
		
		/**
		 * @param string $columnName
		 * @param string $keyValueOperator
		 * @param string $logicalOperator
		 * @param string|int|double|bool $value
		 * @return MysqlTableProxy
		 */
		public function Where( string $columnName, string $keyValueOperator, $value, string $logicalOperator = '' )
		{
			$newWhere = new Where( $columnName, $keyValueOperator, $value, $logicalOperator );
			
			array_push( $this->_wheres, $newWhere );
			
			return $this;
		}

        /**
         * @param int $limit
         * @param int $offset
         * @return MysqlTableProxy
         */
        public function Limit( int $limit, int $offset = 0 )
        {
            $this->_limit = new Limit( $limit, $offset );
            return $this;
        }

        /**
         * @param string $columnName
         * @param string $orderType
         * @return MysqlTableProxy
         */
        public function OrderBy( string $columnName, string $orderType )
        {
            $newOrderBy = new OrderBy( $columnName, $orderType );

            array_push( $this->_orderBys, $newOrderBy );

            return $this;
        }
		#endregion
        
        #region Private Methods
        /**
         * @return void
         */
        private function Reset()
        {
            $this->_wheres = [];
            $this->_orderBys = [];
        }

        /**
         * @param array $columns
         * @return array
         */
        private function PrepareTableColumnsForSelect(array $columns): array
        {
            $tableColumns = [];

            // Add columns aliases if they provided
            foreach ($columns as $key => $value) {
                if (is_int($key)) {
                    $tableColumn = new Column($value, "");
                } else {
                    $tableColumn = new Column($key, $value);
                }

                array_push($tableColumns, $tableColumn);
            }
            return $tableColumns;
        }

        /**
         * @param string $tableName
         * @return string
         * @throws Exception
         */
        private function SetTableNamePlural(string $tableName): string
        {
            $reflections = new Reflections($tableName);
            $tableName = $reflections->ShortName();
            $trimmedTableName = $tableName;
            $lastChar = substr( $tableName, -1 );
            if ( $lastChar == 'y' ) {
                $additionalChar = 'ies';
                $trimmedTableName = substr( $tableName, 0, -1 );
            } elseif ( $lastChar == 's' ) {
                $additionalChar = 'es';
            } else {
                $additionalChar = 's';
            }

            return $trimmedTableName.$additionalChar;
        }
		#endregion
	}
