<?php
namespace app\models;

use app\models\AbstractModel;
use app\models\Category;

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

    public function trimContent($content, $countSentenses = 5)
    {
        $data = explode('. ', $content);
        $result = '';
        if (count($data) <= $countSentenses) {
            $countSentenses = count($data);
        }
        for ($i = 0; $i < $countSentenses; $i++) {
            $result .= $data[$i] . '. ';
        }
        return $result;
    }

    public function addPost($params)
    {
        try {
            $this->getConnection()->beginTransaction();

            $allowed = array("title", "content", 'image');
            $values = array(
                'title' => $params['title'],
                'content' => $params['content'],
                'image' => $params['image']
            );
            $this->insert($allowed, $values);

            $id = $this->getConnection()->lastInsertId();

            $allowed = array('category_id', 'news_id');
            foreach ($params['category'] as $category) {
                $values = array('category_id' => $category, 'news_id' => $id);
                $sql = "INSERT INTO category_news SET " . $this->pdoSet($allowed, $values);
                $stmt = $this->getConnection()->prepare($sql);
                $stmt->execute($values);
            }

            $allowed = array('tag_id', 'news_id');
            foreach ($params['tags'] as $tag) {
                $values = array('tag_id' => $tag, 'news_id' => $id);
                $sql = "INSERT INTO tag_news SET " . $this->pdoSet($allowed, $values);
                $stmt = $this->getConnection()->prepare($sql);
                $stmt->execute($values);
            }
            $this->getConnection()->commit();
            return true;
        } catch (\PDOException $e) {
            $this->getConnection()->rollback();
            return $e->getMessage();
            //throw  new  \Exception("Can not create  user. Database error: " . $e->getMessage());
        }
    }
}