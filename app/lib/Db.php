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
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $opt = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $this->_connection = new \PDO($dsn, DB_USER, DB_PASS, $opt);
        //$this->_connection->setFetchMode(\PDO::FETCH_ASSOC);
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