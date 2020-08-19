<?php

class Application 
{
    private static $instance = null;
    private $controller;
    private $action;
    public $config;

    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = new self();
            $config = include $_SERVER['DOCUMENT_ROOT'] . "\app\config.php";
            self::$instance->config = $config;
            self::$instance->controller = $config['defaultController'];
            self::$instance->action = $config['defaultAction'];
        }
        return self::$instance;
    }

    public function setController($newController) 
    {
        self::$instance->controller = $newController;
    }

    public function setAction($newAction) 
    {
        self::$instance->action = $newAction;
    }

    public function getController() 
    {
        return self::$instance->controller;
    }

    public function getAction() 
    {
        return self::$instance->action;
    }

    public function pathToViews() 
    {
        return $_SERVER['DOCUMENT_ROOT'] . '/app/views/';
    }

    public function pathToControllers() 
    {
        return $_SERVER['DOCUMENT_ROOT'] . '/app/controllers/';
    }

    public function arrayDeleteEmpty($arr)
    {
        $arr = array_diff($arr, ['']);
        $arr = array_values($arr);
        return $arr;
    }

    private function __clone() {}
    private function __construct() {}
}