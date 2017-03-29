<?php
namespace app\lib;

class Route
{
    public static function  match()
    {
        // default action and controller
        $controllerName = 'Index';
        $actionName = 'index';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        // get controller name
        if (!empty($routes[1])) {
            $controllerName = $routes[1];
        }

        // get action name
        if (!empty($routes[2])) {
            $actionName = $routes[2];
        }
        $controllerName = ucfirst(strtolower($controllerName));
        $controllerName .=  'Controller';
        $actionName = strtolower($actionName) . 'Action';

        $class = "app\\controllers\\" . $controllerName;
        if (!class_exists($class)){
            die ('404 Not Found');
        }

        $controller = new $class();
        if (is_callable(array($controller, $actionName)) == false) {
            die ('404 Not Found');
        }
        $controller->$actionName();
    }

    public static function errorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . '404');
    }
}