<?php
use core\Controller;
use core\View;
use models\News;

class Modal extends Controller
{

    function addajaxAction() 
    {
        global $App;

        return View::render([], null, true); //true - вернет лишь часть контента
    }

    function editajaxAction() 
    {
        global $App;
        $data = $App->cleanArrayXss($_POST);
        $model = new News();
        $news = $model->getById($data['id']);
        return View::render(['news' => $news], null, true);
    }
}