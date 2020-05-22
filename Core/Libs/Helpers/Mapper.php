<?php


namespace Core\Libs\Helpers;


use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use stdClass;

/**
 * Class Mapper
 * @package Core\Libs\Helpers
 */
class Mapper
{
    /**
     * @param array $array
     * @param string $reflectedClassName
     * @param bool $fillWidthDefault
     * @return mixed
     */
    public static function MapList(array $array, string $reflectedClassName, bool $fillWidthDefault)
    {
        $newList = [];
        foreach ($array as $item) {
            array_push($newList, self::Map($item, $reflectedClassName, $fillWidthDefault));
        }

        return $newList;
    }

    /**
     * @param object $object
     * @param string $reflectClassName
     * @param bool $fillWidthDefault
     * @return mixed
     */
    public static function Map(object $object, string $reflectClassName, bool $fillWidthDefault)
    {
        try {
            $returnClass = new ReflectionClass($reflectClassName);
            $returnProperties = $returnClass->getProperties(ReflectionProperty::IS_PUBLIC);
            $instance = $returnClass->newInstance();

            foreach ($returnProperties as $returnProperty) {

                $returnPropertyType = $returnProperty->getType()->getName();
                if (isset($object->{$returnProperty->name})) {
                    $objectPropertyValue = $object->{$returnProperty->name};
                    if (gettype($objectPropertyValue) === "object") {
                        $instance->{$returnProperty->name} = self::Map($object->{$returnProperty->name}, $returnPropertyType, $fillWidthDefault);
                    } else {
                        $instance->{$returnProperty->name} = self::AssignValue($returnPropertyType, $objectPropertyValue);
                    }
                } else {
                    if ($fillWidthDefault){
                        $instance->{$returnProperty->name} = self::AssignDefaultValue($returnPropertyType);
                    }
                }
            }
            return $instance;
        } catch (ReflectionException $e) {
            return new $reflectClassName();
        }
    }

    /**
     * @param string $type
     * @return mixed
     */
    private static function AssignDefaultValue(string $type)
    {
        if ($type === "int" || $type == "float")
            return 0;
        elseif ($type === "string")
            return "";
        elseif ($type === "bool")
            return false;
        elseif ($type === "array")
            return [];
        elseif ($type === "object")
            return new stdClass();
        elseif ($type === "null")
            return null;
        else
            return new $type;
    }

    /**
     * @param string $type
     * @param mixed $value
     * @return bool|float|int|string
     */
    private static function AssignValue(string $type, $value)
    {
        if ($type === "int")
            return intval($value);
        elseif ($type == "float")
            return floatval($value);
        elseif ($type === "string")
            return strval($value);
        elseif ($type === "bool" || $type === "boolean") {
            return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        } else
            return $value;
    }

}