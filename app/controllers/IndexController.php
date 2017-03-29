<?php
namespace app\controllers;

use app\lib\Controller;

class IndexController extends Controller
{
    function indexAction()
    {
        $this->view->generate('index/index.php');
    }
}