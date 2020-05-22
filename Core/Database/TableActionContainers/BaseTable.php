<?php

namespace Core\Database\TableActionContainers;

/**
 * Class BaseTable
 * @package Libs\Enums
 */
class BaseTable
{
    /**
     * @var string
     */
    public string $Name;

    /**
     * @var string
     */
    public string $Alias;

    /**
     * @var Column[]
     */
    public array $Columns = [];


    /**
     * BaseTable constructor.
     * @param string $tableName
     * @param string $alias
     * @param array $columns
     */
    public function __construct(string $tableName, string $alias, $columns = [])
    {
        $this->Alias = $alias;
        $this->Name = $tableName;
        $this->Columns = $columns;
    }
}
