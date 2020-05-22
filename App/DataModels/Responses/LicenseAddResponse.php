<?php


namespace App\DataModels\Responses;



use App\DatabaseModels\License;

class LicenseAddResponse extends ResponseBase
{
    public License $License;

    public function __construct(int $number = 0, string $message = "", string $contentType = "application/json")
    {
        parent::__construct($number, $message, $contentType);
    }
}