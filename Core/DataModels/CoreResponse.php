<?php

namespace Core\DataModels;


/**
 * Base response class of all http responses
 * @package Models\ResponseModels
 */
class CoreResponse implements IResponse
{
    private string $ContentType;
    private string $_message;
    private int $_number;

    /**
     * BaseResponse constructor.
     * @param int $number
     * @param string $message
     * @param string $contentType
     */
    public function __construct(int $number = 0, string $message = "", string $contentType = "application/json")
    {
        $this->ContentType = $contentType;
        header("Content-Type: {$this->ContentType}");
        $this->SetNumber($number);
        $this->SetMessage($message);
    }

    function GetNumber(): int
    {
        return $this->_number;
    }

    function GetMessage(): string
    {
        return $this->_message;
    }

    function SetNumber(int $number)
    {
        $this->_number = $number;
    }

    function SetMessage(string $message)
    {
        $this->_message = $message;
    }

    function Object(): CoreResponseModel{
        $object = new CoreResponseModel();
        $object->Message = $this->_message;
        $object->Number = $this->_number;
        return $object;
    }
}
