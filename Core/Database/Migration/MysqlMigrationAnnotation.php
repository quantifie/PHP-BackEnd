<?php


namespace Core\Database\Migration;


use Core\Database\TableColumnAnnotation;
use Core\Reflections\Annotations\AnnotationModel;
use Core\Reflections\Annotations\Annotations;
use Core\Reflections\ClassPropertyType;
use Core\Reflections\Reflections;
use Exception;

class MysqlMigrationAnnotation implements IMigrationAnnotation
{
    public function GetTableColumnAnnotations(string $tableName) {
        $reflections = new Reflections($tableName);
        $properties = $reflections->GetClassProperties(ClassPropertyType::$Public);

        try {
            $tableColumnAnnotations = [];
            foreach ($properties as $property) {
                $propertyDocs = $reflections->GetPropertyDocs($property);
                $annotation = new Annotations();
                $propertyAnnotations = $annotation->Get($propertyDocs);
                $columnAnnotation = $this->DocToTableAnnotations($propertyAnnotations);
                $columnAnnotation->Name = $property->getName();
                array_push($tableColumnAnnotations, $columnAnnotation);
            }

            return $tableColumnAnnotations;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @param AnnotationModel[] $annotations
     * @return array|TableColumnAnnotation
     */
    private function DocToTableAnnotations(array $annotations) {

        if(count($annotations) < 0)
            return [];
        $columnAnnotations = [];
        $columnAnnotation = new TableColumnAnnotation();

        foreach ($annotations as $annotation) {

            if ( $annotation->Name === "dataType" )
                $columnAnnotation->DataType =  $annotation->Value ;

            if ( trim($annotation->Name) === "isNullable" ) {
                $columnAnnotation->IsNullable = filter_var($annotation->Value, FILTER_VALIDATE_BOOLEAN);
            }

            if ( $annotation->Name === "autoIncrement" ) {
                $columnAnnotation->AutoIncrement = filter_var($annotation->Value, FILTER_VALIDATE_BOOLEAN);
            }

            if ( $annotation->Name === "key" && !empty($annotation->Value))
                $columnAnnotation->Key = $annotation->Value;

            if ( $annotation->Name === "default" )
                $columnAnnotation->DefaultValue = $annotation->Value;

            if ( $annotation->Name === "indexed" ){
                $columnAnnotation->Indexed = filter_var($annotation->Value, FILTER_VALIDATE_BOOLEAN);
            }

            if ( $annotation->Name === "noSerialize" )
                $columnAnnotation->NoSerialize = filter_var($annotation->Value, FILTER_VALIDATE_BOOLEAN);

            array_push($columnAnnotations, $columnAnnotation);
        }

        return $columnAnnotation;
    }
}