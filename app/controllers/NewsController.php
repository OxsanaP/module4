<?php
namespace app\controllers;

use app\lib\Controller;
use app\models\News;
use app\models\Tag;
use app\models\Comments;

class NewsController extends Controller
{
    function indexAction()
    {
        $id = $this->getRequest()->getParam('id', false);
        if (!$id) {
            return $this->redirectTo404();
        }
        $model = new News();
        $nowRead = rand(1, 5);
        $model->updateViewed($id, $nowRead);
        $news = $model->load($id);

        if (empty($news)) {
            return $this->redirectTo404();
        }

        if (!$this->getSession()->isLogined()) {
            $news['content'] = $model->trimContent($news['content']);
        }

        $comments = new Comments();
        $tagModel = new Tag();
        $params = array(
            "news" => $news,
            "nowRead" => $nowRead,
            "tags" => $tagModel->getNewsTagsById($id),
            "comments" => $comments->getComments($id)
        );
        $this->setHeaderTitle("");
        $this->_view->render('news/index', $params);
    }

    public function curviewAction()
    {
        $id = $this->getRequest()->getParam('id', false);
        $status = 'success';
        $data = array();
        if (!$id) {
            $status = 'error';
            $data['errorMessage'] = "Id не задано.";
        }
        $model = new News();
        $news = $model->load($id);
        if (empty($news)) {
            $status = 'error';
            $data['errorMessage'] = "Новость не найдена";
        }
        if ($status == 'success') {
            $nowRead = rand(1, 5);
            $viewed = $model->updateViewed($id, $nowRead);
            $data['viewed'] = $viewed;
            $data['curViewed'] = $nowRead;
        }
        echo json_encode(array('status' => $status, 'data' => $data));
        exit;
    }

    public function searchAction()
    {
        $value = $this->getRequest()->getParam('q', false);
        $result = array();
        if ($value) {
            $model = new Tag();
            $result = $model->searchByName($value);
        }
        echo json_encode($result);
        exit;
    }
}