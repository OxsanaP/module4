<?php
namespace app\models;

use app\models\AbstractModel;
use app\models\News;

class Category extends AbstractModel
{
    protected $_tableName = "category";

    public function getCategoriesForMain()
    {
        $categories = $this->getCategories();
        $newsModel = new News();
        foreach ($categories as $key=>$category){
            $news = $newsModel->getCategoryNews($category['id'], 5);
            $categories[$key]['news'] = $news;
        }
        return $categories;
    }

    public function getCategories()
    {
        return $this->query("SELECT * FROM {$this->_tableName} where parent_id is null order by id");
    }

}