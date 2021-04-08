<?php


namespace HBoudaoud\Router;

class Router {

    private $url;
    private $routes = [];
    private $namedRoutes = [];

    public function __construct($url){
        $this->url = $url;
    }

    public function get($path, $callable, $name = null): Route
    {
        return $this->add($path, $callable, $name, 'GET');
    }

    public function post($path, $callable, $name = null): Route
    {
        return $this->add($path, $callable, $name, 'POST');
    }

    private function add($path, $callable, $name, $method): Route
    {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if(is_string($callable) && $name === null){
            $name = $callable;
        }
        if($name){
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    public function run(){

        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
            throw new RouterException('The request method does not exist');
        }
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            if($route->match($this->url)){
                return $route->call();
            }

        }
        throw new RouterException(
            "<p>Router error : No matching routes : {$this->url}<br>".
            $_SERVER['REQUEST_METHOD'].
            "</p><pre>".
            print_r($this->routes[$_SERVER['REQUEST_METHOD']], 1).
            "</pre>"
        );
    }

    public function url($name, $params = []){
        if(!isset($this->namedRoutes[$name])){
            throw new RouterException(
            "<p>Router error : No route matches this name : {$name}</p><pre>namedRoutes ".
            print_r($this->namedRoutes[$name], 1).
            "</pre>");
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }

}