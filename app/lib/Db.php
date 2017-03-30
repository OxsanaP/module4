<?php
namespace app\lib;

class Db
{
    private static $instance;

    private $_connection;

    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        // TODO add catch Exception
        $this->_connection = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if(\mysqli_connect_error()){
            throw new \Exception("Cann't conect to DB.");
        }
        $this->_connection->query('SET NAMES utf8');
        $this->_connection->query('SET CHARACTER SET utf8');
        $this->_connection->query('SET COLLATION_CONNECTION="utf8_general_ci"');
    }

    public function getConnection()
    {
       return $this->_connection;
    }

    private function __clone()
    {
    }

    private function __sleep()
    {
    }

    private function __wakeup()
    {
    }

}