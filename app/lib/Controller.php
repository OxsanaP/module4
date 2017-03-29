<?php
class Controller {

    public $model;
    public $view;
    protected $_layout = "layout.php";

    function __construct()
    {
        $this->view = new View();
        $this->view->setLayout($this->_layout);
    }

    function indexAction()
    {
    }
}