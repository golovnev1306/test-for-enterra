<?php
use core\Controller;
use core\View;
use models\News;

class Main extends Controller
{
    function indexAction() {
        $model = new News();
        $news = $model->getAll();

        View::render([
            "news" => $news
        ]);
    }
}