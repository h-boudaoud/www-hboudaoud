<?php
$project = isset($data['project']) ? $data['project'] : null;
$message = isset($data['message']) ? $data['message'] : null;
?>


    <h2><?= isset($project->name) ? preg_replace('/[-_]/', ' ', $project->name) : 'See Project' ?></h2>
<?php if (isset($message->type) && isset($message->content)): ?>
    <div class="<?php echo $message->type; ?>"> <?php echo $message->content; ?></div>
<?php endif;
if (isset($project)):?>
    <div style="margin-bottom: 2rem;">
        <a href="/myProjects" class="btn" style="font-size=.5rem !important;padding: .2rem 2rem;">All</a>
        <a href='/myProjects/edit/<?= $project->id . (empty($project->name) ? '' : "-$project->name") ?>'
           class="btn" style="font-size=10px !important;padding: .2rem 2rem;">Edit</a>
    </div>

    <div class="project">
        <h2>
            <?= preg_replace('/[-_]/', ' ', $project->name) ?>
        </h2>
        <br/>
        <span>Clone url </span>:
        <div class="d-inline">
            <a href="<?= $project->clone_url ?>"
               target="_blank"><?= $project->clone_url ?>
            </a>
        </div>
        <br/>
        <span>Languges </span>:
        <div class="d-inline">
            <?= !empty($project->languages) ? join(', ', $project->languages) : '' ?>
        </div>
        <br />
        <span>Readme.md file</span>
        <div id="readme">
            <project name="<?= $project->name ?>" value="This tag is not displayed in the DOM, but can be used in Javascript" />
            <pre>
            <?= !empty($project->readMe) ? nl2br($project->readMe) : ''; ?>
            </pre>
        </div>
    </div>
    <br/>
    <span>Last update </span>:
    <div class="d-inline ">
        <?php $date = strtotime($project->updated_at);
        echo date("Y-m-d", $date) . ' at ' . date("H:i", $date) ?>
    </div>

    </div>

    <div>MyProjectsController -- action show id: <?= $project->id ?>
        <?php echo empty($project->name) ? '' : " -- slug : $project->name"; ?>
    </div>
<?php endif; ?>