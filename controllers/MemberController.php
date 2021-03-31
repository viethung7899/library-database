<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\BorrowRecord;
use app\models\Member;
use app\models\Reservation;
use app\utils\Dumpster;

class MemberController extends BaseController {
  // Control /
  public static function home() {
    // Set up redirection
    $redirect = parent::home();
    if ($redirect) return;

    // Not authenticated -> return to the search page
    if (!self::isAuthenticated()) {
      Response::redirect('/search');
      return;
    }
    $view = self::generateView('index', 'Home');
    $view->render();
  }

  // Overide the login function
  public static function login() {
    $view = self::generateView('login', 'Log in');
    // Call login function from
    if (Request::isPost()) {
      $response = parent::login();

      // If successful, redirect to the home
      if ($response->ok()) {
        // Set session here
        self::setSession($response);
        Response::redirect('/');
        return;
      }

      self::loadResponseToView($view, $response);
    }


    // Render the login page (with errors if possible)
    $view->render();
  }

  // Control /register
  public static function register() {
    // Resolve the register POST reequest
    $view = self::generateView('register', 'Register');

    if (Request::isPost()) {
      // If sucessful, redirect to home page
      $member = new Member();
      $response = $member->register();
      if ($response->ok()) {
        self::setSession($response);
        Response::redirect('/');
        return;
      }

      self::loadResponseToView($view, $response);
    }

    // Render the register page
    $view->render();
  }

  // Control /borrow
  // Search around all books borrow by a user
  public static function borrow() {
    $view = self::generateView('member/borrow', 'Borrowed books');
    $id = self::getSession()->get('id');
    $response = new Response();
    $record = new BorrowRecord(true);
    $record->user_id = $id;
    $response->content['records'] = BorrowRecord::getBorrowRecords($record);
    self::loadResponseToView($view, $response);
    $view->render();
  }

  // Control /reservation
  // Search around all books reserved by a user
  public static function reservation() {
    $view = self::generateView('member/reservation', 'Borrowed books');
    $id = self::getSession()->get('id');
    $response = new Response();
    $reservation = new Reservation(true);
    $reservation->user_id = $id;
    $response->content['reservations'] = Reservation::getAllReservations($reservation);
    self::loadResponseToView($view, $response);
    $view->render();
    $view->render();
  }

  // Control /reservation/confirm
  public static function makeReservation() {
    $body = Request::body();
    $id = $body['user_id'];
    $isbn = $body['ibsn'];

    // Add current date to 2 days
    $pickupDate = date('Y-m-d', strtotime(date('Y-m-d') . ' +2 days'));

    Reservation::addReservation($id, $isbn, $pickupDate);
    Response::redirect("/book?isbn=$isbn");
  }

  // Control /book?isbn=
  // Getting the books details and show reservation buttons
  public static function book() {
    $view = self::generateView('member/book', 'Book Details');
    $response = self::bookDetail();
    self::loadResponseToView($view, $response);
    $view->render();
  }

  // Control /pay
  // Show the rermaining fine and make a payment
  public static function pay() {
  }
}
