<?php
class IndexController extends Controller
{
    function indexAction()
    {
        $this->view->generate('/index/index.php');
    }
}