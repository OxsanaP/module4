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

    public function registerAction()
    {
        $this->setHeaderTitle('Register');
        $this->_view->render('user/register');
    }

    public function addpostAction()
    {
        $username = $this->getRequest()->getParam('username', false);
        $email = $this->getRequest()->getParam('email', false);
        $password = $this->getRequest()->getParam('password', false);

        if (!$username || !$email || !$password) {
            $this->getSession()->setErrorMessage("Please fill all field.");
            $this->redirect("/user/register");
            return;
        }
        $user = new User();
        $res = $user->create($email, $password, $username);
        if (true === $res){
            $this->getSession()->setSuccesMessage('Поздравляемю Вы успешно зарегистрировались.');
            $this->redirect("/");
        }
        $this->getSession()->setErrorMessage($res);
        $this->redirect("/user/register");
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