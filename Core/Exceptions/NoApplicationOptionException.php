<?php


namespace Core\Exceptions;


use Throwable;

class NoApplicationOptionException extends CustomException
{
    public function __construct(bool $isDevelopment = false, Throwable $previous = null)
    {
        parent::__construct("No ApplicationOption Found", ExceptionCodes::$NoApplicationOption, $previous, $isDevelopment);
    }
}