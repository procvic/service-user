<?php

require 'vendor/autoload.php';
require 'Model.php';

$app = new \Slim\Slim();

require_once __DIR__ . '/requests/add.php';
require_once __DIR__ . '/requests/get-info.php';
require_once __DIR__ . '/requests/me.php';

$app->run();
