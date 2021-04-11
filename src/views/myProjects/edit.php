<?php
$project = isset($data['project'])?$data['project']:null;
$message = "<h2>edit project</h2>" ;
var_dump($project);
if(isset($project)) {
    $message =
        "<div>MyProjectsController -- action edit id: $project->id" .
        (empty($project->slug) ? '' : " -- slug : $project->slug") .
        "</div>";
    if (empty($_POST)) {
        $message .=
            '<form method="post">' .
            ' <label>Project name</label>' .
            '    <input type="text" name="name">' .
            '    <button type="submit">Envoyer</button>' .
            '</form>';
    } else {
        $message .= "<pre>" . print_r($_POST, true) . "</pre>";
    }
}else {
    $message .="<div class='warning'> Eny project in this app</div>";
}
echo $message;