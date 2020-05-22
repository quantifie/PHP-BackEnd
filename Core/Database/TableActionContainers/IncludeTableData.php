<?php


namespace Core\Database\TableActionContainers;


/**
 * Class IncludeTableData
 * @package Core\Database\TableActionContainers
 */
class IncludeTableData extends BaseTable
{
    /**
     * @var string
     */
    public string $Property;
    
    /**
     * @var string
     */
    public string $ComparisonColumn;
    
    /**
     * @var string
     */
    public string $IncludeComparisonColumn;
    
    /**
     * @var array
     */
    public array $Columns = [];
    
    /**
     * @var bool
     */
    public bool $Recursive = false;
    
    /**
     * @var string
     */
    public string $ResultType;
    
    /**
     * @var IncludeTableData[]
     */
    public array $IncludeTableData = [];

    /**
     * @var Where[]
     */
    public array $Wheres = [];


    /**
     * IncludeTableData constructor.
     * @param string $tableName
     * @param string $includeComparisonColumn
     * @param string $property
     * @param string $comparisonColumn
     * @param bool $recursive
     * @param int $resultType
     * @param Column[] $columns
     * @param IncludeTableData[] $includeTablesData "Include Table Data"
     * @param Where[] $wheres
     * @param string $alias
     */
    public function __construct(
        string $tableName,
        string $includeComparisonColumn,
        string $property,
        string $comparisonColumn,
        bool $recursive = false,
        int $resultType = 1,
        array $columns = [],
        array $includeTablesData = [],
        array $wheres = [],
        string $alias = "")
    {
        if ($alias === "") {
            $alias = "{$tableName}Alias";
        }
        
        parent::__construct($tableName, $alias, $columns);
        $this->IncludeComparisonColumn = $includeComparisonColumn;
        $this->Property = $property;
        $this->ComparisonColumn = $comparisonColumn;
        $this->ResultType = $resultType;
        $this->Columns = $columns;
        $this->IncludeTableData = $includeTablesData;
        $this->Recursive = $recursive;
        $this->Wheres = $wheres;
    }
}
