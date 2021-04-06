<?php

use Config\DevCoder\DotEnv;

include_once __DIR__.'/src/config/DotEnv.php';

(new DotEnv(__DIR__ . '/.env'))->load();

echo "Error line $error";

echo "<br />Environment mode :{$_SERVER['APP_ENV']}";
