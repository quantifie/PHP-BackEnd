<?php


namespace Core\Exceptions;


use Throwable;

class ApplicationNotCreatedException extends CustomException
{
    public function __construct(bool $isDevelopment = false, Throwable $previous = null)
    {
        parent::__construct("Application could not created.", ExceptionCodes::$ApplicationNotCreated, $previous, $isDevelopment);
    }
}