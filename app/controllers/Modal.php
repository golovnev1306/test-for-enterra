<?php
defined('INCLUDE_INDEX') or die('Restricted access');
use core\Controller;
use core\View;
use models\News;

class Modal extends Controller
{
    public $isForAjax = true;

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
        $news = $model->getAll();
        return View::render(['news' => $news], null, true);
    }
}