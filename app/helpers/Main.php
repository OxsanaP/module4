<?php
namespace app\helpers;

use app\models\Category;
use app\models\Tag;

class Main
{
    protected static $_categories;
    protected static $_tags;

    public static function getCategories($full = false)
    {
        if (null === self::$_categories) {
            $model = new Category();
            if ($full) {
                $result = $model->getCategoryOther();
            } else {
                $result = $model->getCategories();
            }
            self::$_categories = array("" => "Please select");
            foreach ($result as $category) {
                self::$_categories[$category["id"]] = $category["name"];
            }
        }
        return self::$_categories;
    }

    public static function getTags()
    {
        if (null === self::$_tags) {
            $model = new Tag();
            $result = $model->getAllTags();
            self::$_tags = array("" => "Please select");
            foreach ($result as $tag) {
                self::$_tags[$tag["id"]] = $tag["name"];
            }
        }
        return self::$_tags;
    }

    public static function buildTreeCategory($data, $id)
    {
        $html = '';
        if (!isset($data['child'][$id])) {
            return '';
        }
        foreach ($data['child'][$id] as $category) {
            $html .= '<div class="row">';
            $html .= '<div class="col-sm-offset-1 col-sm-11">';
            $html .= '<div class="comment">';
            $html .= $category['name'];
            $html .= '<span class="glyphicon glyphicon-trash js-category-delete" data-val="' . $category['id'] . '" aria-hidden="true"></span>';
            $html .= '</div>';
            $html .= self::buildTreeCategory($data, $category['id']);
            $html .= '</div>';
            $html .= '</div>';


        }
        return $html;
    }

}
