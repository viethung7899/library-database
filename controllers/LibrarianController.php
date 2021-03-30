<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;

class LibrarianController extends BaseController {
  public static function home() {
    $view = self::generateView('library/index', 'Home', 'withNavigation');
    $view->render();
  }

  // Overide the login function
  public static function login() {
    // Call login function
    $view = self::generateView('employeeLogin', 'Employee portal', 'withNavigation');
    $body = Request::body();

    // Check credientials
    if (Request::isPost()) {
      $response = parent::login();
      $level = $response->content['level'] ?? 0;
      if ($level == 1 && $response->ok()) {
        self::setSession($response);
        Response::redirect('/library');
        return;
      } else if ($level == 2 && $response->ok()) {
        self::setSession($response);
        Response::redirect('/admin');
        return;
      } else {
        $response->addError('username', 'You do not have access');
      }

      $params = [
        'errors' => $response->errors
      ];
      $view->loadParameters($params);
    }

    // If successful, redirect to the librarians page

    // Render the login page (with errors if possible)
    $view->render();
  }

  public static function addBook() {
  }

  public static function editBook() {
  }

  public static function deleteBook() {
  }

  public static function confirmReservation() {
  }

  public static function confirmBorrow() {
  }
}
