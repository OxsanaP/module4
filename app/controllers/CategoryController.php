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
            return $this->redirectTo404();
        }
        $model = new Category();
        $category = $model->load($id);

        if (empty($category)) {
            return $this->redirectTo404();
        }
        $news = $model->getCategoryNews($id, $this->_getPaginatorCountPerPage(), $curPage);
        $count = $model->getCountCategoryNews($id);
        $paginator = $this->_getPaginatorParams($curPage, $count);
        $paginator["url"] = "/category?id={$id}&page=";

        $params = array(
            "news" => $news,
            "paginator" => $paginator,
        );
        $this->setHeaderTitle($category["name"]);
        $this->_view->render('category/index', $params);

    }
}