<?php

spl_autoload_register(function ($className) {

    $root = dirname(__FILE__);
    $f = $root . DIRECTORY_SEPARATOR . $className;
    $f = str_replace('\\', '/', $f);
    $f = $f . '.php';
    if (file_exists($f)) {
        require_once($f);
    }
});
