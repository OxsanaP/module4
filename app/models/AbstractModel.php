<?php
namespace app\models;

use app\lib\Db;

class AbstractModel
{
    protected $_connection = null;

    public function getConnection()
    {
        if (null === $this->_connection) {
            $db = Db::getInstance();
            $this->_connection = $db->getConnection();
        }
        return $this->_connection;
    }

    public function query($sql)
    {
        $result = $this->getConnection()->query($sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function fetchOne($sql)
    {
        $result = $this->getConnection()->query($sql);
        return mysqli_fetch_assoc($result);
    }
}