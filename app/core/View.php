<?php
namespace core;

class View 
{
    static function render($vars = [], $view = null) 
    {
        global $App;
        $view = $view ?? $App->getAction();

        $pathViewLayout = $App->pathToViews() . 'layouts/' . $App->getConfig('layout') . '.php';
        $pathView = $App->pathToViews() . '/' . $App->getController() . '/' . $view . '.php'; //переменная используется также в файле layout
        if (file_exists($pathViewLayout) && file_exists($pathView)) {
            foreach ($vars as $key => $var) {
                $$key = $var;
            }
            include_once $pathViewLayout;
        } else {
            echo "$pathViewLayout <br> $pathView <br>";
            echo "произошла ошибка подключения файла представления";
        }
    }
}