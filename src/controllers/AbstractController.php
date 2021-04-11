<?php


namespace Hboudaoud\Controller;


abstract class AbstractController  implements iController
{

    public function __construct(?string $model = null)
    {
    }

    public function httpResponseCode($code)
    {
        http_response_code($code);
        return "<div id='http_response_code' class='d-none'>" . $code ."</div>";
    }

}