<?php
$projects = isset($data['projects']) ? $data['projects'] : [];
?>
<header class="radial-gradient">
    <div>
        <h2>My <?= Count($projects) ?> projects</h2>
    </div>
</header>
<?php if (!Count($projects)): ?>
    <div class='warning'> Eny project in this app</div>
<?php endif; ?>
<?php foreach ($projects as $project) : ?>
    <div id="<?= $project->id ?>" class="primary">
        Name :<?= preg_replace('/[-_]/', ' ', $project->name) ?>
        <br/>Clone url: <a href="<?= $project->clone_url ?>" target="_blank"><?= $project->clone_url ?></a>
        <div id="<?= $project->name ?>" class="js_project_languages"><?= $project->languages_url ?></div>
        <div>Last update: <?php $date = strtotime($project->updated_at);
            echo date("Y-m-d", $date) . ' at ' . date("H:i", $date) ?></div>
        <div>
            <a href="/myProjects/<?= $project->id . (empty($project->name) ? '' : "-$project->name") ?>"
               class="btn" style="font-size=.5rem !important;padding: .2rem 2rem;">Details</a>
            <a href='/myProjects/edit/<?= $project->id . (empty($project->name) ? '' : "-$project->name") ?>'
               class="btn" style="font-size=10px !important;padding: .2rem 2rem;">Edit</a>
        </div>
    </div>
<?php endforeach; ?>

