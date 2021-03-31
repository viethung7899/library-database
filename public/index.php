<?php

// The root directory should be `libray-databse`
$rootDir = dirname(__DIR__);

require_once "$rootDir/vendor/autoload.php";

use app\controllers\BaseController;
use app\controllers\MemberController;
use app\core\Application;

// Configure the database and hide the crendential

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

// Include all the routers for the app
include_once "$rootDir/routes/user.php";
include_once "$rootDir/routes/library.php";
include_once "$rootDir/routes/admin.php";

// Adding more route to the app
$app->get('/', [MemberController::class, 'home']);
$app->get('/search', [BaseController::class, 'searchBook']);
$app->get('/favorite', [BaseController::class, 'favorite']);

$app->run();