<?php
namespace app\controllers\Admin;

use app\lib\Controller;
use app\models\Category;
use app\models\News;

class IndexController extends \app\lib\AdminController
{
    public function indexAction()
    {
        $this->setHeaderTitle("Dashboard");
        $this->_view->render('admin/index/index');
    }
}