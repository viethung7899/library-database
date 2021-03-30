<?php

use app\controllers\LibrarianController;
use app\core\Router;

$librarianRoute = new Router('/library');

$librarianRoute->get('', [LibrarianController::class, 'home']);
