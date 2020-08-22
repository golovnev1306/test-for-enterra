<?php
defined('INCLUDE_INDEX') or die('Restricted access');
use core\Controller;
use core\View;
use models\Users;

class Login extends Controller
{
    function indexAction() 
    {
        View::render();
    }

    function authAction() 
    {
        global $App;

        $data = $App->cleanArrayXss($_POST);

        $user = new Users();

        if($user->login($data['login'], $data['pass'])) {
            $App->redirect('admin');
        } else {
            $App->setFlashMessage('message', [
                'value' => 'Неверный логин/пароль', 
                'type' => 'danger'
                ]);
            $App->redirect('login');
        }
    }

    function logoutAction()
    {
        global $App;
        
        $App->endSession();
        $App->redirect('news');
    }
}