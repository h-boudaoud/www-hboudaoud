<?php
$project = isset($data['project'])?$data['project']:null
?>


<h2>See project</h2>
<?php if(isset($project)):?>
<div>MyProjectsController -- action show id: <?= $project->id?>
<?php echo empty($project->slug)?'':" -- slug : $project->slug"; ?>
<br /><a href='/myProjects/edit/<?= $project->id.(empty($project->slug)?'':"-$project->slug") ?>'>
Edit</a>
</div>
<?php else:?>
<div class="warning"> Eny project in this app</div>
<?php endif;?>