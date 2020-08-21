<?php
namespace core;

class Controller 
{

    private static $is404 = true;
    public $isDisallow = false; // запрещен ли доступ к контроллеру, проверяем здесь (если у потомка переопределено это свойство на true)

    public function __construct()
    {
        global $App;

        if ($this->getIsDisallow() && $App->isAutorized()) { //если в контроллере установлено свойства о недоступности, 
                                                                //а пользователь авторизован - меняем свойство
            $this->isDisallow = false;
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
                    $App->setFlashMessage('message', [
                            'value' => 'доступ запрещен',
                            'type' => 'danger'
                        ]);
                    $App->redirect('login');
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
}