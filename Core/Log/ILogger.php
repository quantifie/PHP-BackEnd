<?php


namespace Core\Log;


interface ILogger
{
    function Write(string $title, string $message, string $priority, string $type, string $comment );
}