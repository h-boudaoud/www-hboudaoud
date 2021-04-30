<?php


namespace Hboudaoud\Controller;


use Exception;
use RuntimeException;

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
        return $this->render(
            'index.php',
            [
                'includeFile' => 'index.php'
                , 'projects' => $projects
            ]
        );
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

        if(empty($slug)){
            $this->httpResponseCode(404);
            throw new Exception("Error 404: <br />The project name is not defined");
        }

        $project = $this->getProjects("https://api.github.com/repos/h-boudaoud/$slug");
        $projectId = (!empty($project->id) && $project->id==$id) ? $project->id : null;
        if (empty($projectId)) {
            $this->httpResponseCode(404);
            var_dump("Error 404:<br />No project with id=$id "
                . (!empty($slug) ? "and name=$slug" : "")
                . " in https://github.com/h-boudaoud?tab=repositories");
            throw new Exception("Error : no project with id=$id "
                . (!empty($slug) ? "and name=$slug" : "")
                . " in https://github.com/h-boudaoud?tab=repositories");
        }
        return $this->render(
            'show.php',
            [
                'includeFile' => 'index.php',
                'project' => $project
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
        //In order to avoid systematic downloading of data from the GitHub API,
        // using a JSON file to save the recovered data is strongly recommended.
        //

        $file = $_SERVER['DOCUMENT_ROOT'] . 'public/data/gitHubRepositories.json';
        $content = '';

        //Last update < 1day
        if (
            file_exists($file) &&
            time() - filemtime($file) <= 86400
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

                ],
                "content" => $content,
                "ignore_errors" => true,
            ]
        ];
        $context = stream_context_create($opts);
        $response = @file_get_contents(
            "$url",
            false,
            $context
        );

        $status_line = $http_response_header[0];

        preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);

        $status = $match[1];
        $response = preg_replace('/ \(But (.*)/', '"}', $response);
        if ($status !== "200") {
            $this->httpResponseCode($status);
            throw new RuntimeException("Error $status<br>Unexpected response status: {$status_line}<br />" . $response);
        }

        //$content = @file_get_contents($url);
        if ($response && $url == 'https://api.github.com/users/h-boudaoud/repos') {
            // delete file
            if (
            file_exists($file)
            ) {
                unlink($file);
            }

            $data = json_decode($response);
            foreach ($data as $item) {

                $readMe_url = "https://raw.githubusercontent.com/h-boudaoud/{$item->name}/master/readme.md";
                $item->readMe = "URL : $readMe_url";

                $content = @file_get_contents(
                    $readMe_url,
                    false,
                    $context
                );
                if($content){
                    $item->readMe = $content;
                }

                $content = @file_get_contents(
                    $item->languages_url,
                    false,
                    $context
                );
                $item->languages = array_keys(get_object_vars(json_decode($content)));
            }
            $content = json_encode($data);
            // save data to file
            $pathInfo = pathinfo($file);
            if (!is_dir($pathInfo['dirname'])) {
                mkdir($pathInfo['dirname'], 777, true);
            }
            $f = fopen($file, 'w');
            fwrite($f, $content);
            fclose($f);
            return $data;
        }

        //if url!= 'https://api.github.com/users/h-boudaoud/repos'

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