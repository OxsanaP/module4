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

    public function isLogined()
    {
        if (isset($_SESSION['user_id'])){
            return true;
        }
        return false;
    }

    public function getUserName()
    {
        if (isset($_SESSION['user_name'])){
            return htmlspecialchars($_SESSION['user_name']);
        }
        return '';

    }
}