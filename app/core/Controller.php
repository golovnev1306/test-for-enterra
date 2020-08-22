<?php
defined('INCLUDE_INDEX') or die('Restricted access');
namespace core;

class Controller 
{

    private static $is404 = true;
    public $isDisallow = false;      // запрещен ли доступ к контроллеру, проверяем здесь
    public $isForAutorized = false;  // предназначен ли контроллер только для авторизованных юзеров
    public $isForAjax = false;       // предназначен ли контроллер только для ajax запросов (модальные окна)

    public function __construct()
    {
        global $App;

        if ($this->getIsForAutorized()) { //если в контроллере установлено свойства об ограничении
            if (!$App->isAutorized()) {
                $this->isDisallow = true;
            }
        }

        if ($this->getIsForAjax()) {
            if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                $this->isDisallow = true;
            }
        }
    }

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

                $includedController = new $controllerName;

                if (!$includedController->getIsDisallow()) {
                    $includedController->$actionFunc(...$params);
                } else {
                    $includedController->reasonAccessDenied();
                }
               
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

    final function getIsDisallow()
    {
        return $this->isDisallow;
    }

    final function getIsForAutorized()
    {
        return $this->isForAutorized;
    }

    final function getIsForAjax()
    {
        return $this->isForAjax;
    }

    final function reasonAccessDenied() {
        global $App;
        $reason = '';
        $redirect = 'login';

        if($this->getIsForAutorized()) {
            $reason .= 'доступ запрещен';
        } 

        if($this->getIsForAjax()) {
            if (!empty($reason)) {
                $reason .= '<br>';
            }
            $reason .= 'Ошибка. Контроллер обрабатывает только ajax запросы';
            $redirect = '';
        } 
        $App->setFlashMessage('message', [
            'value' => $reason,
            'type' => 'danger',
        ]);

        $App->redirect($redirect);
    }
}