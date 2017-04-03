<?php
namespace app\controllers\Admin;

use app\models\News;

class NewsController extends \app\lib\AdminController
{
    public function indexAction()
    {
        $this->_view->render('admin/news/index');
    }

    public function addAction()
    {
        $this->_view->render('admin/news/add');
    }

    public function addpostAction()
    {
        $title = $this->getRequest()->getParam('title', false);
        $category = $this->getRequest()->getParam('category', false);
        $tags = $this->getRequest()->getParam('tags', false);
        $content = $this->getRequest()->getParam('content', false);

        if (!$title || !$category || !$tags || !$content) {
            $this->getSession()->setErrorMessage("Please fill all field.");
            $this->redirect("/admin/news/add");
            return;
        }

        $image = $this->encodeFile();
        if (!$image){
            $this->getSession()->setErrorMessage("Please upload image.");
            $this->redirect("/admin/news/add");
            return;
        }

        $model = new News();
        $param = array(
            'title' => $title,
            'category' => $category,
            'tags' => $tags,
            'content' => $content,
            'image' => $image
        );
        $res = $model->addPost($param);


        if ($res === true) {
            $this->getSession()->setSuccesMessage('The news has added.');
            $this->redirect("/admin/news");
            return;
        }
        $this->getSession()->setErrorMessage($res);
        $this->redirect("/admin/news/add");

    }

    private function encodeFile()
    {
        if (isset($_FILES['image'])) {
            $allowedExt = array('jpg', 'jpeg', 'png', 'gif');
            $fileName = $_FILES['image']['name'];
            $fileExt = strtolower(end(explode('.', $fileName)));

            $fileSize = $_FILES['image']['size'];
            $fileTmp = $_FILES['image']['tmp_name'];

            $type = pathinfo($fileTmp, PATHINFO_EXTENSION);
            $data = file_get_contents($fileTmp);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

            if (in_array($fileExt, $allowedExt) === false) {
                $this->getSession()->setErrorMessage("Extension not allowed.");
                $this->redirect("/admin/news/add");
                return;
            }

            if ($fileSize > 2097152) {
                $this->getSession()->setErrorMessage("File size must be under 2mb.");
                $this->redirect("/admin/news/add");
                return;

            }
            return $base64;
        }
        return false;
    }
}