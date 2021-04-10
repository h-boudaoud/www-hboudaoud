<?php


namespace HBoudaoud\Router;


class Route{


    private $path;
    private $callable;
    private $matches = [];
    private $params = [];

    public function __construct($path, $callable){
        $this->path = trim($path, '/');  // Remove the useless '/'
        $this->callable = $callable;
    }

    /**
     * To capture the url with the parameters
     * example : get('/posts/:slug-:id')
     **/
    public function match($url): bool
    {
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";

        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    private function paramMatch($match): string
    {
        if(isset($this->params[$match[1]])){
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    public function getUrl($params){
        $path = $this->path;
        foreach($params as $k => $v){
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }

    public function call()
    {
        return call_user_func_array($this->callable, $this->matches);
    }

    public function with($param, $regex): Route
    {
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this; // To use Method Chaining
    }

}