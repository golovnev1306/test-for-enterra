<?php
require_once "config.php";

spl_autoload_register(function ($className) {
    include 'core/' . $className . '.php';
});

$App = Application::getInstance();

Route::run();