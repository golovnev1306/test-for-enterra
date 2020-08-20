<?php
use core\Controller;
use core\View;
use models\News as NewsModel;

class News extends Controller
{
    function indexAction() {
        $model = new NewsModel();
        $news = $model->getAll();

        View::render([
            "news" => $news
        ]);
    }

    function detailAction($id = null) 
    {
        global $App;

        $model = new NewsModel();
        $news = [];

        if (null === $id) { //по умолчанию будем выдавать первую новость из выборки
            $news = $model->getFirst();
        } else {
            $id = intval($id);
            $news = $model->getById($id);
        }
        if (null === $news) {
            View::render([], 'no-detail');
            return;
        } 

        View::render([
            'news' => $news,
        ]);
    }
}