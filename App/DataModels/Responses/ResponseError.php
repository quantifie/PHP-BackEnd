<?php


namespace App\DataModels\Responses;


class ResponseError
{
    /**
     * Error number
     * @var int
     */
    public int $Number;

    /**
     * Error message
     * @var string
     */
    public string $Message;

    public function __construct()
    {
        $this->Message = "";
        $this->Number = 0;
    }
}