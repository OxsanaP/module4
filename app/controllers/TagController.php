<?php
namespace app\controllers;

use app\lib\Controller;
use app\models\Tag;
use app\models\News;

class TagController extends Controller
{
    function indexAction()
    {
        $id = $this->getRequest()->getParam('id', false);
        $curPage = $this->getRequest()->getParam('page', 1);
        if (!$id) {
            return $this->redirectTo404();
        }
        $tagModel = new Tag();
        $tag = $tagModel->load($id);
        if (empty($tag)) {
            return $this->redirectTo404();
        }
        $model = new News();
        $news = $model->getNewsByTagId($id);

        $count = $model->getCountNewsByTagId($id);
        $paginator = $this->_getPaginatorParams($curPage, $count);

        $paginator["url"] = "/tag?id={$id}&page=";
        $params = array(
            "news" => $news,
            "paginator" => $paginator,
        );
        $this->setHeaderTitle("News for tag {$tag['name']}");
        $this->_view->render('category/index', $params);
    }
}