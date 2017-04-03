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

    public function advacedAction()
    {
        $this->setHeaderTitle("Advanced Search");
        $this->_view->render('category/advanced');
    }

    public function resultAction()
    {
        $curPage = $this->getRequest()->getParam('page', 1);

        $start = $this->getRequest()->getParam("start", false);
        $end = $this->getRequest()->getParam("end", false);
        $category = $this->getRequest()->getParam("category", false);
        $tags = $this->getRequest()->getParam("tags", false);
        $data = array(
            "start" => $start,
            "end" => $end,
            "category" => $category,
            "tags" => $tags
        );
        if (!$start && !$end && !$category && !$tags) {
            $this->getSession()->setErrorMessage("The form is empty.");
            $this->redirect("/category/advaced");
            return;
        }

        $model = new Category();
        $result = $model->getSearchResult($start, $end, $category, $tags, $this->_getPaginatorCountPerPage(), $curPage);

        $paginator = $this->_getPaginatorParams($curPage, $result["count"]);
        $urlStr = "";
        if ($start) {
            $urlStr .= ($urlStr == "") ? "?" : "&";
            $urlStr .= "start={$start}";
        }
        if ($end) {
            $urlStr .= ($urlStr == "") ? "?" : "&";
            $urlStr .= "end={$end}";
        }
        if ($category) {
            $urlStr .= ($urlStr == "") ? "?" : "&";
            $urlStr .= "category={$category}";
        }
        if ($tags) {
            $urlStr .= ($urlStr == "") ? "?" : "&";
            $urlStr .= "tags={$tags}";
        }

        $paginator["url"] = "/category/result{$urlStr}&page=";

        $params = array(
            "news" => $result["main"],
            "paginator" => $paginator,
            "advanced" => $data
        );
        $this->setHeaderTitle("Result Search");
        $this->_view->render('category/index', $params);
    }
}