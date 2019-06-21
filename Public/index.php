<?php

namespace Web;

use App\Src\Autoloader;

require_once __DIR__ . '/../App/Src/AutoLoader.php';
Autoloader::register();

$app = require_once __DIR__ . '/../App/bootstrap.php';
$app->run();
