<?php


namespace Core\Database\Migration;


interface IMigrationAnnotation
{
    function GetTableColumnAnnotations(string $tableName);
}