<?php


namespace Hboudaoud\Controller;


class MyProjectsController
{
    public function index()
    {
        return "<h2>See all projects</h2>";
    }
    public function show($id=0,$slug='')
    {
        return "<h2>See project</h2>".
            "<div>MyProjectsController -- action show id: $id".
            (empty($slug)?'':" -- slug : $slug").
            "<br /><a href='/myProjects/edit/$id".(empty($slug)?'':"-$slug")."'>".
            "Edit</a>".
            "</div>";
    }
    public function edit($id=0,$slug='')
    {

        $message= "<h2>edit project</h2>".
            "<div>MyProjectsController -- action edit id: $id".
            (empty($slug)?'':" -- slug : $slug").
            "</div>";
        if(empty($_POST)){
            $message .=
            '<form method="post">'.
            ' <label>Project name</label>'.
            '    <input type="text" name="name">'.
            '    <button type="submit">Envoyer</button>'.
            '</form>';
        }else{
            $message.="<pre>".print_r($_POST,true)."</pre>";
        }

        return $message;
    }
}