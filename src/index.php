<?php

// this service is internal - access is allowed only from one server
if ($_SERVER['SERVER_ADDR'] != $_SERVER['REMOTE_ADDR']) {
    die;
}

require 'vendor/autoload.php';
require 'Model.php';

$app = new \Slim\Slim();

require_once __DIR__ . '/requests/add.php';
require_once __DIR__ . '/requests/get-info.php';
require_once __DIR__ . '/requests/me.php';

$app->run();
