<?php
namespace core;

class Controller 
{

    private static $is404 = true;

    final static function start(Array $params) 
    {
        global $App;

        $controllerName = ucfirst($App->getController());
        $action = $App->getAction();

        $pathController = $App->pathToControllers() . "$controllerName.php";
        
        if (file_exists($pathController)) {
            include_once $pathController;
            $actionFunc = "{$action}Action";
            if (method_exists($controllerName, $actionFunc)) {

                (new $controllerName)->$actionFunc(...$params);
                
               
                self::$is404 = false;
            }
        }

        if (self::$is404) {
            self::error404();
        }
        
    }

    final static function error404() 
    {
        global $App;
        self::$is404 = false;
        
        header("HTTP/1.0 404 Not Found");

        //меняем контроллер и экшен для 404 страницы
        $App->setController($App->getConfig('404Controller'));
        $App->setAction($App->getConfig('404Action'));

        self::start([]);
    }
}