<?php

namespace app\core;

use app\controllers\BaseController;
use app\core\Application;

/**
 * Class Application
 * 
 * @author someone
 * @package app\core
 */
class Router {
  private string $rootPath;
  protected static array $routes = [];

  public function __construct(string $rootPath) {
    $this->rootPath = $rootPath;
  }

  public function get($path, $callback) {
    self::$routes['get'][$this->rootPath.$path] = $callback;
  }

  public function post($path, $callback) {
    self::$routes['post'][$this->rootPath.$path] = $callback;
  }

  public static function resolve() {
    $path = Request::getPath();
    $method = Request::method();

    // Do real stuff here
    $callback = self::$routes[$method][$path] ?? false;

    // When $callback not found or $callback is not an array, send 404 code
    if (!$callback || !is_array($callback)) {
      // TODO: Make 404 page
      $callback = [BaseController::class, 'notFound'];
    }

    // Function callback
    return call_user_func($callback);
  }
}
