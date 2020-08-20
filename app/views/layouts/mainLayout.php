<?php
?>
<!doctype html>

<html>
<head lang="ru">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="/assets/css/main.css" type="text/css">

    <title>Мое приложение</title>
</head>

<body>
    <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="/">Главная</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="#">Авторизация</a>
          </li>
        </ul>
      </div>
    </nav>
    </header>

    <main>
    <div class="container">
        <?php
            include_once $pathView;
        ?>
    </div>
    </main>

    <footer>
    <nav class="navbar fixed-bottom navbar-dark bg-dark">
  <a class="navbar-brand" target="_blank" href="https://vk.com/golovnevconstantine">Автор приложения</a>
</nav>
    </footer>
    <script src="/assets/js/jquery-3.5.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
</body>
</html>