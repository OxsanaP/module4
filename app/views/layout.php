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
    <head class="hidder">

        <div class="well well-sm">
            <p>
            <?php if($this->getHeaderTitle()) : ?>
            <h2><?php echo $this->getHeaderTitle();?></h2>
            <?php endif; ?>
            </p>
        </div>
</head>
<body>
    <div class="container">
        <?php $this->getContent(); ?>
    </div>
<script src="/js/bootstrap.min.js"></script>

    <div class="footer">
        <div class="navbar-fixed-bottom row-fluid">

        <div class="well well-sm">
            <p>
            <div>&copy; 2017 <a href="http://http://mod.loc">Мои новости</a> - Все права защищены </div>
            </p>

        </div>

</body>
</html>