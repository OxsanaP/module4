<?php
namespace app\lib;

class Session
{
    public function getErrorMessage($clear = true)
    {
        $mesages = false;
        if (!empty($_SESSION["error_message"])) {
            $mesages = $_SESSION["error_message"];
            if ($clear) {
                unset($_SESSION["error_message"]);
            }
        }
        return $mesages;
    }

    public function setErrorMessage($message)
    {
        $mesages = array();
        if (!empty($_SESSION["error_message"])) {
            $mesages = $_SESSION["error_message"];
        }
        $mesages[] = $message;
        $_SESSION["error_message"] = $mesages;
    }

    public function setSuccesMessage($message)
    {
        $mesages = array();
        if (!empty($_SESSION["succes_message"])) {
            $mesages = $_SESSION["succes_message"];
        }
        $mesages[] = $message;
        $_SESSION["succes_message"] = $mesages;
    }

    public function getSuccessMessage($clear = true)
    {
        $mesages = false;
        if (!empty($_SESSION["succes_message"])) {
            $mesages = $_SESSION["succes_message"];
            if ($clear) {
                unset($_SESSION["succes_message"]);
            }
        }
        return $mesages;
    }

    public function isLogined()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        }
        return false;
    }

    public function getUserName()
    {
        if (isset($_SESSION['user_name'])) {
            return htmlspecialchars($_SESSION['user_name']);
        }
        return '';

    }

    public function getUserId()
    {
        if (isset($_SESSION['user_id'])) {
            return (int)$_SESSION['user_id'];
        }
        return false;
    }

    public function setValue($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function fetchValue($key)
    {
        if (isset($_SESSION[$key])) {
            $val = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $val;
        }
        return '';
    }

    public function getRole()
    {
        if (isset($_SESSION['role'])) {
            return (int)$_SESSION['role'];
        }
        return false;
    }
}