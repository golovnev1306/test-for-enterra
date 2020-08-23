<?php
defined('INCLUDE_INDEX') or die('Restricted access');
global $App;
?>

<?if ($App->hasFlashMessage('message')) {
    $message = $App->getFlashMessage('message');
    ?>
<div class="alert alert-<?=$message['type']?> alert-dismissible fade show" role="alert">
    <?=$message['value']?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?}?>

<div class="title"> 
    <h1>Панель администратора</h1>
</div>
<hr>
<div class="button-wrapper">
    <button class="btn btn-success button-open-modal-add-news" data-toggle="modal" data-target="#addNewsModal">Добавить</button>
</div>
<div class="news-admin-list row">
<?if ($news) {?>
<?foreach ($news as $item) {?>

    <div class="col-sm-12">
        <div class="news-admin-item js-news-admin-item" data-id="<?=$item["id"]?>">
            <div class="news-name"><?=$item["name"]?></div>
            <div class="news-date-created"><?=date($App->getConfig('dateFormat'), strtotime($item['date_created']))?></div>
            <div class="buttons">
                <button class="btn btn-info btn-sm btn-edit-modal-news js-btn-edit-modal-news" data-toggle="modal" data-target="#editNewsModal">Изменить</button>
                <button class="btn btn-danger btn-sm btn-delete-news js-btn-delete-news">Удалить</button>
            </div>
        </div>
    </div>

<?}?>
<?} else {?>
    <div class="col-sm-12">Список пуст</div>
<?}?>
</div>
<div class="modal-add-container js-modal-add-container"></div>
<div class="modal-edit-container js-modal-edit-container"></div>
