<?php
require_once "config.php";
use core\Application;
use core\Route;

spl_autoload_register(function ($className) {
    if (file_exists(__DIR__ . '/' . $className . '.php')) {
        include $className . '.php';
    }
        
});

$App = Application::getInstance();

Route::run();