<?php
$project = isset($data['project'])?$data['project']:null;
$message = isset($data['message'])?$data['message']:null;
?>


<h2><?= isset($project->name)?preg_replace('/[-_]/',' ',$project->name):'See Project'?></h2>
<?php if (isset($message->type) && isset($message->content)): ?>
    <div class="<?php echo $message->type; ?>"> <?php echo $message->content; ?></div>
<?php endif;
if (isset($project)):?>
    <br />
    <a href="/myProjects/<?= $project->id.(!empty($project->name)?"-$project->name":'') ?>" class="btn">
        reload this page
    </a>

    <div>
        <a href="/myProjects" class="btn" style="font-size=.5rem !important;padding: .2rem 2rem;">All</a>
        <a href='/myProjects/<?= $project->id.(empty($project->name)?'':"-$project->name") ?>'
           class="btn" style="font-size=10px !important;padding: .2rem 2rem;">Details</a>
    </div>
    <h3> Edit</h3>
<?php endif; ?>
<div class="warning">Data will not be changed on the gitHub site</div>
<form method="post">
    <label>Project name</label>
    <input type="text" name="name" value="<?php echo !empty($project->name) ? $project->name:''; ?>">
    <button type="submit">Envoyer</button>
</form>

