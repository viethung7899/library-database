<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Book;
use app\models\BookAuthor;
use app\models\BorrowRecord;
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
          $response->addError('username', 'Access denied');
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
      $response->content['reservations'] = Reservation::getAllReservations($reservation);
    }
    self::loadResponseToView($view, $response);
    $view->render();
  }

  // Control /library/reservation/view?user_id=&
  public static function viewReservation() {
    $view = self::generateView('library/reservationView', 'Reservation Detail');

    // Verification
    $body = Request::body();
    $id = $body['user_id'] ?? '';
    $isbn = $body['isbn'] ?? '';
    if (empty($id) || empty($isbn)) self::notFound();

    // Find one reservation
    $reservations = Reservation::getOneReservation($id, $isbn);
    if (empty($reservations)) self::notFound();

    // Generate response
    $response = new Response();
    $response->content['reservation'] = $reservations[0];

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
    $body = Request::body();
    $id = $body['user_id'];
    $isbn = $body['isbn'];

    // Add 3 days to return dates
    $returnDate = date('Y-m-d', strtotime(date('Y-m-d') . ' + 3 days'));

    // Remove reservation
    Reservation::deleteReservation($id, $isbn);

    // Add borrow record
    BorrowRecord::addBorrowRecord($id, $isbn, $returnDate);

    Response::redirect('/library/reservation');
  }

  // Control /library/reservation/delete
  public static function deleteReservation() {
    $body = Request::body();
    Reservation::deleteReservation($body['user_id'], $body['isbn']);
    Response::redirect('/search?title=');
  }

  // Control /library/borrow/add
  public static function addBorrow() {
    $view = self::generateView('library/addBorrow', 'Borrow records');
    $response = new Response();
    if (Request::isPost()) {
      $record = new BorrowRecord(true);
      $response = $record->add();
      if ($response->ok()) {
        Response::redirect('/library/borrow?isbn=&title=&user_id=&name=&before=&after=');
      }
      $response->content['record'] = $record;
    }
    self::loadResponseToView($view, $response);
    $view->render();
  }

  // Control /library/borrow
  public static function borrow() {
    $view = self::generateView('library/borrow', 'Borrow records');
    $body = Request::body();
    $response = new Response();
    if (!empty($body)) {
      $record = new BorrowRecord(true);
      $response->content['record'] = $record;
      $response->content['records'] = BorrowRecord::getBorrowRecords($record);
    }
    self::loadResponseToView($view, $response);
    $view->render();
  }

  // Control /library/book?isbn=
  public static function book() {
    $view = self::generateView('library/book', 'Book Details');
    $response = self::bookDetail();
    self::loadResponseToView($view, $response);
    $view->render();
  }

  // Control /library/return
  public static function returnBook() {
    $body = Request::body();
    $id = $body['id'];
    BorrowRecord::deleteBorrowRecord($id);
    Response::redirect('/library/borrow?isbn=&title=&user_id=&name=&before=&after=');
  }

  // Control /library/deleteAll
  public static function deleteAllBooks() {
    $view = self::generateView('/library/deleteAll', 'Delete all books');
    $response = new Response();
    $body = Request::body();
    if (!empty($body)) {
      BookAuthor::deleteAllBooks($body);
      $response->content['success'] = true;
      self::loadResponseToView($view, $response);
    }
    $view->render();
  }
}
