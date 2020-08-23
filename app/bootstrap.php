<?php
use core\Application;
use core\Route;

spl_autoload_register(function ($className) {
    if (file_exists(__DIR__ . '/' . $className . '.php')) {
        include $className . '.php';
    }
});

$App = Application::getInstance();

session_start();
Route::run();