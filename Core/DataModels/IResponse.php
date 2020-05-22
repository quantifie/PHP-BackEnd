<?php


namespace Core\DataModels;


interface IResponse
{
    function GetNumber(): int;
    function GetMessage(): string;
    function SetNumber(int $number);
    function SetMessage(string $message);
}