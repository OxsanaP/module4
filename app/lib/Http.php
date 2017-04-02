<?php
namespace app\lib;

class Http
{
    private $_params = array();

    public function getPost($key = null, $default = null)
    {
        if (null === $key) {
            return $_POST;
        }
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }

    public function getParam($key = null, $default = null)
    {
        return (null !== $this->get($key)) ? $this->get($key) : $default;
    }

    public function __get($key)
    {
        switch (true) {
            case isset($this->_params[$key]):
                return $this->_params[$key];
            case isset($_GET[$key]):
                return $_GET[$key];
            case isset($_POST[$key]):
                return $_POST[$key];
            case isset($_COOKIE[$key]):
                return $_COOKIE[$key];
            case isset($_SERVER[$key]):
                return $_SERVER[$key];
            case isset($_ENV[$key]):
                return $_ENV[$key];
            default:
                return null;
        }
    }

    public function get($key)
    {
        return $this->__get($key);
    }

    public function getPrevUrl()
    {
        return $_SERVER['HTTP_REFERER'];
    }
}