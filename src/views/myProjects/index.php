<?php
$projects=isset($data['projects'])?$data['projects']:[];
?>

<h2>See <?= Count($projects) ?> projects</h2>
<?php if(!Count($projects)):?>
    <div class='warning'> Eny project in this app</div>
<?php endif;?>
<?php foreach ($projects as $project) :?>
<div class="primary">
   slug : <?= $project->slug ?>
    <br /> id :<?= $project->id ?>
    <br /> <a href="/myProjects/<?= $project->id.($project->slug?'-'.$project->slug:'') ?>">
        Details</a>
</div>
<?php endforeach;?>

