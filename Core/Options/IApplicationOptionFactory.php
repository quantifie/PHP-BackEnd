<?php


namespace Core\Options;


interface IApplicationOptionFactory
{
    function Set(IApplicationOption $applicationOption);

    function Get(): IApplicationOption;
}