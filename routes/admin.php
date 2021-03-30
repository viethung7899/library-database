<?php

use app\controllers\AdminController;
use app\core\Router;

$adminRoute = new Router('/admin');

// Admin home
$adminRoute->get('', [AdminController::class, 'home']);
$adminRoute->get('/add', [AdminController::class, 'addEmployee']);

$adminRoute->get('/search', [AdminController::class, 'searchEmployee']);