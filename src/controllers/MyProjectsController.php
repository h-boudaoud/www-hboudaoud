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
//        $projects =[];
//        for ($i = 1; $i <= 10; $i++){
//            $project = (object)['id'=>$i,'slug'=>'slug-num-'.$i];
//            $projects[$i]=$project;
//        }
        $projects = $this->getProjects('https://api.github.com/users/h-boudaoud/repos');
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
    public function show($id = 0, $slug = ''): string
    {
//        $project = (object)['id'=>$id,'slug'=>$slug];

        $message = (object)[];
        $project = $this->getProjects("https://api.github.com/repos/h-boudaoud/$slug");
        $projectId = isset($project->id) ? $project->id : 0;
        if (empty($project) || $projectId != $id) {
            $project = null;
            $message->type = 'error';
            $message->content = "Error : no project with id=$id "
                . (!empty($slug) ? "and name=$slug" : "")
                . " in https://github.com/h-boudaoud?tab=repositories";
        }
        return $this->render(
            'show.php',
            [
                'includeFile' => 'index.php',
                'project' => $project,
                'message' => $message
            ]
        );
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
    public function edit($id = 0, $slug = ''): string
    {
        $message = (object)[];
        $project = ($id . $slug == 0) ? null : $this->getProjects("https://api.github.com/repos/h-boudaoud/$slug");
        $projectId = isset($project->id) ? $project->id : (isset($project['id']) ? $project['id'] : 0);

        if (empty($project) || $projectId != $id) {
            $message->type = 'error';
            $message->content = "Error : no project with id=$id "
                . (!empty($slug) ? "and name=$slug" : "")
                . " in https://github.com/h-boudaoud?tab=repositories";
        }
        if (isset($_POST) && !empty($_POST['name'])) {
            $name = htmlspecialchars($_POST['name'], ENT_QUOTES);
            $newProject = (object)['id' => $projectId, 'name' => $name, 'description' => '', 'languages_url' => ''];
            if (!empty($project)) {
                $newProject->description = $project->description;
                $newProject->languages_url = $project->languages_url;
                $message->type = 'success';
                $message->content = 'Success : new project name is :' . $newProject->name;
                return $this->render(
                    'show.php',
                    [
                        'includeFile' => 'index.php',
                        'project' => $newProject,
                        'message' => $message
                    ]
                );
            }
            $project = $newProject;
            $message->type = 'error';
            $message->content = "Error : no project with id=$id " . (!empty($slug) ? "and name=$slug" : "") . " in https://github.com/h-boudaoud?tab=repositories";
        }


        return $this->render(
            'edit.php',
            [
                'includeFile' => 'index.php',
                'project' => $project,
                'message' => $message
            ]
        );
    }

    private function getProjects(string $url)
    {
        $file = $_SERVER['DOCUMENT_ROOT'] . 'public/data/gitHubRepositories.json';
        //Last update < 1day
        if (
            file_exists($file) &&
            filemtime($file) <= 86400
        ) {
            $result = $this->contentsFileToProjects($file, $url);
            if ($result) {
                return $result;
            }
        }

        //Last update > 1day or $file not exist
        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => [
                    'User-Agent: PHP'

                ]
            ]
        ];
        $context = stream_context_create($opts);
        $content = @file_get_contents(
            "$url?access_token=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",
            false,
            $context
        );
        //$content = @file_get_contents($url);
        if ($content && $url == 'https://api.github.com/users/h-boudaoud/repos') {
            // delete file
            if (
            file_exists($file)
            ) {
                unlink($file);
            }
            // save data to file
            $pathInfo = pathinfo($file);
            if (!is_dir($pathInfo['dirname'])) {
                mkdir($pathInfo['dirname'], 777, true);
            }
            $f = fopen($file, 'w');
            fwrite($f, $content);
            fclose($f);
            return json_decode($content);
        }

        //if github api not working

        return $this->contentsFileToProjects($file, $url);
    }

    private function contentsFileToProjects($file, $url)
    {
        $content = @file_get_contents($file);
        if ($url == 'https://api.github.com/users/h-boudaoud/repos') {
            return json_decode($content);
        }
        if ($content && preg_match('/^https:\/\/api.github.com\/repos\/h-boudaoud\//', $url)) {
            // First method
            foreach (json_decode($content) as $project) {
                if ($project->url == $url) {
                    return $project;
                }
            }
            //Second method
//            $filterByUrl = function ($project) use ($url) {
//                return $project['url'] == $url;
//            };
//            $project = array_filter($projects, $filterByUrl);
//            return isset($project[0]) ? $project[0] : null;
        }
        return null;
    }
}