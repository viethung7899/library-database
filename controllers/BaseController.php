<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Response;
use app\core\Request;
use app\core\View;
use app\models\User;
use app\utils\Dumpster;

// This controller is interacting with the User model
class BaseController extends Controller {
  const MEMBER = 0;
  const LIBRARIAN = 1;
  const ADMIN = 2;

  // Render the home page, can access without login
  protected static function home() {}

  public static function notFound() {
    $view = self::generateView('notFound', 'Home');
    $view->render();
  }

  // Only return the response, not the view itself, the view should be handle by its subclass
  protected static function login() {
    $body = Request::body();
    $user = new User();
    return $user->login($body);
  }

  // Can access without login
  public static function searchBook() {
    $view = self::generateView('searchBook', 'Book search');
    // Resolve book search
    // Else, show the error on the form
    $view->render();
  }

  // Only call after login method
  protected static function setSession(Response $response, int $level = self::MEMBER) {
    $session = self::getSession();
    $user = $response->content['user'];
    Dumpster::dump($user);
    $session->set('id', $user->user_id);
    $session->set('name', $user->name);
    $session->set('level', $level);
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

  public static function loadResponseToView(View $view, Response $response) {
    $params = [
      'body' => $response->content,
      'errors' => $response->errors
    ];
    
    $view->loadParameters($params);
  }
}
