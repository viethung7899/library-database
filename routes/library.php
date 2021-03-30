<?php

use app\controllers\LibrarianController;
use app\core\Router;

$librarianRoute = new Router('/library');

// To the home page
$librarianRoute->get('', [LibrarianController::class, 'home']);

// To the login page
$librarianRoute->get('/login', [LibrarianController::class, 'login']);
$librarianRoute->post('/login', [LibrarianController::class, 'login']);
