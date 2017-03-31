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
        foreach ($categories as $key => $category) {
            $categories[$key]['url'] = '/category?id=' . $category['id'];
            $news = $newsModel->getCategoryNews($category['id'], 5);
            $categories[$key]['news'] = $news;
        }
        return $categories;
    }

    public function getCategories()
    {
        return $this->query("SELECT * FROM {$this->_tableName} where parent_id is null order by id");
    }

    public function load($id)
    {
        return $this->fetchOne("SELECT * FROM {$this->_tableName} where id=:id", array('id' => $id));
    }

    public function getCategoryNews($categoryId, $limit, $page = 0)
    {
        if ($page > 0) {
            $offset = $page - 1;
        }
        $offset = $offset * $limit;

        $newsModel = new News();
        return $newsModel->getCategoryNews($categoryId, $limit, $offset);
    }

    public function getCountCategoryNews($id)
    {
        $result = $this->fetchOne("SELECT count(*) as count FROM category_news where category_id=:id",
            array('id' => $id));
        return $result['count'];
    }

}