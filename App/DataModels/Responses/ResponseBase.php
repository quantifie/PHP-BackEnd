<?php


namespace App\DataModels\Responses;


use Core\DataModels\CoreResponse;

class ResponseBase extends CoreResponse
{
    public function __construct(int $number = 0, string $message = "", string $contentType = "application/json")
    {
        parent::__construct($number, $message, $contentType);
    }
}