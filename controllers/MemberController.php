<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Member;

class MemberController extends BaseController {
  // Member home page
  public static function home() {
    // Not authenticated -> return to the search page
    if (!self::isAuthenticated()) {
      Response::redirect('/search');
      return;
    }
    $view = self::generateView('index', 'Home', 'withNavigation');
    $view->render();
  }

  // Overide the login function
  public static function login() {
    $view = self::generateView('login', 'Log in', 'withNavigation');
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

  public static function register() {
    // Resolve the register POST reequest
    $body = Request::body();
    $view = self::generateView('register', 'Register', 'withNavigation');
    
    if (Request::isPost()) {
      // If sucessful, redirect to home page
      $response = Member::register($body);
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
}