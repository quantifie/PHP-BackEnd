<?php


namespace Core\Security;


/**
 * Class Origins
 * @package Core\Security
 */
class OriginBase
{
    /**
     * @var string[]
     */
    private array $_origins = [];

    public function __construct()
    {
    }

    /**
     * @param string $originAddress
     * @return OriginBase
     */
    public function Allow(string $originAddress)
    {
        array_push($this->_origins, $originAddress);
        return $this;
    }

    /**
     * @return string[]
     */
    public function GetOrigins()
    {
        return $this->_origins;
    }
}