<?php
use core\Controller;
use core\View;
use models\Users;

class Login extends Controller
{
    function indexAction() {
        View::render();
    }

    function authAction() {
        global $App;

        $data = $App->cleanArrayXss($_POST);

        Users::login($data['login'], $data['pass']);

        $App->redirect('login');
    }
}