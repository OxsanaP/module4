<?php
namespace app\models;

use app\models\AbstractModel;

class News extends AbstractModel
{
    public function  getCategoryNews($categoryId, $limit)
    {
        if ($limit>1) {
            $limit = $limit-1;
        }
        $sql = "SELECT * FROM `news`
          LEFT JOIN category_news ON news_id = news.id 
          where category_news.category_id= {$categoryId}
          order by news.create_at
          LIMIT 0 , {$limit}" ;

        return $this->query($sql);
    }

}