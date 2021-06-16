<?php


spl_autoload_register(function($name) {

    $path  = __DIR__ . '/' . str_replace(
        '\\', '/', strtolower($name)
    ) . '.php';

    if (file_exists($path))
        include_once $path;

});