<?php

class Route {
    static function run() 
    {
        global $App;

        $urlParse = parse_url($_SERVER['REQUEST_URI']); //отделим адрес от параметров/фрагментов

        //адрес будет иметь вид /[controller]/[action]/
        $explodedUrl = explode('/', strtolower($urlParse['path']));
        $explodedUrl = $App->arrayDeleteEmpty($explodedUrl);

        if (isset($explodedUrl[0])) {
            $App->setController($explodedUrl[0]);

            if (isset($explodedUrl[1])) {
                $App->setAction($explodedUrl[1]);
            }
        }

        Controller::start();
    }
}