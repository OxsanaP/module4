<?php
namespace app\models;

use app\models\AbstractModel;

class User extends AbstractModel
{
    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;

    protected $_tableName = "users";

    private $_user;
    private $_user_id;
    protected $_is_authorized = false;

    public static function isAuthorized()
    {
        if (!empty($_SESSION["user_id"])) {
            return (bool)$_SESSION["user_id"];
        }
        return false;
    }

    public function passwordHash($password, $salt = null, $iterations = 10)
    {
        $salt || $salt = uniqid();
        $hash = md5(md5($password . md5(sha1($salt))));

        for ($i = 0; $i < $iterations; ++$i) {
            $hash = md5(md5(sha1($hash)));
        }

        return array('hash' => $hash, 'salt' => $salt);
    }

    public function getSalt($email)
    {
        $sql = "select salt from users where email = :email";
        $params = array(
            "email" => $email
        );
        $result = $this->fetchOne($sql, $params);
        if (!$result) {
            return false;
        }
        return $result["salt"];
    }

    public function authorize($email, $password, $remember = false)
    {
        if ($this->_is_authorized) {
            return $this->_is_authorized;
        }
        $sql = "select id, username, role from users where
            email = :email and password = :password";

        $salt = $this->getSalt($email);

        if (!$salt) {
            return false;
        }

        $hashes = $this->passwordHash($password, $salt);
        $params = array(
            "email" => $email,
            "password" => $hashes['hash'],
        );

        $this->_user = $this->fetchOne($sql, $params);

        if (!$this->_user) {
            $this->_is_authorized = false;
        } else {
            $this->_is_authorized = true;
            $this->_user_id = $this->_user['id'];
            $this->saveSession($remember);
        }

        return $this->_is_authorized;
    }

    public function logout()
    {
        if (!empty($_SESSION["user_id"])) {
            unset($_SESSION["user_id"]);
            unset($_SESSION["user_name"]);
            unset($_SESSION["role"]);
        }
    }

    public function saveSession($remember = false, $http_only = true, $days = 7)
    {
        $_SESSION["user_id"] = $this->_user_id;
        $_SESSION["user_name"] = $this->_user['username'];
        $_SESSION["role"] = $this->_user['role'];
        if ($remember) {
            // Save session id in cookies
            $sid = session_id();

            $expire = time() + $days * 24 * 3600;
            $domain = ""; // default domain
            $secure = false;
            $path = "/";

            $cookie = setcookie("sid", $sid, $expire, $path, $domain, $secure, $http_only);
        }
    }

    public function create($email, $password, $userName)
    {
        if ($this->getSalt($email)) {
            return "User exists: " . $email;
        }
        $allowed = array("salt", "password", "email", "username"); // allowed fields
        $hashes = $this->passwordHash($password);
        try {
            $this->getConnection()->beginTransaction();
            $values = array(
                'email' => $email,
                'password' => $hashes['hash'],
                'salt' => $hashes['salt'],
                'username' => $userName
            );
            $result = $this->insert($allowed, $values);
            $this->getConnection()->commit();
            return true;
        } catch (\PDOException $e) {
            $this->getConnection()->rollback();
            return "Can not create  user. Database error: " . $e->getMessage();
        }
    }
}