<?php

class Route
{
    public static function match()
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
        $modelName = $controllerName . "Model";
        $controllerName .=  'Controller';
        $actionName = strtolower($actionName) . 'Action';

        $modelPath = BP . "/app/models/" . $modelName . '.php';
        if (file_exists($modelPath)) {
            include $modelPath;
        }

        $controllerPath = BP . "/app/controllers/" . $controllerName . '.php';
        if (file_exists($controllerPath)) {
            include $controllerPath;
        } else {
          Route::errorPage404();
        }

        $controller = new $controllerName;
        $action = $actionName;

        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            Route::errorPage404();
        }

    }

    public static function errorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . '404');
    }
}