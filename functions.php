<?php

define('ICELEASE_START', microtime(true));

/*
|-------------------------------------------------------------------------------
| Register The Auto Loader
|-------------------------------------------------------------------------------
|
| Automatically loader for our application. We just need to utilize it! We'll 
| require it into the script here so that we do not have to worry about the
| loading of any our classes "manually". Feels great to relax.
|
*/

require __DIR__.'/application/autoload.php';


Core\Icelease::get_instance();