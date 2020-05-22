<?php


namespace Core\Reflections;


use ReflectionMethod;

class ClassMethodType
{
    public static int $Public = ReflectionMethod::IS_PUBLIC;
    public static int $Protected = ReflectionMethod::IS_PROTECTED;
    public static int $Private = ReflectionMethod::IS_PRIVATE;
    public static int $Static = ReflectionMethod::IS_STATIC;
    public static int $Abstract = ReflectionMethod::IS_ABSTRACT;
    public static int $Final = ReflectionMethod::IS_FINAL;
}