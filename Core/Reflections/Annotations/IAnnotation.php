<?php


namespace Core\Reflections\Annotations;


/**
 * Interface IAnnotation
 * @package Core\Reflections\Annotations
 */
interface IAnnotation
{
    /**
     * @param string $documentString
     * @return AnnotationModel[]
     */
    function Get(string $documentString): array;
}