<?php

use Config\DevCoder\DotEnv;

include_once __DIR__ . '/../config/DotEnv.php';

(new DotEnv(__DIR__ . '/../.env'))->load();



// Include router class
include(__DIR__.'/../src/Router/Router.php');
include(__DIR__.'/../src/Router/RouterException.php');
include(__DIR__.'/../src/Router/Route.php');


use HBoudaoud\Router\Router;

$_ENV['APP_CONTENT']='';

$router = new Router($_SERVER['REDIRECT_URL']);
$router->get(
    '/',
    function(){
        $_ENV['APP_CONTENT'] =  "<h2>Welcome in my website</h2>";
    },
    'index'
);

$router->get('about',
    function(){
        $_ENV['APP_CONTENT'] =  "<h2>A little bit about me</h2>";
    },
    'about'
);
$router->get('mycv',
    function(){
        $_ENV['APP_CONTENT'] =  "<h2>My CV</h2>";
    },
    'mycv'
);
$router->get('contact',
    function(){
        $_ENV['APP_CONTENT'] =  "<h2>Send me a message</h2>".
            '<form method="post">'.
            ' <label>Name</label>'.
            '    <input type="text" name="name">'.
            '    <button type="submit">Envoyer</button>'.
            '</form>';
    },
    'contact'
);

$router->Post('contact',
    function(){
        $_ENV['APP_CONTENT'] =  "<h2>Message sent</h2><pre>".print_r($_POST,true)."</pre>";
    },
    'contact'
);

$router->post(
    '/myProjects/:id',
    function($id){
        $_ENV['APP_CONTENT'] =  "<h2>Post: Project $id</h2><pre>".print_r($_POST,true)."</pre>"; },
    'projectById'
)->with('id','\d+');
$router->get(
    '/myProjects/:id',
    function($id) use ($router) { ;
        // $_ENV['APP_CONTENT'] ="<p>{$router->url('projectById_get',['id'=>$id])}</p>".
        $_ENV['APP_CONTENT'] ="<h2>Get Project:  $id</h2>".
        "<p>projectById_get, $id</p>".
            '<form method="post">'.
            ' <label>Project Name</label>'.
            '    <input type="text" name="name">'.
            '    <button type="submit">Envoyer</button>'.
            '</form>';
    },
    'projectById'
)->with('id','\d+');
$router->get(
    '/myProjects/',
    function(){ $_ENV['APP_CONTENT'] = "<h2>See all projects</h2>"; },
    'projects'
);
try {
    $router->run();
} catch (\HBoudaoud\Router\RouterException $e) {
    $_ENV['APP_CONTENT']= "<div class='error'>{$e->getMessage()}</div>";
}

$_ENV['APP_CONTENT'].=
    "<br />Environment    : {$_SERVER["APP_ENV"]}".
    "<br />REQUEST_URI   :{$_SERVER["REQUEST_URI"]}".
    "<br />REDIRECT_URL   :".$_SERVER['REDIRECT_URL'].
    "<br />QUERY_STRING   :".$_SERVER['QUERY_STRING'].
    "<br />DOCUMENT_ROOT   :{$_SERVER["DOCUMENT_ROOT"]}".
    "<br />getcwd    : ".getcwd();

// echo ;

include_once __DIR__ . '/../src/views/layout.php';