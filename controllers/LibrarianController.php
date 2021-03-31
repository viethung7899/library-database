<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Book;
use app\models\Category;
use app\models\Reservation;
use app\utils\Dumpster;

class LibrarianController extends BaseController {
  // Control /library
  public static function home() {
    // Not authenticated -> return to the search page
    if (!self::isAuthenticated(self::LIBRARIAN)) {
      Response::redirect('/library/login');
      return;
    }
    $view = self::generateView('library/index', 'Home');
    $view->render();
  }

  // Control /library/login
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

  // Control /library/book/add
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

  // Control /library/reservation
  public static function reservation() {
    $view = self::generateView('library/reservation', 'Reservations');
    $body = Request::body();
    $response = new Response();
    if (!empty($body)) {
      $reservation = new Reservation(true);
      $response->content['reservation'] = $reservation;
      $response->content['reservations'] = Reservation::getAllRervations($reservation);
    }
    self::loadResponseToView($view, $response);
    $view->render();
  }

  // Control /library/book/delete
  public static function deleteBook() {
    $isbn = Request::body()['isbn'];
    Book::deleteBook($isbn);
    Response::redirect('/search');
  }

  // Control /library/reservation/confirm
  public static function confirmReservation() {
    Dumpster::dumpAll(Request::body());
  }

  // Control /library/borrow/add
  public static function confirmBorrow() {

  }

  // Control /library/borrow
  public static function borrow() {

  }

  // Control /library/book?isbn=
  public static function book() {
    $view = self::generateView('library/book', 'Book Details');
    $response = self::bookDetail();
    self::loadResponseToView($view, $response);
    $view->render();
  }

  // Control /library/payment
  public static function payment() {
    
  }
}
