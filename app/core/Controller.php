<?php

class Controller 
{

    private static $is404 = false; //для предотвращения рекурсии, в случае,
                                    // если в настройках неправильно указаны контроллер/экшн 404 страницы

    final static function start() 
    {
        global $App;
        $controller = $App->getController();
        $action = $App->getAction();

        $pathController = $App->pathToControllers() . "$controller.php";
        $controllerClassName = ucfirst($controller);
        
        if (file_exists($pathController)) {
            include_once $pathController;
            $actionFunc = "{$action}Action";
            if (method_exists($controllerClassName, $actionFunc)) {
                (new $controllerClassName)->$actionFunc();
                return;
            }
        }

        if (!$is404) {
            self::error404();
        }
        
    }

    private static function error404() 
    {
        global $App;
        self::$is404 = true;
        
        header("HTTP/1.0 404 Not Found");

        //меняем контроллер и экшен для 404 страницы
        $App->setController($App->config['404Controller']);
        $App->setAction($App->config['404Action']);

        self::start();
    }
}