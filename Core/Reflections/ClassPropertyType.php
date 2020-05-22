<?php


namespace Core\Reflections;


use ReflectionProperty;

class ClassPropertyType
{
    public static int $Public = ReflectionProperty::IS_PUBLIC;
    public static int $Protected = ReflectionProperty::IS_PROTECTED;
    public static int $Private = ReflectionProperty::IS_PRIVATE;
    public static int $Static = ReflectionProperty::IS_STATIC;
}
