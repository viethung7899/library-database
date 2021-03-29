<?php

namespace app\controllers;
use app\core\Controller;
use app\models\User;
use app\core\Request;
use app\core\Response;

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
      if ($response->ok()) {
        Response::redirect('/');
      }
    }
  }

  // Can access without login
  public static function searchBook() {
    // Resolve book search

    // If successful, print the result

    // Else, show the error on the form
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