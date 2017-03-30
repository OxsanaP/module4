<?php
namespace app\models;

use app\models\AbstractModel;

class News extends AbstractModel
{
    public function  getCategoryNews($categoryId, $limit, $offset=0)
    {
        $sql = "SELECT * FROM `news`
          LEFT JOIN category_news ON news_id = news.id 
          where category_news.category_id= {$categoryId}
          order by news.create_at
          LIMIT {$offset} , {$limit}" ;

        return $this->query($sql);
    }

}