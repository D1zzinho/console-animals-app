#!/usr/bin/php -d memory_limit=2048M -d post_max_size=0
<?php

if (PHP_SAPI !== 'cli') {
    exit;
}

require __DIR__ . '/vendor/autoload.php';
define("CONFIG", require __DIR__ . '/config/commands.php');

use App\Application;

$app = Application::getInstance();
$app->bootstrap($argc, $argv);
