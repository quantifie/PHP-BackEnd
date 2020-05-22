<?php


namespace Core\Libs\Helpers;


class Converter
{
    public static function StringToBoolean(string $boolString) {
        return $boolString === "true";
    }

    public static function BooleanToTinyInt(bool $value){
        if ($value === true)
            return 1;
        return 0;
    }
}