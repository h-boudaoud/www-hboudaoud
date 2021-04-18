<?php


namespace Hboudaoud\Controller;


use Exception;

/**
 * Class MyProjectsController
 * @package Hboudaoud\Controller
 * @BasePath(myProjects)
 */
class MyProjectsController extends AbstractController
{

    /**
     * MyProjectsController index
     * @Route(path="/", name="all", methods=["GET"])
     * @return  string
     * @throws Exception
     */
    public function index(): string
    {
        $projects =[];
        for ($i = 1; $i <= 10; $i++){
            $project = (object)['id'=>$i,'slug'=>'slug-num-'.$i];
            $projects[$i]=$project;
        }
        return $this->render('index.php', ['includeFile' => 'index.php', 'projects' => $projects]);
    }


    /**
     * MyProjectsController show path="/:id{\d+}-:slug"
     * @Route(path="/:id{\d+}", name="showById", methods=["GET"])
     * @Route(path="/:id{\d+}-:slug", name="show", methods=["GET"])
     * @param int $id
     * @param string $slug
     * @return  string
     * @throws Exception
     */
    public function show($id=0,$slug=''): string
    {
        $project = (object)['id'=>$id,'slug'=>$slug];
        return $this->render('show.php', ['includeFile' => 'index.php', 'project' => $project]);
    }


    /**
     * MyProjectsController edit path="/edit/:id{\d+}-:slug"
     * @Route(path="/edit/:id{\d+}", name="editById", methods=["GET","POST"])
     * @Route(path="/edit/:id{\d+}-:slug", name="edit", methods=["GET","POST"])
     * @param int $id
     * @param string $slug
     * @return  string
     * @throws Exception
     */
    public function edit($id=0,$slug=''): string
    {
        $project = (object)['id'=>$id,'slug'=>$slug];
        return $this->render('edit.php', ['includeFile' => 'index.php', 'project' => $project]);
    }
}