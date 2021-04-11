<?php


namespace Hboudaoud\Controller;


interface iController
{
    public function __construct(?string $model = null);
    public function httpResponseCode($code);
}