<?php
namespace app\models;

use app\models\AbstractModel;

class News extends AbstractModel
{
    protected $_tableName = "news";

    public function getCategoryNews($categoryId, $limit, $offset = 0)
    {
        $sql = "SELECT * FROM {$this->_tableName}
          LEFT JOIN category_news ON news_id = news.id 
          where category_news.category_id= :categoryId
          order by news.create_at DESC 
          LIMIT :offset , :limit";
        $params = array(
            'categoryId' => $categoryId,
            'offset' => $offset,
            'limit' => $limit,
        );
        return $this->query($sql, $params);
    }


    public function updateViewed($id, $count)
    {
        $current = $this->load($id);
        $count += $current['viewed'];
        $allowed = array('viewed');
        $values = array('viewed' => $count);
        $cond = "id = :id";
        $condParams = array('id' => (int)$id);
        $this->update($allowed, $values, $cond, $condParams);
        return $count;
    }

    public function getSliderData()
    {
        $sql = "SELECT * FROM {$this->_tableName} where image is not null order by news.create_at  DESC LIMIT 0 , :limit";
        $params = array('limit' => 4);
        return $this->query($sql, $params);
    }

    public function getNewsByTagId($id)
    {
        $sql = "SELECT * FROM {$this->_tableName}
          JOIN tag_news ON news_id = {$this->_tableName}.id 
          where tag_news.tag_id= :tagId
          order by news.create_at DESC";
        $params = array('tagId' => $id);
        return $this->query($sql, $params);
    }

    public function getCountNewsByTagId($id)
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->_tableName}
          JOIN tag_news ON news_id = {$this->_tableName}.id 
          where tag_news.tag_id= :tagId";
        $params = array('tagId' => $id);
        $result = $this->fetchOne($sql, $params);
        return $result['count'];
    }
}