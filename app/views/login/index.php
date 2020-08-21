<?php
global $App;
?>
<div class="title"> 
    <h1>Авторизация</h1>
</div>
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
<hr>
<div class="login">
    <form class="login-form" action="/login/auth/" method="POST">
        <div class="form-group">
            <label for="inputLogin1">Логин:</label>
            <input type="text" class="form-control" id="inputLogin1" placeholder="Введите логин" name="login">
        </div>
        <div class="form-group">
            <label for="inputPassword1">Пароль:</label>
            <input type="password" class="form-control" id="inputPassword1" placeholder="Пароль" name="pass">
        </div>
        <button type="submit" class="btn btn-dark">Вход</button>
    </form>
</div>
