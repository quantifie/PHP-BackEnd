<?php


namespace Core\Options;


class ApplicationOptionFactory implements IApplicationOptionFactory
{
    private static IApplicationOption $_applicationOption;

    public function __construct()
    {
    }

    public function Set(IApplicationOption $applicationOption) {
        self::$_applicationOption = $applicationOption;
    }

    public function Get(): IApplicationOption{
        return self::$_applicationOption;
    }
}