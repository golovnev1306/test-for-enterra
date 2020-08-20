<?php
global $App;
?>
<h1>Список новостей</h1>
<hr>
<div class="news-list row">

<?foreach ($news as $item) {?>

    <div class="news-item col-xs-12 col-md-6 col-lg-4">
        <div class="news-name"><?=$item["name"]?></div>
        <div class="news-image">
            <img src="<?=$item["image"] ? $item["image"] : ($App->pathToImg() . 'no-photo.png')?>" alt="<?=$item["name"]?>">
        </div>
        <div class="news-priview-text"><?=$item["preview_text"]?></div>
        <div class="news-date-created"><?=$item["date_created"]?></div>
    </div>

<?}?>

</div>
