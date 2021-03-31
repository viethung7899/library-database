<?php

namespace app\core;

class Controller {
  // Generate the view with specific view template and layout template
  public static function getSession() {
    return Application::getApp()->getSession();
  }

  public static function generateView(string $view, string $title = 'Document', string $layout = 'withNavigation') {
    $view = new View($view, $layout);
    $view->setTitle($title);
    return $view;
  }
}