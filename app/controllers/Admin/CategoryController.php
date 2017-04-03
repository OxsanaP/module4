<?php
namespace app\controllers\Admin;

use app\models\Category;

class CategoryController extends \app\lib\AdminController
{
    public function indexAction()
    {
        $model = new Category();
        $this->_view->render('admin/category/index', array('tree' => $model->getCategoryTree()));
    }

    public function addAction()
    {
        $this->_view->render('admin/category/add');
    }

    public function addpostAction()
    {
        $name = $this->getRequest()->getParam('name', false);
        $parentId = $this->getRequest()->getParam('parent_id', null);

        if (empty($name)) {
            $this->getSession()->setErrorMessage("The category name is empty.");
            $this->redirect("/admin/category/add");
            return;
        }

        $model = new Category();
        $res = $model->addCategory(array('name' => $name, 'parent_id' => $parentId));

        if ($res === true) {
            $this->getSession()->setSuccesMessage('The category has added.');
            $this->redirect("/admin/category");
            return;
        }
        $this->getSession()->setErrorMessage($res);
        $this->redirect("/admin/category/add");

    }

    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id', false);
        if (empty($id)) {
            $this->getSession()->setErrorMessage("The id category is empty.");
            return;
        }

        $model = new Category();
        if (empty($model->load($id))) {
            $this->getSession()->setErrorMessage("The category did not found.");
            return;
        }

        if ($model->getChildCount($id) >0 ) {
            $this->getSession()->setErrorMessage("Can not delete this category. Delete child category.");
            return;
        }

        $res = $model->deleteCategory($id);

        if (true === $res) {
            $this->getSession()->setSuccesMessage("The category has deleted.");
            return;
        }
        $this->getSession()->setErrorMessage("The category did not delete." . $res);


    }


}