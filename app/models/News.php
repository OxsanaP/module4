<?php
namespace app\models;

use app\models\AbstractModel;

class News extends AbstractModel
{
    protected $_tableName = "news";

    public function getCategoryNews($categoryId, $limit, $offset = 0)
    {
        $sql = "SELECT * FROM `news`
          LEFT JOIN category_news ON news_id = news.id 
          where category_news.category_id= :categoryId
          order by news.create_at
          LIMIT :offset , :limit";
        $params = array(
            'categoryId' => $categoryId,
            'offset' => $offset,
            'limit' => $limit,
        );
        return $this->query($sql, $params);
    }

    public function load($id)
    {
        return $this->fetchOne("SELECT * FROM {$this->_tableName} where id=:id", array('id' => $id));
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

}