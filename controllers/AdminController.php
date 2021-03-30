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
    $view = self::generateView('admin/addEmployee', 'Add new employee', 'admin');
    $view->render();
  }

  public static function searchEmployee() {
    $view = self::generateView('admin/searchEmployee', 'Search employee', 'admin');
    $view->render();
  }

  public static function editEmployee() {

  }

  public static function deleteEmployee() {

  }
}