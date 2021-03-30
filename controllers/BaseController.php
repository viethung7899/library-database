<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Response;
use app\core\Request;
use app\models\User;

// This controller is interacting with the User model
class BaseController extends Controller {
  // Render the home page, can access without login
  public static function home() {
    if (!self::isAuthenticated()) {
      // Redirect to search
      Response::redirect('/search');
      return;
    }
    $view = self::generateView('index', 'Home', 'withNavigation');
    $view->render();
  }

  public static function notFound() {
    $view = self::generateView('notFound', 'Home', 'withNavigation');
    $view->render();
  }

  // Only return the response, not the view itself, the view should be handle by its subclass
  protected static function login() {
    $body = Request::body();
    return User::login($body);
  }

  // Can access without login
  public static function searchBook() {
    $view = self::generateView('searchBook', 'Book search', 'withNavigation');
    // Resolve book search
    $body = Request::body();
    // Else, show the error on the form
    $view->render();
  }

  protected static function setSession(Response $response) {
    $session = self::getSession();
    $session->set('id', $response->content['id']);
    $session->set('name', $response->content['name']);
    $session->set('level', $response->content['level']);
  }

  public static function isAuthenticated() {
    return self::getSession()->get('id');
  }

  public static function protectedRoute() {
    if (!self::isAuthenticated()) {
      Response::redirect('/search');
      return true;
    }
    return false;
  }

  public static function logout() {
    self::getSession()->reset();
    Response::redirect('/search');
    return;
  }
}
