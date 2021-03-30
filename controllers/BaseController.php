<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Response;
use app\core\Request;
use app\models\User;

// This controller is interacting with the User model
class BaseController extends Controller {
  const MEMBER = 0;
  const LIBRARIAN = 1;
  const ADMIN = 2;

  // Render the home page, can access without login
  protected static function home() {}

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
    $session->set('level', $response->content['level'] ?? 0);
  }

  public static function isAuthenticated(int $level = self::MEMBER) {
    return self::isLogin() && self::getSession()->get('level') == $level;
  }

  public static function isLogin() {
    return self::getSession()->get('id');
  }

  public static function logout() {
    self::getSession()->reset();
    Response::redirect('/search');
    return;
  }
}
