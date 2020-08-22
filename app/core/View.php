<?php
defined('INCLUDE_INDEX') or die('Restricted access');
namespace core;

class View 
{
    static function render($vars = [], $view = null, $renderPart = false) 
    {
        global $App;
        $view = $view ?? $App->getAction();
        $checkExistsFiles = [];

        $pathView = $App->pathToViews() . $App->getController() . '/' . $view . '.php';
        $checkExistsFiles = file_exists($pathView);
        $include = $pathView;

        if (!$renderPart) {
            $pathViewLayout = $App->pathToViews() . 'layouts/' . $App->getConfig('layout') . '.php';
            $checkExistsFiles = $checkExistsFiles && file_exists($pathViewLayout);
            $include = $pathViewLayout;
        }

        if ($checkExistsFiles) {
            foreach ($vars as $key => $var) {
                $$key = $var;
            }
            include_once $include;
        } else {
            echo "произошла ошибка подключения файла представления";
            exit;
        }
    }
}