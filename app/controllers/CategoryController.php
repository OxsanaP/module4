<?php
namespace app\controllers;

use app\lib\Controller;
use app\models\Category;

class CategoryController extends Controller
{


    function indexAction()
    {
        $id = $this->getRequest()->getParam('id', false);
        $curPage = $this->getRequest()->getParam('page', 1);
        if (!$id) {
            die ('404 Not Found');
        }
        $model = new Category();
        $category = $model->load($id);

        if (empty($category)) {
            die ('404 Not Found');
        }

        $countPerPage = 5;
        $news = $model->getCategoryNews($id, $countPerPage, $curPage);

        $count = $model->getCountCategoryNews($id);
        $paginator = array(
            "curPage" => $curPage,
            "count" => $count,
            "countPerPage" => $countPerPage,
            "countPages" => ceil($count/$countPerPage),
            "url" => "/category?id={$id}&page="
        );

        $params = array(
            "news" => $news,
            "category" => $category,
            "paginator" => $paginator,
        );
        $this->setHeaderTitle($category["name"]);
        $this->_view->generate('category/index.php', $params);

    }
}