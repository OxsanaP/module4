<?php

namespace app\models;

use app\lib\Db;

class AbstractModel
{
    protected $_connection = null;
    protected $_tableName = "";

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

    protected function pdoSet($allowed, &$values)
    {
        $set = '';
        foreach ($allowed as $key => $field) {
            if (isset($values[$field])) {
                $set .= "`" . str_replace("`", "``", $field) . "`" . "=:$field, ";
            } else {
                unset($values[$key]);
            }
        }
        return substr($set, 0, -2);
    }

    protected function update($allowed, $values, $cond, $condParams)
    {
        $sql = "UPDATE {$this->_tableName} SET " . $this->pdoSet($allowed, $values) . " WHERE $cond";
        $stmt = $this->getConnection()->prepare($sql);
        $condParams = array_merge($values, $condParams);
        $stmt->execute($condParams);
    }

    protected function insert($allowed, $values)
    {
        $sql = "INSERT INTO {$this->_tableName} SET " . $this->pdoSet($allowed, $values);
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($values);
    }

    public function load($id)
    {
        return $this->fetchOne("SELECT * FROM {$this->_tableName} where id=:id", array('id' => $id));
    }
}
