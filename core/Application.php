<?php

namespace app\core;

// A class which faciliate th ewhole application
// one single instance
class Application extends Router {
  private static Application $app;
  private static string $ROOT_DIR;
  private Database $db;
  private Session $session;

  // Contruct the app with the root
  public function __construct(string $rootDir) {
    parent::__construct('');
    self::$app = $this;
    self::$ROOT_DIR = $rootDir;
    self::$routes = [];
    $this->session = new Session();
  }

  // Connect the app with the databse
  public function connectDatabase(array $config) {
    $this->db = new Database($config);
    return $this->db;
  }

  // Get the databse instance of the app
  public function getDatabase() {
    return self::$app->db;
  }

  // Get the databse instance of the app
  public function getSession() {
    return self::$app->session;
  }

  // Get the app instance
  public static function getApp() {
    return self::$app;
  }

  // Retrieve the location of the root directory
  public static function getRootDir() {
    return self::$ROOT_DIR;
  }

  // Run this app
  public function run() {
    return Router::resolve();
  }
}