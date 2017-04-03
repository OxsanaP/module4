<!DOCTYPE html>
<html lang="ru" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <script src="/js/jquery.min.js"></script>
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

        <?php if ($this->isLogined()) : ?>
            <p class="navbar-text navbar-right">
                Signed in as <?php echo $this->getCurrentUserName() ?>
                </br><a href="/user/logout" class="navbar-link">Log Out</a>
            </p>
        <?php else : ?>
            <button type="button" class="btn btn-default navbar-btn navbar-right" data-toggle="modal"
                    data-target="#myModal">Sign in
            </button>
        <?php endif; ?>
    </div>
</nav>
<div class="container">
    <?php if ($errors = $this->getErrorMessage()) : ?>
        <?php foreach ($errors as $error) : ?>
            <div class="alert alert-danger" role="alert"><?php echo $error ?></div>
        <?php endforeach ?>
    <?php endif; ?>
    <?php if ($messages = $this->getSuccessMessage()) : ?>
        <?php foreach ($messages as $success) : ?>
            <div class="alert alert-success" role="alert"><?php echo $success ?></div>
        <?php endforeach ?>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-2">
            <ul class="list-group">
                <li class="list-group-item">Category
                    <ul class="list-group">
                        <li class="list-group-item"><a href="/admin/category">View</a></li>
                        <li class="list-group-item"><a href="/admin/category/add">Add</a></li>
                    </ul>
                </li>
                <li class="list-group-item">News
                    <ul class="list-group">
                        <li class="list-group-item"><a href="/admin/news">View</a></li>
                        <li class="list-group-item"><a href="/admin/news/add">Add</a></li>
                    </ul>
                </li>
                <li class="list-group-item">Comments</li>
                <li class="list-group-item">Ads</li>
                <li class="list-group-item">Any config</li>
            </ul>
        </div>
        <div class="col-md-10"><?php $this->getContent(); ?></div>
    </div>
</div>

<script src="/js/bootstrap.min.js"></script>
<div class="footer">
    <div class="navbar navbar-default navbar-fixed-bottom row-fluid">
        <div class="container-fluid">
        </div>
</body>
</html>