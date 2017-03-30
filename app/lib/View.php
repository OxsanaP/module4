<?php
namespace app\lib;

class View
{
    protected $_layout;
    protected $_headerTitle;
    protected $_template;
    protected $_params;

    public function generate($template, $data = null)
    {

        if (is_array($data)) {
            $object = new \StdClass;
            foreach ($data as $key=>$value){
                $object->{$key}=$value;
            }
            $this->setParams($object);
        }
        $this->setTemplate($template);

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

    public function setHeaderTitle($title)
    {
        $this->_headerTitle = $title;
        return $this;
    }

    public function getHeaderTitle()
    {
        return $this->_headerTitle;
    }

    protected function setTemplate($template)
    {
        $this->_template= $template;
        return $this;
    }

    protected function getTemplate()
    {
        return $this->_template;
    }

    protected function setParams($params)
    {
        $this->_params= $params;
        return $this;
    }

    public function getParams()
    {
        return $this->_params;
    }

    public function getContent()
    {
        include BP . "/views/". trim($this->getTemplate());
    }
}