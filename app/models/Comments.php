<?php
namespace app\models;

use app\models\AbstractModel;

class Comments extends AbstractModel
{
    protected $_tableName = "comments";

    public function getComments($id)
    {
        $result = $this->query("SELECT {$this->_tableName}.*,users.username  FROM {$this->_tableName} 
          left join users on {$this->_tableName}.user_id=users.id 
          where {$this->_tableName}.news_id=:id order by rate DESC",
            array('id' => $id)
        );
        if (!$result) {
            return false;
        }
        $data = array('main' => array(), 'other' => array());
        foreach ($result as $value) {
            if ($value['parent_id'] == null) {
                $data['main'][] = $value;
            } else {
                if (!isset($data['other'][$value['parent_id']])) {
                    $data['other'][$value['parent_id']] = array();
                }
                $data['other'][$value['parent_id']][] = $value;
            }
        }
        return $data;
    }

    public function addComment($param)
    {
        $allowed = array("parent_id", "news_id", "user_id", "content");
        $result = $this->insert($allowed, $param);
    }

    public function rate($id, $rate)
    {
        $comment = $this->load($id);
        if (empty($comment)) {
            return false;
        }
        $comment['rate'] += $rate;

        $allowed = array('rate');
        $values = array('rate' => $comment['rate']);
        $cond = "id = :id";
        $condParams = array('id' => (int)$id);
        $this->update($allowed, $values, $cond, $condParams);
    }

    public function updateContent($id, $content)
    {
        $allowed = array('content');
        $values = array('content' => $content);
        $cond = "id = :id";
        $condParams = array('id' => (int)$id);
        $this->update($allowed, $values, $cond, $condParams);
    }

    public function getTopComentators()
    {
        return $this->query("SELECT count(*) as count, {$this->_tableName}.user_id, users.username FROM {$this->_tableName}
          LEFT JOIN users on users.id = {$this->_tableName}.user_id
            GROUP BY {$this->_tableName}.user_id
            ORDER BY count DESC
            LIMIT 0, 5");
    }


    public function getCommentsByUserId($id, $limit, $page = 0)
    {
        if ($page > 0) {
            $offset = $page - 1;
        }
        $offset = $offset * $limit;

        $sql = "SELECT * FROM {$this->_tableName}         
          where {$this->_tableName}.user_id= :userId
          order by {$this->_tableName}.create_at DESC 
          LIMIT :offset , :limit";
        $params = array(
            'userId' => $id,
            'offset' => $offset,
            'limit' => $limit,
        );
        return $this->query($sql, $params);
    }

    public function getCountCommentsByUserId($id)
    {
        $result = $this->fetchOne("SELECT count(*) as count FROM {$this->_tableName} where user_id=:id",
            array('id' => $id));
        return $result['count'];
    }
}