<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <title>Главная</title>

</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <?php if ($this->getHeaderTitle()) : ?>
                <h2><?php echo $this->getHeaderTitle(); ?></h2>
            <?php endif; ?>
        </div>
        <?php if(true) : ?>
            <button type="button" class="btn btn-default navbar-btn navbar-right">Sign in</button>
        <?php else : ?>
            <p class="navbar-text navbar-right">
                Signed in as <a href="#" class="navbar-link"></a>
            </p>
        <?php endif; ?>
        <form class="navbar-form navbar-right" role="search">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Search">
            </div>
        </form>

    </div>
</nav>
    <div class="container">
        <?php $this->getContent(); ?>
    </div>
<script src="/js/bootstrap.min.js"></script>

    <div class="footer">
        <div class="navbar navbar-default navbar-fixed-bottom row-fluid">
            <div class="container-fluid">
        <div class="well well-sm">
            <p>
            <div>&copy; 2017 <a href="http://mod.loc">Мои новости</a> - Все права защищены </div>
            </p>
            </div>

        </div>

</body>
</html>