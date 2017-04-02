<?php
namespace app\controllers;

use app\lib\Controller;
use app\models\User;
use app\models\Comments;


class UserController extends Controller
{
    public function logoutAction()
    {
        setcookie("sid", "");
        $user = new User();
        $user->logout();
        $this->redirect("/");
        return;
    }

    public function loginAction()
    {
        $user = new User();
        //$user->create('a@a.com', '123');
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->redirectTo405();
            return;
        }
        $url = $this->getRequest()->getPrevUrl();

        setcookie("sid", "");
        $email = $this->getRequest()->getParam("email");
        $password = $this->getRequest()->getParam("password");
        $remember = $this->getRequest()->getParam("remember-me");
        if (empty($email)) {
            $this->getSession()->setErrorMessage("The email is empty.");
            $this->redirect($url);
            return;
        }

        if (empty($password)) {
            $this->getSession()->setErrorMessage("The password is empty.");
            $this->redirect($url);
            return;
        }


        $user = new User();
        $authResult = $user->authorize($email, $password, $remember);

        if (!$authResult) {
            $this->getSession()->setErrorMessage("Invalid email or password");
            $this->redirect($url);
            return;
        }

        $this->redirect($url);
        return;
    }

    public function commentAction()
    {
        $id = $this->getRequest()->getParam('id', false);
        $curPage = $this->getRequest()->getParam('page', 1);
        if (!$id) {
            return $this->redirectTo404();
        }
        $model = new Comments();
        $comments = $model->load($id);

        if (empty($comments)) {
            return $this->redirectTo404();
        }

        $comments = $model->getCommentsByUserId($id, $this->_getPaginatorCountPerPage(), $curPage);
        $count = $model->getCountCommentsByUserId($id);
        $paginator = $this->_getPaginatorParams($curPage, $count);
        $paginator["url"] = "/user/comment?id={$id}&page=";

        $params = array(
            "comments" => $comments,
            "paginator" => $paginator,
        );
        $this->setHeaderTitle('Comments');
        $this->_view->render('comment/byuser', $params);
    }
}