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

    public function getAllCategories()
    {
        return $this->query("SELECT * FROM {$this->_tableName} where parent_id is null order by id");
    }

    public function getCategories()
    {
        return $this->query("SELECT * FROM {$this->_tableName} where parent_id is null and visible_on_menu = 1 order by id");
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

    public function getSearchResult($start, $end, $category, $tags, $limit, $page = 0)
    {
        if ($page > 0) {
            $offset = $page - 1;
        }
        $offset = $offset * $limit;

        $sql = "SELECT * FROM news";
        $sqlCount = "SELECT count(DISTINCT news.id) as count FROM news";
        $where = array();
        $params = array();
        if ($category) {
            $sql .= " JOIN category_news ON category_news.news_id = news.id LEFT JOIN category on category.id=category_news.category_id";
            $sqlCount .= " JOIN category_news ON category_news.news_id = news.id LEFT JOIN category on category.id=category_news.category_id";
            $cats = explode(",", $category);
            $cond = "";
            $i = 1;
            foreach ($cats as $cat) {
                if (trim($cat) == "") {
                    continue;
                }
                $param = "category" . $i;
                $cond .= ($cond == "") ? "(category.name LIKE :" . $param : " OR category.name LIKE :" . $param;
                $params[$param] = "%" . trim($cat) . "%";
                $i++;
            }
            if ($cond != "") {
                $cond .= ")";
                $where[] = $cond;
            }
        }

        if ($tags) {
            $sql .= " JOIN tag_news ON tag_news.news_id = news.id LEFT JOIN tag on tag.id=tag_news.tag_id";
            $sqlCount .= " JOIN tag_news ON tag_news.news_id = news.id LEFT JOIN tag on tag.id=tag_news.tag_id";
            $cats = explode(",", $tags);
            $cond = "";
            $i = 1;
            foreach ($cats as $cat) {
                if (trim($cat) == "") {
                    continue;
                }
                $param = "tag" . $i;
                $cond .= ($cond == "") ? "(tag.name LIKE :" . $param : " OR tag.name LIKE :" . $param;
                $params[$param] = "%" . trim($cat) . "%";
                $i++;
            }
            if ($cond != "") {
                $cond .= ")";
                $where[] = $cond;
            }
        }

        if ($start || $end) {
            if ($start) {
                $start = new \DateTime($start);
                $start = $start->format("Y-m-d H:s:i");
            }

            if ($end) {
                $end = new \DateTime($end);
                $end = $end->format("Y-m-d H:s:i");
            }

            $cond = "";
            if ($start && $end) {
                $cond .= "(news.create_at>=:startDate and news.create_at<=:endDate)";
                $params["startDate"] = $start ;
                $params["endDate"] = $end;
            } elseif ($start) {
                $cond .= "(news.create_at>=:startDate)";
                $params["startDate"] = $start;
            } elseif ($end) {
                $cond .= "(news.create_at<=:endDate)";
                $params["endDate"] = $end;
            }
            if ($cond != "") {
                $where[] = $cond;
            }
        }
        if (count($where) > 0) {
            $sql .= " where " . implode(" AND ", $where);
            $sqlCount .= " where " . implode(" AND ", $where);
        }

        $sql .= " GROUP BY news.id";
        $result = $this->fetchOne($sqlCount, $params);

        $sql .= " LIMIT :offset , :limit";
        $params['offset'] = $offset;
        $params['limit'] = $limit;

        return array(
            "main" => $this->query($sql, $params),
            "count" => $result['count']
        );

    }

    public function addCategory($params)
    {
        $allowed = array("name", "parent_id");

        try {
            $this->getConnection()->beginTransaction();
            $values = array(
                'name' => $params['name'],
                'parent_id' => $params['parent_id']
            );
            $result = $this->insert($allowed, $values);
            $this->getConnection()->commit();
            return true;
        } catch (\PDOException $e) {
            $this->getConnection()->rollback();
            return $e->getMessage();
            //throw  new  \Exception("Can not create  user. Database error: " . $e->getMessage());
        }
    }

    public function getCategoryOther()
    {
        return $this->query("SELECT * FROM {$this->_tableName} order by id");
    }

    public function getCategoryTree()
    {
        $result = $this->getCategoryOther();

        if (!$result) {
            return false;
        }
        $data = array('main' => array(), 'child' => array());
        foreach ($result as $value) {
            if ($value['parent_id'] == null) {
                $data['main'][] = $value;
            } else {
                if (!isset($data['child'][$value['parent_id']])) {
                    $data['child'][$value['parent_id']] = array();
                }
                $data['child'][$value['parent_id']][] = $value;
            }
        }
        return $data;
    }

    public function deleteCategory($id)
    {
        $sql = "DELETE FROM {$this->_tableName} WHERE id=:id";
        try {
            $this->getConnection()->beginTransaction();
            $this->query($sql, array('id' =>$id));
            $this->getConnection()->commit();
            return true;
        } catch (\PDOException $e) {
            $this->getConnection()->rollback();
            return $e->getMessage();
            //throw  new  \Exception("Can not create  user. Database error: " . $e->getMessage());
        }
    }

    public function getChildCount($id)
    {
        $result = $this->fetchOne("SELECT count(*) as count FROM {$this->_tableName} where parent_id=:id",
            array('id' => $id));
        return $result['count'];
    }

}