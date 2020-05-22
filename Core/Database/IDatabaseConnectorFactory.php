<?php


namespace Core\Database;


interface IDatabaseConnectorFactory
{
    function GetConnector(): IDatabaseConnector;
    function GetAdminConnector(): IDatabaseConnector;
}