<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\User;
use app\utils\Dumpster;

class MemberController extends BaseController {
  // Make the rules of the 

  // Overide the login function
  public static function login() {
    $view = self::generateView('login', 'Log in');
    // Call login function from ab

    // If successful, redirect to the home

    // Render the login page (with errors if possible)
    $view->render();
  }

  public static function register() {
    // Resolve the register POST reequest
    $body = Request::body();
    $view = self::generateView('register', 'Register');
    
    if (Request::isPost()) {
      // If sucessful, redirect to home page
      $response = User::register($body);
      if ($response->ok()) {
        Response::redirect('/');
      }
      $params = [
        'body' => $response->content,
        'errors' => $response->errors
      ];
      $view->loadParameters($params);
    }

    // Render the register page
    $view->render();
  }
}