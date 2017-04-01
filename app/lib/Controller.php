<?php
namespace app\lib;

use app\lib\View;
use app\lib\Http;

class Controller
{

    protected $_view;
    protected $_layout = "layout.php";
    protected $_requst;

    protected $_paginatorCountPerPage = 5;

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

    protected function redirectTo404()
    {
        die ('404 Not Found');
    }

    protected function _getPaginatorCountPerPage()
    {
        return $this->_paginatorCountPerPage;
    }

    protected function _setPaginatorCountPerPage($count)
    {
        $this->_paginatorCountPerPage = $count;
        return $this;
    }

    protected function _getPaginatorParams($curPage, $countItems)
    {
        $count = $this->_getPaginatorCountPerPage();
        return array(
            "curPage" => $curPage,
            "count" => $countItems,
            "countPerPage" => $count,
            "countPages" => ceil($countItems/$count),
            "url" => ""
        );
    }

}