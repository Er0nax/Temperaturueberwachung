<?php

// start the session
session_start();

// define global variables
define('BASE_PATH', dirname(__DIR__) . '\\');
define('VENDOR_PATH', dirname(__DIR__) . '\\vendor');
define('ASSET_PATH', dirname(__DIR__) . '\\web\\assets');

// include all classes
spl_autoload_register(function ($class_name) {
    include('../' . str_replace('\\', '/', $class_name) . '.php');
});

// start the app
$App = new \src\App();
$App->run();