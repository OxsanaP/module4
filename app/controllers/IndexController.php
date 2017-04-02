<?php
namespace app\controllers;

use app\lib\Controller;
use app\models\Category;
use app\models\News;

class IndexController extends Controller
{
    public function indexAction()
    {
        $category = new Category();
        $categories = $category->getCategoriesForMain();
        $news = new News();
        $params = array(
            "categories" => $categories,
            "slider" => $news->getSliderData()
        );
        $this->setHeaderTitle("Мои новости");
        $this->_view->render('index/index', $params);

    }
}