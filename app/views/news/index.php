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
    <h1>Список новостей</h1>
</div>
<hr>
<div class="news-list row">

<?foreach ($news as $item) {?>

    <div class="news-item col-xs-12 col-md-6 col-lg-4">
        <div class="news-name"><?=$item["name"]?></div>
        <div class="news-image">
            <img src="<?=$item["image"] ? ('/upload/' . $item["image"]) : ($App->pathToImg() . 'no-photo.png')?>" alt="<?=$item["name"]?>">
        </div>
        <div class="news-priview-text"><?=$item["preview_text"]?></div>
        <div class="news-date-created"><?=date($App->getConfig('dateFormat'), strtotime($item['date_created']))?></div>
        <a class="news-link" href="/news/detail/<?=$item["id"]?>"></a>
    </div>

<?}?>

</div>
