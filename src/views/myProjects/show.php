<?php
$project = isset($data['project'])?$data['project']:null;
$message = isset($data['message'])?$data['message']:null;
?>


    <h2><?= isset($project->name) ? preg_replace('/[-_]/', ' ', $project->name) : 'See Project' ?></h2>
<?php if (isset($message->type) && isset($message->content)): ?>
    <div class="<?php echo $message->type; ?>"> <?php echo $message->content; ?></div>
<?php endif;
if(isset($project)):?>
    <div style="margin-bottom: 2rem;">
        <a href="/myProjects" class="btn" style="font-size=.5rem !important;padding: .2rem 2rem;">All</a>
        <a href='/myProjects/edit/<?= $project->id.(empty($project->name)?'':"-$project->name") ?>'
           class="btn" style="font-size=10px !important;padding: .2rem 2rem;">Edit</a>
    </div>

    <div id="languages" class="primary js_project_languages"><?= isset($project->languages_url)?$project->languages_url:'' ?></div>
    <div id="description" class="primary">
        Description :
        <?= isset($project->description)?$project->description:'';?>
    </div>

    <div>MyProjectsController -- action show id: <?= $project->id?>
        <?php echo empty($project->name)?'':" -- slug : $project->name"; ?>

    </div>
<?php endif;?>