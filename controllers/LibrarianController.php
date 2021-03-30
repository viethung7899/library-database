<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\utils\Dumpster;

class LibrarianController extends BaseController {
  public static function home() {
    // Not authenticated -> return to the search page
    if (!self::isAuthenticated(self::LIBRARIAN)) {
      Response::redirect('/library/login');
      return;
    }
    $view = self::generateView('library/index', 'Home', 'withNavigation');
    $view->render();
  }

  // Overide the login function
  public static function login() {
    // Call login function
    $view = self::generateView('employeeLogin', 'Employee portal', 'withNavigation');

    // Check credientials
    if (Request::isPost()) {
      $response = parent::login();
      Dumpster::dumpAll($response);
      $level = $response->content['level'] ?? 0;
      
      if ($level == 1 && $response->ok()) {
        // If successful, redirect to the librarians page
        self::setSession($response);
        Response::redirect('/library');
        return;
      } else if ($level == 2 && $response->ok()) {
        // If successful, redirect to the admin page
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
