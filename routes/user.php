<?php

use app\controllers\BaseController;
use app\controllers\MemberController;
use app\core\Router;

$authRoute = new Router('');

$authRoute->get('/register', [MemberController::class, 'register']);
$authRoute->post('/register', [MemberController::class, 'register']);

$authRoute->get('/login', [MemberController::class, 'login']);
$authRoute->post('/login', [MemberController::class, 'login']);

$authRoute->get('/logout', [BaseController::class, 'logout']);