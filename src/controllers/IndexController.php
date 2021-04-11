<?php


namespace Hboudaoud\Controller;


class IndexController
{
    public function index(): string
    {
        return "<h2>Welcome in my website</h2>".
            "<br />Environment    : {$_SERVER["APP_ENV"]}".
            "<br />REQUEST_URI   :{$_SERVER["REQUEST_URI"]}".
            "<br />REDIRECT_URL   :".$_SERVER['REDIRECT_URL'].
            "<br />QUERY_STRING   :".$_SERVER['QUERY_STRING'].
            "<br />DOCUMENT_ROOT   :{$_SERVER["DOCUMENT_ROOT"]}".
            "<br />getcwd    : ".getcwd();
    }
    public function about(): string
    {
        return "<h2>A little bit about me</h2>";
    }
    public function mycv(): string
    {
        return "<h2>My CV</h2>";
    }
    public function contact(): string
    {
        if(!empty($_POST)){
            return "<h2>Message sent</h2><pre>".print_r($_POST,true)."</pre>";
        }
        return "<h2>Send me a message</h2>".
            '<form method="post">'.
            ' <label>Name</label>'.
            '    <input type="text" name="name">'.
            '    <button type="submit">Envoyer</button>'.
            '</form>';
    }


}