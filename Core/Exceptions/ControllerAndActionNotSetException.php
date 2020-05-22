<?php


namespace Core\Exceptions;


use Throwable;

class ControllerAndActionNotSetException extends CustomException
{
    public function __construct(bool $isDevelopment = false, Throwable $previous = null)
    {
        parent::__construct("Controller and/or Action has not been set.", ExceptionCodes::$ControllerActionNotSet, $previous, $isDevelopment);
    }
}