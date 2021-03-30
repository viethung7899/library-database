<?php

use app\controllers\AdminController;
use app\core\Router;

$adminRoute = new Router('/admin');

// Admin home
$adminRoute->get('', [AdminController::class, 'home']);