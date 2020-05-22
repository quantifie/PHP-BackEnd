<?php


namespace Core\Database;


interface ITableProxy
{
    function TableName();

    function ClassName();

    function Select(array $columns = [], array $includeTablesData = [], string $alias = '');

    function List();

    function Result();

    function Single();

    function Insert(array $columnsWithValues);

    function Update(array $columnsWithValues, $tableAlias = '');

    function Delete();

    function Where(string $columnName, string $keyValueOperator, $value, string $logicalOperator = '');

    function Limit(int $limit, int $offset = 0);

    function OrderBy(string $columnName, string $orderType);
}