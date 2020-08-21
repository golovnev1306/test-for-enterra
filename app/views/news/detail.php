<?php
global $App;
?>
<div class="title">
    <h1><?=$news['name']?></h1>
</div>
<hr>
<div class="news-detail row">
    <div class="news-detail-image col-sm-12 col-md-6">
        <img src="<?=$news['image'] ? $news['image'] : $App->pathToImg() . 'no-photo.png'?>">
    </div>
    <div class="news-detail-info col-sm-12 col-md-6">
        <div class="news-detail-text"><?=$news['detail_text']?></div >
        <div class="news-detail-date">Дата создания новости: <?=date($App->getConfig('dateFormat'), strtotime($news['date_created']))?></div>
    </div>
</div>

<div class="back-to-list">
    <a href="/news/">Назад к списку</a>
</div>
