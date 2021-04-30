<?php


namespace Hboudaoud\Controller;


include_once 'interface/iController.php';
abstract class AbstractController implements iController
{

    public function __construct()
    {
    }

    public function httpResponseCode($code)
    {
        http_response_code($code);
        return "<div id='http_response_code' class='d-none'>" . $code ."</div>";
    }

    protected function render($filename, $data = null)
    {
        $_SERVER['title'] =isset($data['title'])?$data['title']:str_replace(['Hboudaoud\Controller\\','Controller'],'',get_class($this));
        $path = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['APP_VIEW'] .
            lcfirst(str_replace(
                    'Controller', '',
                    str_replace('Hboudaoud\Controller\\', '', get_class($this))
                )
            ) .
            '/' . $filename;
        //die($path);

        if(!file_exists($path)){
            throw new \Exception(sprintf('The view %s does not exist', $filename));
        }
        ob_start();
        include $path;
        return ob_get_clean();
    }

    protected function renderRedirectTo($filename): bool
    {
        header('Location: /public'.$filename);
        return true;
    }

}