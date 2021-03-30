<?php

namespace app\controllers;

class LibrarianController extends BaseController {
  public static function home() {
    $view = self::generateView('library/index', 'Home', 'withNavigation');
    $view->render();
  }

  // Overide the login function
  public static function login() {
    // Call login function
    parent::login();

    // Check credientials

    // If successful, redirect to the librarians page

    // Render the login page (with errors if possible)
  }

  public static function addBook() {

  }

  public static function editBook() {

  }

  public static function deleteBook() {

  }

  public static function confirmReservation() {

  }

  public static function confirmBorrow() {

  }
}