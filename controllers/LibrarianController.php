<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Book;
use app\models\Category;
use app\models\Reservation;
use app\utils\Dumpster;

class LibrarianController extends BaseController {
  public static function home() {
    // Not authenticated -> return to the search page
    if (!self::isAuthenticated(self::LIBRARIAN)) {
      Response::redirect('/library/login');
      return;
    }
    $view = self::generateView('library/index', 'Home');
    $view->render();
  }

  // Overide the login function
  public static function login() {
    // Call login function
    $view = self::generateView('employeeLogin', 'Employee portal');

    // Check credientials and redirect to suitable route
    if (Request::isPost()) {
      $response = parent::login();

      if ($response->ok()) {
        $level = $response->content['user']->access_level;
        if ($level > 0) {
          if ($level == self::LIBRARIAN) {
            self::setSession($response, self::LIBRARIAN);
            Response::redirect('/library');
          } else {
            self::setSession($response, self::ADMIN);
            Response::redirect('/admin');
          }
          return;
        } else {
          $response->addError('username', 'You cannot access to the portal');
        }
      }
      self::loadResponseToView($view, $response);
    }
    // Render the login page (with errors if possible)
    $view->render();
  }

  // Add books
  public static function addBook() {
    $view = self::generateView('library/addBook', 'Add book');
    $response = new Response();
    if (Request::isPost()) {
      $book = new Book(true);
      $response = $book->add();
      $response->content['book'] = $book;
    }
    $response->content['categories'] = Category::getAllCategory();
    self::loadResponseToView($view, $response);
    $view->render();
  }

  public static function reservation() {
    $view = self::generateView('library/reservation', 'Reservations');
    $body = Request::body();
    $response = new Response();
    if (!empty($body)) {
      $reservation = new Reservation(true);
      $response->content['reservation'] = $reservation;
      $response->content['reservations'] = Reservation::getAllRervations($reservation);
      Dumpster::dump($response->content['reservations']);
    }
    self::loadResponseToView($view, $response);
    $view->render();
  }

  // Delete books
  public static function deleteBook() {

  }

  public static function confirmReservation() {

  }

  public static function confirmBorrow() {

  }
}
