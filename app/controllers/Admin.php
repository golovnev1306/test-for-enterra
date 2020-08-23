<?php
defined('INCLUDE_INDEX') or die('Restricted access');
use core\Controller;
use core\View;
use models\News;

class Admin extends Controller
{
    public $isForAutorized = true; //недоступно неавторизованным пользователям

    function indexAction() 
    {
        global $App;

        $model = new News();
        $news = $model->getAll();

        View::render([
            "news" => $news
        ]);
    }

    function addAction() 
    {
        global $App;
        $message = '';
        $typeMessage = 'success';

        if (!empty($_POST)) {

            $model = new News();
            $data = $App->cleanArrayXss($_POST);
            $isErrorFileLoad = false;
            $data['image'] = null;

            if (!empty($_FILES) && $_FILES['image']['error'] === 0) {
                $uploadDir = $App->pathToUpload();
                $extension = (new SplFileInfo($_FILES['image']['name']))->getExtension();

                $filename = uniqid() . '.' . $extension;
                $uploadFile = $uploadDir . $filename;
                $mime = $_FILES['image']['type'];
                
                if (strpos($mime, 'image') !== false) {
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                        $data['image'] = $filename;
                    } else {
                        $message = 'возникла проблема при загрузке файла';
                        $typeMessage = 'danger';
                        $isErrorFileLoad = true;
                    }
                } else {
                    $message = 'файл должен быть изображением';
                    $typeMessage = 'danger';
                    $isErrorFileLoad = true;
                }
            }

            if (!$isErrorFileLoad && $model->add($data)) {
                $message = 'Успешно';
            } else {
                $typeMessage = 'danger';
            }
        } else {
            $message = 'нет данных';
            $typeMessage = 'danger';
        }

        $App->setFlashMessage('message', [
            'value' => $message,
            'type' => $typeMessage,
        ]);

        $App->redirect('admin');
    }

    function deleteajaxAction() 
    {
        global $App;

        $message = '';
        $typeMessage = 'success';

        if (!empty($_POST)) {
            $model = new News();
            $data = $App->cleanArrayXss($_POST);
            if ($model->delete(intval($data['id']))) {
                if(null !== $data['oldImage']  && !empty($data['oldImage'])) {
                    $fileName = $App->pathToUpload() . $data['oldImage'];
                    if (file_exists($fileName)) {
                        unlink($fileName);
                    }
                }
                $message = 'Успешно удалено';
            } else {
                $message = 'Возникла проблема с запросом к базу';
                $typeMessage = 'danger';
            }

        } else {
            $message = 'Нет данных';
            $typeMessage = 'danger';
        }

        $App->setFlashMessage('message', [
            'value' => $message,
            'type' => $typeMessage,
        ]);
    }

    function editAction() 
    {
        global $App;
        $message = '';
        $typeMessage = 'success';
        if (!empty($_POST)) {

            $model = new News();
            $data = $App->cleanArrayXss($_POST);
            $isErrorFileLoad = false;
            $data['image'] = $data['oldImage'];

            if (!empty($_FILES) && $_FILES['image']['error'] === 0) {

                $uploadDir = $App->pathToUpload();
                $extension = (new SplFileInfo($_FILES['image']['name']))->getExtension();

                $filename = uniqid() . '.' . $extension;
                $uploadFile = $uploadDir . $filename;
                $mime = $_FILES['image']['type'];
                
                if (strpos($mime, 'image') !== false) {
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                        if(!empty($data['oldImage'])) {
                            $fileName = $App->pathToUpload() . $data['oldImage'];
                            if (file_exists($fileName)) {
                                unlink($fileName);
                            }
                        }
                        $data['image'] = $filename;
                    } else {
                        $message = 'возникла проблема при загрузке файла';
                        $typeMessage = 'danger';
                        $isErrorFileLoad = true;
                    }
                } else {
                    $message = 'Файл должен быть изображением';
                    $typeMessage = 'danger';
                    $isErrorFileLoad = true;
                }
            }

            if (!$isErrorFileLoad && $model->update($data)) {
                $message = 'Успешно изменено';
            } else {
                $typeMessage = 'danger';
            }
        } else {
            $message = 'Нет данных';
            $typeMessage = 'danger';
        }

        $App->setFlashMessage('message', [
            'value' => $message,
            'type' => $typeMessage,
        ]);

        $App->redirect('admin');
    }

    function getnewsajaxAction() 
    {
        global $App;

        $isSuccess = false;

        if (!empty($_POST)) {
            $model = new News();
            $data = $App->cleanArrayXss($_POST);
            if ($news = $model->getById(intval($data['id']))) {
                $isSuccess = true;
            }
        } 
        $result = [
            'success' => $isSuccess,
            'news' => $news,
        ];

        echo json_encode($result);
    }
}