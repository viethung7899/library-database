<?php

use app\controllers\BaseController;
use app\controllers\MemberController;
use app\core\Router;

$memberRoute = new Router('');

$memberRoute->get('/register', [MemberController::class, 'register']);
$memberRoute->post('/register', [MemberController::class, 'register']);

$memberRoute->get('/login', [MemberController::class, 'login']);
$memberRoute->post('/login', [MemberController::class, 'login']);

$memberRoute->get('/logout', [BaseController::class, 'logout']);

$memberRoute->get('/borrow', [MemberController::class, 'borrow']);
$memberRoute->get('/reservation', [MemberController::class, 'reservation']);

$memberRoute->post('/reservation/confirm', [MemberController::class, 'makeReservation']);
$memberRoute->post('/reservation/cancel', [MemberController::class, 'cancelReservation']);


$memberRoute->get('/book', [MemberController::class, 'book']);