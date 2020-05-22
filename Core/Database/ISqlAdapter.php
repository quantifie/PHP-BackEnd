<?php

namespace Core\Database;

use Core\Database\TableActionContainers\DeleteTableData;
use Core\Database\TableActionContainers\InsertTableData;
use Core\Database\TableActionContainers\Limit;
use Core\Database\TableActionContainers\SelectTableData;
use Core\Database\TableActionContainers\UpdateTableData;

/**
 * Class BaseDatabaseActions
 * @package Options\BaseClases
 */
interface ISqlAdapter
{
    /**
     * @param SelectTableData $tableData
     * @param Limit $limit
     * @param array $wheres
     * @param array $orderBys
     * @return mixed
     */
	function Select( SelectTableData $tableData, Limit $limit, $wheres = [], $orderBys = []);
	
	/**
	 * @param $selectTableData
	 * @param $joinedTablesData
	 * @param $limit
	 * @param array $wheres
	 * @param array $orderBys
	 * @return mixed
	 */
	function Join( $selectTableData, $joinedTablesData, $limit, $wheres = [], $orderBys = [] );
	
	/**
	 * @param InsertTableData $tableData
	 * @return mixed
	 */
	function Insert( InsertTableData $tableData );
	
	/**
	 * @param UpdateTableData $tableData
	 * @param array $wheres
	 * @return mixed
	 */
	function Update( UpdateTableData $tableData, $wheres = [] );
	
	/**
	 * @param DeleteTableData $tableData
	 * @param array $wheres
	 * @return mixed
	 */
	function Delete( DeleteTableData $tableData, $wheres = [] );
}
