<?php


namespace Hboudaoud\Controller;


interface iController
{
    public function __construct();
    public function httpResponseCode($code);
}