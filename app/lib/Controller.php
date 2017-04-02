<?php
namespace app\lib;

use app\lib\View;
use app\lib\Http;
use app\lib\Session;

class Controller
{

    protected $_view;
    protected $_layout = "layout.php";
    protected $_request;
    protected $_session = null;

    protected $_paginatorCountPerPage = 5;

    function __construct()
    {
        $this->_view = new View();
        $this->_view->setLayout($this->_layout);
        $this->_request = new Http();
    }

    /**
     * @return \app\lib\Http
     */
    protected function getRequest()
    {
        return $this->_request;
    }

    public function setHeaderTitle($title)
    {
        $this->_view->setHeaderTitle($title);
        return $this;
    }

    protected function redirect($url)
    {
        header("Location: {$url}");
        exit;
    }

    protected function redirectTo404()
    {
        //http_response_code(404);
        die ('404 Not Found');
    }

    protected function redirectTo405()
    {
//        http_response_code(405);
//        header("Allow: POST");
        die ("Method Not Allowed");

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

    protected function getSession()
    {
        if (null === $this->_session) {
            $this->_session = new Session();
        }
        return $this->_session;
    }

}