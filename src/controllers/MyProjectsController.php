<?php


namespace Hboudaoud\Controller;


class MyProjectsController extends AbstractController
{
    public function index()
    {
        $projects =[];
        for ($i = 1; $i <= 10; $i++){
            $project = (object)['id'=>$i,'slug'=>'slug-num-'.$i];
            $projects[$i]=$project;
        }
        return $this->render('index.php', ['includeFile' => 'index.php', 'projects' => $projects]);
    }
    public function show($id=0,$slug='')
    {
        $project = (object)['id'=>$id,'slug'=>$slug];
        return $this->render('show.php', ['includeFile' => 'index.php', 'project' => $project]);
    }
    public function edit($id=0,$slug='')
    {
        $project = (object)['id'=>$id,'slug'=>$slug];
        return $this->render('edit.php', ['includeFile' => 'index.php', 'project' => $project]);
    }
}