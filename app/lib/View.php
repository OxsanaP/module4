<?php
namespace app\lib;

class View
{
    protected $_layout;

    public function generate($contentView, $data = null)
    {

        if(is_array($data)) {
            extract($data);
        }
        include BP . "/views/" . $this->getLayout();
    }

    public function setLayout($layout)
    {
        $this->_layout = $layout;
    }

    public function getLayout()
    {
        return $this->_layout;
    }
}