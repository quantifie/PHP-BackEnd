<?php

namespace Core\Reflections;

use Core\Entities\ErrorCodes;
use Core\Http\HttpResponse;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;

/**
 * Class ReflectionUtils
 * @package Libs\Helpers
 */
class Reflections
{
	#region Public Fields
    #endregion
    
    #region Private Fields
    /**
     * @var ReflectionClass
     */
    private ReflectionClass $_reflectionClass;
    #endregion
    
    #region Constructor
    /**
     * Reflections constructor.
     * @param string $fullyQualifiedClassName
     */
    public function __construct(string $fullyQualifiedClassName)
    {
        try {
            $this->_reflectionClass = new ReflectionClass($fullyQualifiedClassName);
        } catch (ReflectionException $e) {
            HttpResponse::Error($e->getMessage() . " Trace: " . $e->getTraceAsString(), ErrorCodes::$ReflectionClassNotCreated);
        }
    }
    #endregion
    
    #region Public Methods
    /**
     * @return ReflectionClass
     */
    public function GetClass()
    {
        return $this->_reflectionClass;
    }

    /**
     * @return object
     */
    public function Instance() {
        return $this->_reflectionClass->newInstance();
    }

    /**
     * @return string
     */
    public function ShortName() {
        return $this->_reflectionClass->getShortName();
    }

    /**
     * @param int|null $filter
     * @return ReflectionMethod[]
     */
    public function GetMethods(?int $filter) {
        return $this->_reflectionClass->getMethods($filter);
    }

    /**
     * @param string $methodName
     * @return ReflectionMethod
     */
    public function GetMethod(string $methodName)
    {
        try {
            return $this->_reflectionClass->getMethod($methodName);
        } catch (ReflectionException $e) {
            HttpResponse::Error($e->getMessage() . " Trace: " . $e->getTraceAsString(), ErrorCodes::$ReflectionMethodNotFound);
        }
        return null;
    }

    /**
     * @param int $propertyAccessor
     * @return ReflectionProperty[]
     */
    public function GetClassProperties($propertyAccessor)
    {
        return $this->_reflectionClass->getProperties($propertyAccessor);
    }

    /**
     * @param string $propertyName
     * @return null|ReflectionProperty
     */
    public function GetClassProperty(string $propertyName)
    {
        try {
            $hasProperty = $this->_reflectionClass->hasProperty($propertyName);
            if ($hasProperty === true) {
                return $this->_reflectionClass->getProperty($propertyName);
            } else {
                return null;
            }
        } catch (ReflectionException $e) {
            HttpResponse::Error($e->getMessage() . " Trace: " . $e->getTraceAsString(), ErrorCodes::$ReflectionPropertyNotFound);
            return null;
        }
    }

    /**
     * @return false|string
     */
    public function GetClassDocs()
    {
        return $this->_reflectionClass->getDocComment();
    }

    /**
     * @param ReflectionMethod $method
     * @return string
     */
    public function GetMethodDocs(ReflectionMethod $method)
    {
        $reflectionMethod = $this->GetMethod($method->name);
        if($reflectionMethod === false)
            return "";

        return $reflectionMethod->getDocComment();
    }

    /**
     * @param ReflectionProperty $property
     * @return string
     */
    public function GetPropertyDocs(ReflectionProperty $property)
    {
        $reflectionProperty = $this->GetClassProperty($property->name);
        if($reflectionProperty === false)
            return "";

        return $reflectionProperty->getDocComment();
    }
    #endregion
    
    #region Private Methods
    #endregion
    
    #region Helpers
    #endregion
}
