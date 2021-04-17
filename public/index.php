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
use HBoudaoud\Router\Router;

include_once $_SERVER['DOCUMENT_ROOT'] . 'config/bin/DotEnv.php';

if(!file_exists($_SERVER['DOCUMENT_ROOT']  . '.env')){
echo 'change or copy the name of the ".env.example" file to ".env"';
die();
}
(new DotEnv($_SERVER['DOCUMENT_ROOT']  . '.env'))->load();


$_ENV['APP_CONTENT'] = '';
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
    $controller_directory = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['APP_CONTROLLER'];
    if (!is_dir($controller_directory)) {
        throw new Exception("The value APP_CONTROLLER is not valid or not define in .env");
    }
    $scanned_directory = array_diff(
        scandir($controller_directory.'interface/'),
        array('..', '.')
    );

    foreach ($scanned_directory as $file) {
        include_once $controller_directory .'interface/'. $file;
    }

    $scanned_directory = array_diff(
        scandir($controller_directory),
        array('..', '.','interface')
    );
    foreach ($scanned_directory as $file) {
        include_once $controller_directory . $file;
    }
} catch (Exception $e) {
    $_ENV['APP_CONTENT'] = "<div class='error'>{$e->getMessage()}</div>";
}

$router = new Router($_SERVER['REDIRECT_URL']);
$router->get(
    '/',
    function () use ($contentError) {
        try {
            if(!class_exists('\Hboudaoud\Controller\IndexController')) {
                throw new Exception('IndexController does not exist');
            }

            $controller = new Hboudaoud\Controller\IndexController();
            $_ENV['APP_CONTENT'] = $controller->index();
        } catch (Exception $e) {
            $contentError($e);
        }
    },
    'index'
);

$router->get('about',
    function () use ($contentError) {
        try {

            if(!class_exists('\Hboudaoud\Controller\IndexController')) {
                throw new Exception('IndexController does not exist');
            }

            $controller = new Hboudaoud\Controller\IndexController();
            $_ENV['APP_CONTENT'] = $controller->about();
        } catch (Exception $e) {
            $contentError($e);
        }
    },
    'about'
);
$router->get('mycv',
    function () use ($contentError) {
        try {

            if(!class_exists('\Hboudaoud\Controller\IndexController')) {
                throw new Exception('IndexController does not exist');
            }

            $controller = new Hboudaoud\Controller\IndexController();
            $_ENV['APP_CONTENT'] = $controller->mycv();
        } catch (Exception $e) {
            $contentError($e);
        }
    },
    'mycv'
);
$router->get('contact',
    function () use ($contentError) {
        try {
            if(!class_exists('\Hboudaoud\Controller\IndexController')) {
                throw new Exception('IndexController does not exist');
            }
            $controller = new Hboudaoud\Controller\IndexController();
            $_ENV['APP_CONTENT'] = $controller->contact();
        } catch (Exception $e) {
            $contentError($e);
        }
    },
    'contact'
);

$router->Post('contact',
    function () use ($contentError) {
        try {
            if(!class_exists('\Hboudaoud\Controller\IndexController')) {
                throw new Exception('IndexController does not exist');
            }
            $controller = new Hboudaoud\Controller\IndexController();
            $_ENV['APP_CONTENT'] = $controller->contact();
        } catch (Exception $e) {
            $contentError($e);
        }
    },
    'contact'
);

$router->post(
    '/myProjects/edit/:id-:slug',
    function ($id, $slug) use ($contentError) {
        try {
            if(!class_exists('\Hboudaoud\Controller\MyProjectsController')) {
                throw new Exception('MyProjectsController does not exist');
            }

            $controller = new Hboudaoud\Controller\MyProjectsController();
            $_ENV['APP_CONTENT'] = $controller->edit($id, $slug);
        } catch (Exception $e) {
            $contentError($e);
        }
    },
    'projectEditById_Slug'
)->with('id', '\d+');

$router->post(
    '/myProjects/edit/:id',
    function ($id) use ($contentError) {
        try {
            if(!class_exists('\Hboudaoud\Controller\MyProjectsController')) {
                throw new Exception('MyProjectsController does not exist');
            }

            $controller = new Hboudaoud\Controller\MyProjectsController();
            $_ENV['APP_CONTENT'] = $controller->edit($id);
        } catch (Exception $e) {
            $contentError($e);
        }
    },
    'projectEditById'
)->with('id', '\d+');


$router->get(
    '/myProjects/edit/:id',
    function ($id) use ($contentError) {
        try {
            if(!class_exists('\Hboudaoud\Controller\MyProjectsController')) {
                throw new Exception('MyProjectsController does not exist');
            }

            $controller = new Hboudaoud\Controller\MyProjectsController();
            $_ENV['APP_CONTENT'] = $controller->edit($id);
        } catch (ErrorException $e) {
            $contentError($e);
        }
    },
    'projectEditById_Slug'
)->with('id', '\d+');


$router->get(
    '/myProjects/edit/:id-:slug',
    function ($id, $slug) use ($contentError) {
        try {
            if(!class_exists('\Hboudaoud\Controller\MyProjectsController')) {
                throw new Exception('MyProjectsController does not exist');
            }

            $controller = new Hboudaoud\Controller\MyProjectsController();
            $_ENV['APP_CONTENT'] = $controller->edit($id, $slug);
        } catch (ErrorException $e) {
            $contentError($e);
        }
    },
    'projectEditById_Slug'
)->with('id', '\d+');


$router->get(
    '/myProjects/:id',
    function ($id) use ($contentError) {
        try {
            if(!class_exists('\Hboudaoud\Controller\MyProjectsController')) {
                throw new Exception('MyProjectsController does not exist');
            }

            $controller = new Hboudaoud\Controller\MyProjectsController();
            $_ENV['APP_CONTENT'] = $controller->show($id);
        } catch (Exception $e) {
            $contentError($e);
        }
    },
    'projectById'
)->with('id', '\d+');

$router->get(
    '/myProjects/:id-:slug',
    function ($id, $slug) use ($contentError) {
        try {
            if(!class_exists('\Hboudaoud\Controller\MyProjectsController')) {
                throw new Exception('MyProjectsController does not exist');
            }

            $controller = new Hboudaoud\Controller\MyProjectsController();
            $_ENV['APP_CONTENT'] = $controller->show($id, $slug);
        } catch (Exception $e) {
            $contentError($e);
        }
    },
    'projectById_Slug'
)->with('id', '\d+');

$router->get(
    '/myProjects/',
    function () use ($contentError) {
        try {
            if(!class_exists('\Hboudaoud\Controller\MyProjectsController')) {
                throw new Exception('MyProjectsController does not exist');
            }

            $controller = new \Hboudaoud\Controller\MyProjectsController();
            $_ENV['APP_CONTENT'] = $controller->index();
        } catch (Exception $e) {
            $contentError($e);
        }
    },
    'projects'
);
try {
    $router->run();
} catch (\HBoudaoud\Router\RouterException $e) {
    $contentError($e);
}


// echo ;

include_once $_SERVER['DOCUMENT_ROOT']  . 'src/views/layout.php';