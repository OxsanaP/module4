<?php
namespace app\controllers;

use app\lib\Controller;
use app\models\News;

class NewsController extends Controller
{
    function indexAction()
    {
        $id = $this->getRequest()->getParam('id', false);
        if (!$id) {
            die ('404 Not Found');
        }
        $model = new News();
        $nowRead = rand(0, 5);
        $model->updateViewed($id, $nowRead);
        $news = $model->load($id);

        if (empty($news)) {
            die ('404 Not Found');
        }


        $params = array(
            "news" => $news,
            "nowRead" => $nowRead,
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
            $nowRead = rand(0, 5);
            $viewed = $model->updateViewed($id, $nowRead);
            $data['viewed'] = $viewed;
            $data['curViewed'] = $nowRead;
        }
        echo json_encode(array('status' => $status, 'data' => $data));
        exit;
    }


}