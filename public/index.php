<?php

session_start();

//
///***   To debug code     ****/
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//ini_set('track_errors' ,1);
//error_reporting(-1);
///*************************/
//
//
///***   Router in index.php     ****/
//// a processing on the rest of the parameters
//// is to be set up to manage the urls like "/myProjects/22-slug"
//// if not you must use the url "/myProjects/show/22/slug"
//$params = explode('/',$_SERVER['REQUEST_URI']);
//array_shift($params);
//$controllerName = array_shift($params);
//$controllerName = !empty($controllerName)?$controllerName:'index';
//$action = array_shift($params); //index est le controlleur de ton choix si url = /
//$action = !empty($action)?$action:'index'; //index est l'action de ton choix si url = / ou /toto/
//echo "controller : $controllerName , action : $action , params:".print_r($params, 1);
//
////A modifié selon le chemain vers ton controlleur
//$controllerPath = $_SERVER['DOCUMENT_ROOT'] . 'src/controllers/'.ucfirst ($controllerName).'Controller.php';
//
//echo '<br>controllerPath :'.$controllerPath;
//if (!file_exists($controllerPath)) {
//    echo "<br>throw new Exception( ton code si le controlleur n'existe pas)";
//}else {
//    $controllerName= 'Hboudaoud\Controller\\' .ucfirst($controllerName).'Controller';
//    include_once $_SERVER['DOCUMENT_ROOT'] . 'src/controllers/AbstractController.php';
//    include_once $controllerPath;
//    $controller = new $controllerName();
//    if (!method_exists($controller, $action)) {
//        echo "<br>throw new Exception(  ton code si la methode $action n'existe pas)";
//
//    }else {
//
//        echo '<br>controllerName ' . $controllerName.'<br>';
//        // fonction pour executer ta commande
//        echo call_user_func_array([$controller, $action], $params);
//    }
//}
//die();
//
//




use Hboudaoud\Config\Bin\DotEnv;
use Hboudaoud\Config\Bin\RouteReflector;
use HBoudaoud\Router\Router;


if(!file_exists($_SERVER['DOCUMENT_ROOT']  . '.env')){
echo 'change or copy the name of the ".env.example" file to ".env"';
die();
}
include_once $_SERVER['DOCUMENT_ROOT'] . 'config/bin/DotEnv.php';
include_once $_SERVER['DOCUMENT_ROOT'] . 'config/bin/RouteReflector.php';
try {
    (new DotEnv($_SERVER['DOCUMENT_ROOT'] . '.env'))->load();
} catch (\Hboudaoud\Config\ConfigException $e) {
}


$_ENV['APP_CONTENT'] = '';
$_SERVER['REDIRECT_URL'] = isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : '/';
global $contentError;
$contentError = function ($e) {
    $_ENV['APP_CONTENT'] = "<div class='error'>{$e->getMessage()}</div>";
};

// Include router class
include($_SERVER['DOCUMENT_ROOT']  . 'src/Router/Router.php');
include($_SERVER['DOCUMENT_ROOT']  . 'src/Router/RouterException.php');
include($_SERVER['DOCUMENT_ROOT']  . 'src/Router/Route.php');


//Include Controllers class
// in env add APP_CONTROLLER = src/controllers/
try {
    $router = new Router($_SERVER['REDIRECT_URL']);
    $routeReflector = new RouteReflector($router);
    $controller_directory = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['APP_CONTROLLER'];
    if (!is_dir($controller_directory)) {
        throw new Exception("The value APP_CONTROLLER is not valid or not define in .env");
    }
    include_once $controller_directory . 'AbstractController.php';

    $scanned_directory = array_diff(
        scandir($controller_directory),
        array('..', '.', 'interface', 'AbstractController.php')
    );
    foreach ($scanned_directory as $filename) {

        include_once $controller_directory . $filename;
        $class = "\Hboudaoud\Controller\\" . str_replace('.php', '', $filename);
        $routeReflector->setClassName($class)->load();

    }
    $router->run();

} catch (\HBoudaoud\Router\RouterException $e) {
    $contentError($e);
} catch (Exception $e) {
    $_ENV['APP_CONTENT'] = "<div class='error'>{$e->getMessage()}</div>";
}

include_once $_SERVER['DOCUMENT_ROOT']  . 'src/views/layout.php';