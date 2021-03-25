<?php

require_once '../vendor/autoload.php';

use app\controllers\BaseController;
use app\controllers\MemberController;
use app\core\Application;
use app\utils\Dumpster;

// Configure the database
$rootDir = dirname(__DIR__);
$dot_env = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dot_env->load();
$config = [
  'dsn' => 'mysql:host='.$_ENV['DB_HOST'].';port='.$_ENV['DB_PORT'].';dbname='.$_ENV['DB_NAME'],
  'username' => $_ENV['DB_USERNAME'],
  'password' => $_ENV['DB_PASSWORD'],
];

// Make the app instance and connect the app to the database
$app = new Application($rootDir);
$app->connectDatabase($config);

// Include the route for /
include_once '../routes/user.php';

// Configure the router
$app->get('/', [BaseController::class, 'home']);

$app->run();