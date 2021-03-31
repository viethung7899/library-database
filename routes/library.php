<?php

use app\controllers\LibrarianController;
use app\core\Router;

$librarianRoute = new Router('/library');

// To the home page
$librarianRoute->get('', [LibrarianController::class, 'home']);

// To the login page
$librarianRoute->get('/login', [LibrarianController::class, 'login']);
$librarianRoute->post('/login', [LibrarianController::class, 'login']);

// Book
$librarianRoute->get('/book', [LibrarianController::class, 'book']);
$librarianRoute->get('/book/add', [LibrarianController::class, 'addBook']);
$librarianRoute->post('/book/add', [LibrarianController::class, 'addBook']);
$librarianRoute->post('/book/delete', [LibrarianController::class, 'deleteBook']);

// Reservation
$librarianRoute->get('/reservation', [LibrarianController::class, 'reservation']);
$librarianRoute->get('/reservation/view', [LibrarianController::class, 'viewReservation']);
$librarianRoute->post('/reservation/confirm', [LibrarianController::class, 'confirmReservation']);
$librarianRoute->get('/reservation/delete', [LibrarianController::class, 'deleteReservation']);


$librarianRoute->get('/borrow', [LibrarianController::class, 'borrow']);
$librarianRoute->get('/borrow/add', [LibrarianController::class, 'addBorrow']);
$librarianRoute->post('/borrow/add', [LibrarianController::class, 'addBorrow']);
$librarianRoute->get('/borrow/return', [LibrarianController::class, 'returnBook']);

