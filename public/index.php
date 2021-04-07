<?php

use Config\DevCoder\DotEnv;

include_once __DIR__ . '/../config/DotEnv.php';

(new DotEnv(__DIR__ . '/../.env'))->load();


include_once __DIR__ . '/../src/views/layout.php';

