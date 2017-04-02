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
    <script src="/js/auto-complete.min.js"></script>
    <script src="/js/app.js"></script>
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
        <ul class="nav navbar-nav">
            <li class="active"><a href="./">Home</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                   aria-expanded="false">Dropdown <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#">One more separated link</a></li>
                </ul>
            </li>
        </ul>
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
        <form class="navbar-form navbar-right" role="search">
            <div class="form-group">
                <input autocomplete="off" name="q" type="text" class="form-control" placeholder="Search">
            </div>
        </form>

    </div>
</nav>
<div class="container">
    <?php if ($errors = $this->getErrorMessage()) : ?>
        <?php foreach ($errors as $error) : ?>
            <div class="alert alert-danger" role="alert"><?php echo $error ?></div>
        <?php endforeach ?>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-2">
            <?php if ($top = $this->getTop()) : ?>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Top Commentators</h4>
                        <?php foreach ($top as $commentator) : ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="/user/comment?id=<?php echo $commentator['user_id'] ?>"><?php echo $commentator['username'] ?></a>
                                </div>
                                <div class="col-md-1">
                                    <?php echo $commentator['count'] ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            <?php endif; ?>

        </div>
        <div class="col-md-8"><?php $this->getContent(); ?></div>
        <div class="col-md-2"></div>
    </div>

</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <form class="form-horizontal" action="/user/login" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-offset-2 col-sm-2 control-label">Email</label>
                        <div class="col-sm-5">
                            <input type="email" class="form-control" name="email" id="inputEmail3" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-offset-2 col-sm-2 control-label">Password</label>
                        <div class="col-sm-5">
                            <input type="password" class="form-control" name="password" id="inputPassword3"
                                   placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember-me"> Remember me
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="/js/bootstrap.min.js"></script>

<div class="footer">
    <div class="navbar navbar-default navbar-fixed-bottom row-fluid">
        <div class="container-fluid">
            <div class="well well-sm">
                <p>
                <div>&copy; 2017 <a href="http://mod.loc">Мои новости</a> - Все права защищены</div>
                </p>
            </div>

        </div>

</body>
</html>