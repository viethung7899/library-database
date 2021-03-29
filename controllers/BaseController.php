<?php

namespace app\controllers;
use app\core\Controller;
use app\models\User;
use app\core\Request;
use app\core\Response;
use app\models\Book;

// This controller is interacting with the User model
class BaseController extends Controller {
  // Render the home page, can access without login
  public static function home() {
    $view = self::generateView('index', 'Home', 'withNavigation');
    $view->render();
  }

  public static function notFound() {
    $view = self::generateView('notFound', 'Home', 'withNavigation');
    $view->render();
  }

  protected static function login() {
    // Resolve post login
    $body = Request::body();

    if (Request::isPost()) {
      $response = User::login($body);
    }

    return $response;
  }

  // Can access without login
  public static function searchBook() {
    // Resolve book search
    $body = Request::body();
    if (isset($body)) {
      $response = Book::searchBooksByName($body);
    // If successful, print the result
      if ($response->ok()) {
        
      }
    // Else, show the error on the form
      else {
        
      }
    }
  }

  // Get books details
  public static function book() {

  }

  // Any user can view thier settings (should it be abstract?)
  public static function setting() {

  }

  public static function updatePassword() {
    // Validate old password

    // Change into new password
  } 
}