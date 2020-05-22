<?php


namespace Core\Route;

/**
 * Class Route
 * @package Core\DatabaseModels
 */
class RouteModel
{
    /**
     * @var string
     */
    public string $EndPoint;

    /**
     * @var string
     */
    public string $ControllerName;

    /**
     * @var string
     */
    public string $Action;

    /**
     * @var string
     */
    public string $RequestType;

    /**
     * @var array
     */
    public array $Params;
}
