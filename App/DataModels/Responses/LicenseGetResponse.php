<?php


namespace App\DataModels\Responses;


use App\DatabaseModels\License;

class LicenseGetResponse extends ResponseBase
{
    public ?License $License;
}