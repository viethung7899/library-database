<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Member;
use app\models\User;

class MemberController extends BaseController {
  // Make the rules of the 

  // Overide the login function
  public static function login() {
    $body = Request::body();
    $view = self::generateView('login', 'Log in');
    // Call login function from
    if (Request::isPost()) {
      // If sucessful, redirect to home page
      $response = Member::login($body);
      
      // If successful, redirect to the home
      if ($response->ok()) {
        Response::redirect('/');
        return;
      }
      
      $params = [
        'body' => $response->content,
        'errors' => $response->errors
      ];
      $view->loadParameters($params);
    }


    // Render the login page (with errors if possible)
    $view->render();
  }

  public static function register() {
    // Resolve the register POST reequest
    $body = Request::body();
    $view = self::generateView('register', 'Register');
    
    if (Request::isPost()) {
      // If sucessful, redirect to home page
      $response = Member::register($body);
      if ($response->ok()) {
        Response::redirect('/');
        return;
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