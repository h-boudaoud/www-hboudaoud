<?php

$includeFile = !empty($data["includeFile"])
    ? '/' . $data["includeFile"]
    : '/_infos.php';
?>

<header class="radial-gradient">
    <div>
        <h2>Welcome in my website</h2>
    </div>
</header>

<div class="radial-gradient">
    <div>
        <?php include (__DIR__ . $includeFile); ?>
    </div>

</div>

<div class="radial-gradient">
    <div>
        <h2>A few environment variables</h2>
        <div class="primary">

            <table>
                <tr>
                    <td>SERVER_SOFTWARE</td>
                    <td>:<?= $_SERVER['SERVER_SOFTWARE'] ?></td>
                </tr>
                <tr>
                    <td>Operating system</td>
                    <td>
                        : <?= preg_replace('/' . gethostname() . '/i', 'XXXXXX', php_uname()) ?>
                    </td>
                </tr>
                <tr>
                    <td>phpversion</td>
                    <td>: <?= phpversion() ?></td>
                </tr>
                <tr>
                    <td>SERVER_ADMIN</td>
                    <td>:<?= $_SERVER['SERVER_ADMIN']?></td>
                </tr>


                <tr>
                    <td>Environment</td>
                    <td>
                        : <?= $_SERVER["APP_ENV"] ?>
                    </td>
                </tr>
                <tr>
                    <td>REDIRECT_URL</td>
                    <td>
                        : <?= $_SERVER["REDIRECT_URL"] ?>
                    </td>
                </tr>
                <tr>
                    <td>REQUEST_URI</td>
                    <td>
                        : <?= $_SERVER["REQUEST_URI"] ?>
                    </td>
                </tr>
                <tr>
                    <td>QUERY_STRING</td>
                    <td>
                        : <?= $_SERVER["QUERY_STRING"] ?>
                    </td>
                </tr>
                <tr>
                    <td>PHP_SELF</td>
                    <td>:<?= $_SERVER['PHP_SELF'] ?></td>
                </tr>
                <?php if ($_SERVER['APP_ENV'] == 'dev'): ?>

                <tr>
                    <td>DOCUMENT_ROOT</td>
                    <td>
                        : <?= $_SERVER["DOCUMENT_ROOT"] ?>
                    </td>
                </tr>
                    <tr>
                        <td>getcwd</td>
                        <td>
                            : <?= getcwd() ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">$_SERVER</td>
                        <td>
                            : <pre><?= print_r($_SERVER,1) ?></pre>
                        </td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>

</div>