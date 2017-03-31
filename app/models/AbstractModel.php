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

    public function query($sql, $params = array())
    {
        $stmt = $this->_getStatement($sql, $params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function fetchOne($sql, $params = array())
    {
        $stmt = $this->_getStatement($sql, $params);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $sql
     * @param $params
     * @return \PDOStatement
     */
    protected function _getStatement($sql, $params)
    {
        if (empty($params)) {
            $stmt = $this->getConnection()->query($sql);
        } else {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute($params);
        }
        return $stmt;
    }
}