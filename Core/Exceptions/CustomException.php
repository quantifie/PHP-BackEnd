<?php


namespace Core\Exceptions;

use Core\Http\HttpResponse;
use Exception;
use Throwable;

class CustomException extends Exception
{
    public function __construct($message, $code = 0, Throwable $previous = null, bool $isDevelopment = false)
    {
        $trace = "";
        $localMessage = "Internal Exception";

        if ($isDevelopment) {
            $trace = " || Trace: " . $this->getTraceAsString();
            $localMessage = $message;
        }

        parent::__construct($localMessage, $code, $previous);
        HttpResponse::Error( $message . $trace, $code);
    }
}