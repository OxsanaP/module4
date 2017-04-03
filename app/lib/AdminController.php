<?php
namespace app\lib;

use app\lib\Controller as BaseController;
use app\models\User;

class AdminController extends BaseController
{
    protected $_layout = 'admin/layout.php';

    public function __construct()
    {
        parent::__construct();
        $this->_isAllowed();

    }

    protected function _isAllowed()
    {
        if ($this->getSession()->isLogined()) {
            if ($this->getSession()->getRole() !== User::ROLE_ADMIN){
                $this->getSession()->setErrorMessage("You don't have access to this page");
                $this->redirect('/');
                return;
            }
        } else {
            $this->redirect('/user/auth');
        }
    }
}