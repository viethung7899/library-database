<?php

namespace app\controllers;

use app\core\Response;

class AdminController extends BaseController {
  public static function home() {
    // Not authenticated -> return to the search page
    if (!self::isAuthenticated(self::ADMIN)) {
      Response::redirect('/library/login');
      return;
    }
    $view = self::generateView('admin/index', 'Home', 'withNavigation');
    $view->render();
  }

  public static function addEmployee() {

  }

  public static function editEmployee() {

  }

  public static function deleteEmployee() {

  }
}