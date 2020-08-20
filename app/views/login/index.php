<?php
global $App;
?>
<h1>Авторизация</h1>
<pre>
    <?print_r($_SESSION['autorizeUser'])?>
</pre>
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
        <button type="submit" class="btn btn-dark">Submit</button>
    </form>
</div>
