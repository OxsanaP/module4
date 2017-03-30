<?php
namespace app\controllers;

use app\lib\Controller;

use app\models\Category;

class IndexController extends Controller
{
    function indexAction()
    {
        $category = new Category();
        $categories = $category->getCategoriesForMain();
        $params = array("categories"=>$categories);
        $this->setHeaderTitle("Мои новости");
        $this->_view->generate('index/index.php', $params);

    }
}