<?php
$projects = isset($data['projects']) ? $data['projects'] : [];
$message = isset($data['message']) ? $data['message'] : null;
?>
<header class="radial-gradient">
    <div>
        <h2>My <?= Count($projects) ?> projects</h2>
    </div>
</header>
<?php if (isset($message->type) && isset($message->content)): ?>
    <div class="<?php echo $message->type; ?>"> <?php echo $message->content; ?></div>
<?php elseif (!Count($projects)): ?>
    <div class='warning'> Eny project in this app</div>
<?php endif; ?>
<?php foreach ($projects as $project) :
    ?>
    <div id="<?= $project->id ?>" class="primary">
        <div class="project">
            <h2>
                <?= preg_replace('/[-_]/', ' ', $project->name) ?>
            </h2>
            <span>Languges </span>:
            <div class="d-inline">
                <?= isset($project->languages) ? join(', ', $project->languages) : '' ?>
            </div>
            <br/>
            <span>Description</span>
            <div id="description" class="primary" style="height:5rem;text-overflow: ellipsis;overflow: hidden;">
                <?= isset($project->description)
                    ? nl2br($project->description)
                    : (($project->readMe) ? nl2br($project->readMe) : '')
                ; ?>
            </div>
            <span>Clone url </span>:
            <div class="d-inline">
                <a href="<?= $project->clone_url ?>"
                   target="_blank"><?= $project->clone_url ?>
                </a>
            </div>
            <br/>
            <span>Last update </span>:
            <div class="d-inline">
                <?php $date = strtotime($project->updated_at);
                echo date("Y-m-d", $date) . ' at ' . date("H:i", $date) ?>
            </div>
        </div>
        <div>
            <a href="/myProjects/<?= $project->id . (empty($project->name) ? '' : "-$project->name") ?>"
               class="btn" style="font-size=.5rem !important;padding: .2rem 2rem;">Details</a>
            <a href='/myProjects/edit/<?= $project->id . (empty($project->name) ? '' : "-$project->name") ?>'
               class="btn" style="font-size=10px !important;padding: .2rem 2rem;">Edit</a>
        </div>
    </div>
<?php endforeach; ?>

