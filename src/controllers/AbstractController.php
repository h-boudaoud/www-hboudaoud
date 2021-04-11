<?php


namespace Hboudaoud\Controller;


abstract class AbstractController implements iController
{

    public function __construct(?string $model = null)
    {
    }

    public function httpResponseCode($code)
    {
        http_response_code($code);
        return "<div id='http_response_code' class='d-none'>" . $code ."</div>";
    }

    protected function render($filename, $data = null)
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['APP_VIEW'] .
            lcfirst(str_replace(
                    'Controller', '',
                    str_replace('Hboudaoud\Controller\\', '', get_class($this))
                )
            ) .
            '/' . $filename;
        //die($path);

        ob_start();
        include $path;
        return ob_get_clean();
    }

    protected function renderRedirectTo($filename){
        header('Location: /public'.$filename);
    }

}