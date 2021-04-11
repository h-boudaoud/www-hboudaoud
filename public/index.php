<?php

session_start();

use Config\DevCoder\DotEnv;
use Hboudaoud\Controller\IndexController;
use HBoudaoud\Router\Router;

include_once __DIR__ . '/../config/DotEnv.php';
(new DotEnv(__DIR__ . '/../.env'))->load();


$_ENV['APP_CONTENT'] = '';
global $contentError;
$contentError = function ($e) {
    $_ENV['APP_CONTENT'] = "<div class='error'>{$e->getMessage()}</div>";
};

// Include router class
include(__DIR__ . '/../src/Router/Router.php');
include(__DIR__ . '/../src/Router/RouterException.php');
include(__DIR__ . '/../src/Router/Route.php');


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

include_once __DIR__ . '/../src/views/layout.php';