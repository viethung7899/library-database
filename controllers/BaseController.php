<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Response;
use app\core\Request;
use app\core\View;
use app\models\Book;
use app\models\Reservation;
use app\models\User;

// This controller is interacting with the User model
class BaseController extends Controller {
  const MEMBER = 0;
  const LIBRARIAN = 1;
  const ADMIN = 2;

  // Render the home page, can access without login
  protected static function home() {
    // Redirect if the user already login
    $level = self::getSession()->get('level');
    if ($level == self::LIBRARIAN) {
      Response::redirect('/library');
      return true;
    }

    if ($level == self::ADMIN) {
      Response::redirect('/admin');
      return true;
    }
    return false;
  }

  public static function notFound() {
    $view = self::generateView('notFound', 'Not found');
    Response::setStatusCode(404);
    $view->render();
    exit;
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
    $response = new Response();
    $body = Request::body();
    if (!empty($body)) {
      $response->content['books'] = Book::search($body);
      self::loadResponseToView($view, $response);
    }
    $view->render();
  }

  // Only call after login method
  protected static function setSession(Response $response, int $level = self::MEMBER) {
    $session = self::getSession();
    $user = $response->content['user'];
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

  // Return book details
  public static function bookDetail() {
    $isbn = Request::body()['isbn'];

    // Find books
    if (!isset($isbn)) self::notFound();
    $books = Book::getBookByISBN($isbn);
    if (empty($books)) self::notFound();
    $response = new Response();
    $response->content['book'] = $books[0];
    
    // Find reservations
    $r = new Reservation(); $r->isbn = $isbn;
    $response->content['reservations'] = Reservation::getAllRervations($r);

    return $response;
  }
}
