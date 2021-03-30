<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\Employee;
use app\utils\Dumpster;

class AdminController extends BaseController {
  public static function home() {
    // Not authenticated -> return to the search page
    if (!self::isAuthenticated(self::ADMIN)) {
      Response::redirect('/library/login');
      return;
    }
    $view = self::generateView('admin/index', 'Home');
    $view->render();
  }

  public static function addEmployee() {
    $view = self::generateView('admin/addEmployee', 'Add new employee');
    if (Request::isPost()) {
      $employee = new Employee();
      $response = $employee->register();
      self::loadResponseToView($view, $response);
    }
    $view->render();
  }

  public static function searchEmployee() {
    $view = self::generateView('admin/searchEmployee', 'Search employee');
    if (Request::isPost()) {
      $employee = new Employee();
      $response = $employee->search();
      self::loadResponseToView($view, $response);
    }
    $view->render();
  }

  public static function editEmployee() {
    if (Request::isPost()) {

    }
  }

  public static function deleteEmployee() {
    if (Request::isPost()) {
      
    }
  }
}