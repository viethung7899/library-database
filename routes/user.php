<?php

use app\controllers\MemberController;
use app\core\Router;

$authRoute = new Router('');

$authRoute->get('/register', [MemberController::class, 'register']);
$authRoute->post('/register', [MemberController::class, 'register']);