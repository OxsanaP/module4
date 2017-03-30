<?php
namespace app\lib;

use app\lib\View;
use app\lib\Http;

class Controller
{

    protected $_view;
    protected $_layout = "layout.php";
    protected $_requst;

    function __construct()
    {
        $this->_view = new View();
        $this->_view->setLayout($this->_layout);
        $this->_requst = new Http();
    }

    /**
     * @return \app\lib\Http
     */
    protected function getRequest()
    {
        return $this->_requst;
    }

    public function setHeaderTitle($title)
    {
        $this->_view->setHeaderTitle($title);
        return $this;
    }
}