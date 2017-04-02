<?php
namespace app\controllers;

use app\lib\Controller;
use app\models\Comments;

class CommentController extends Controller
{
    public function addAction()
    {
        $url = $this->getRequest()->getPrevUrl();
        $content = $this->getRequest()->getParam("content");
        $newsId = $this->getRequest()->getParam("news_id");
        $parentId = $this->getRequest()->getParam("parent_id", null);

        if (empty($content)) {
            $this->getSession()->setErrorMessage("The comment is empty.");
            $this->redirect($url);
            return;
        }
        if (empty($newsId)) {
            $this->getSession()->setErrorMessage("The news id is incorrect.");
            $this->redirect($url);
            return;
        }

        if (!$this->getSession()->getUserId()) {
            $this->getSession()->setErrorMessage("You are not loggined.");
            $this->redirect($url);
            return;
        }
        $params = array(
            "parent_id" => $parentId,
            "news_id" => $newsId,
            "user_id" => $this->getSession()->getUserId(),
            "content" => $content,
        );
        $model = new Comments();
        try {
            $model->addComment($params);
        } catch (\Exception $e) {
            $this->getSession()->setErrorMessage("Your comment was not added.");
            $this->redirect($url);
        }
        $this->redirect($url);

    }

    public function rateAction()
    {
        $url = $this->getRequest()->getPrevUrl();
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->redirectTo405();
            return;
        }

        $id = $this->getRequest()->getParam("id");
        $rate = $this->getRequest()->getParam("rate", 0);

        if (empty($id)) {
            $this->getSession()->setErrorMessage("The id is incorrect.");
            $this->redirect($url);
            return;
        }

        if ($rate != 1 || $rate != 1) {
            $this->getSession()->setErrorMessage("Rate is incorrect.");
            $this->redirect($url);
            return;
        }

        $model = new Comments();
        $model->rate($id, $rate);
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam("id");
        $url = $this->getRequest()->getPrevUrl();
        if (empty($id)) {
            $this->getSession()->setErrorMessage("The Id is empty.");
            $this->redirect($url);
            return;
        }
        $model = new Comments();
        $comment = $model->load($id);
        if (empty($comment)){
            $this->getSession()->setErrorMessage("The comment was not found.");
            $this->redirect($url);
            return;
        }
        $curDate = new \DateTime();
        $date = new \DateTime($comment['create_at']);
        $diff = $curDate->getTimestamp() - $date->getTimestamp();

        if ($diff >= 60) {
            $this->getSession()->setErrorMessage("You can not edit comment.");
            $this->redirect($url);
            return;
        }
        $this->setHeaderTitle("");
        $this->getSession()->setValue('prev_edit_url', $url);
        $this->_view->render('comment/edit', array("comment" => $comment));
    }

    public function editpostAction()
    {
        $id = $this->getRequest()->getParam("id");
        $content = $this->getRequest()->getParam("content");
        $url = $this->getRequest()->getPrevUrl();
        if (empty($id)) {
            $this->getSession()->setErrorMessage("The Id is empty.");
            $this->redirect($url);
            return;
        }
        if (empty($content)) {
            $this->getSession()->setErrorMessage("The comment is empty.");
            $this->redirect($url);
            return;
        }
        $model = new Comments();
        $comment = $model->load($id);
        if (empty($comment)){
            $this->getSession()->setErrorMessage("The comment was not found.");
            $this->redirect($url);
            return;
        }
        $curDate = new \DateTime();
        $date = new \DateTime($comment['create_at']);
        $diff = $curDate->getTimestamp() - $date->getTimestamp();

        if ($diff >= 60) {
            $this->getSession()->setErrorMessage("You can not edit comment.");
            $this->redirect($url);
            return;
        }

        $model->updateContent($id, $content);
        $url = $this->getSession()->fetchValue('prev_edit_url');
        $this->redirect($url);
        return;
    }
}