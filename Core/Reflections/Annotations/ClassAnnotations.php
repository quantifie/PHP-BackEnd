<?php


namespace Core\Reflections\Annotations;


use Core\Reflections\Reflections;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

/**
 * Class ClassAnnotations
 * @package Core\Reflections\Annotations
 */
class ClassAnnotations
{
    /**
     * @var Annotations
     */
    private Annotations $_annotations;

    /**
     * @var Reflections
     */
    private Reflections $_reflections;

    /**
     * @var bool
     */
    public bool $IsAuthorized;

    /**
     * ClassAnnotations constructor.
     * @param Reflections $reflections
     */
    public function __construct(Reflections $reflections)
    {
        $this->_annotations = new Annotations();
        $this->_reflections = $reflections;
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @return AnnotationModel[]
     */
    public function GetClassAnnotations(): array {
        return $this->_annotations->Get($this->_reflections->GetClassDocs());
    }

    /**
     * @param string $methodName
     * @return AnnotationModel[]
     */
    public function GetMethodAnnotationsByName(string $methodName): array {
        $method = $this->_reflections->GetMethod($methodName);
        $methodDocString = $this->_reflections->GetMethodDocs($method);
        return $this->_annotations->Get($methodDocString);
    }

    /**
     * @param ReflectionMethod $method
     * @return AnnotationModel[]
     */
    public function GetMethodAnnotations(ReflectionMethod $method): array {
        $methodDocString = $this->_reflections->GetMethodDocs($method);
        return $this->_annotations->Get($methodDocString);
    }

    /**
     * @param string $propertyName
     * @return AnnotationModel[]
     */
    public function GetPropertyAnnotationsByName(string $propertyName): array {
        $property = $this->_reflections->GetClassProperty($propertyName);
        $propertyDocString = $this->_reflections->GetPropertyDocs($property);
        return $this->_annotations->Get($propertyDocString);
    }

    /**
     * @param ReflectionProperty $property
     * @return AnnotationModel[]
     */
    public function GetPropertyAnnotations(ReflectionProperty $property): array {
        $propertyDocString = $this->_reflections->GetPropertyDocs($property);
        return $this->_annotations->Get($propertyDocString);
    }
}