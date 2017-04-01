<?php
namespace app\models;

use app\models\AbstractModel;

class Tag extends AbstractModel
{
    protected $_tableName = "tag";

    public function  getNewsTagsById($id)
    {
        $sql = "SELECT * FROM {$this->_tableName}
          JOIN tag_news ON tag_id = {$this->_tableName}.id 
          where tag_news.news_id= :newsId";
        $params = array('newsId' => $id);
        return $this->query($sql, $params);
    }
}