<?php

// This script is only for developer use only

/**
 * Configure the database, create new one if not exists
 */

use app\core\DatabaseMigration;

require_once __DIR__ . '/vendor/autoload.php';

$dot_env = Dotenv\Dotenv::createImmutable(__DIR__);
$dot_env->load();

// Database config and hide the credentials
$config = [
    'dsn' => 'mysql:host='.$_ENV['DB_HOST'].';port='.$_ENV['DB_PORT'],
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
];

$migrationDirectory = __DIR__.'/migrations';

$migration = new DatabaseMigration($config, $migrationDirectory);
$dbName = '`'.$_ENV['DB_NAME'].'`';

// Create database if not exsists
$migration->query("CREATE DATABASE IF NOT EXISTS $dbName");
$migration->query("use $dbName");

/**
 * Starting migration script
 */

$MAKE = '--make';
$UP = '--up';
$DOWN = '--down';
$NOW = '--now';

// Make migrartion file
function makeMigration(string $name) {
  global $migrationDirectory;
  $created = date('YmdHis');
  $className = 'm' . '_' . $created . '_' . strtolower($name);

  $source = __DIR__ . '/bin/sample';
  $dest = "$migrationDirectory/$className.php";

  $content = file_get_contents($source);
  $content = str_replace('MIGRATION_NAME', $className, $content);
  file_put_contents($dest, $content);
}

// Print the manual to the terminal
function help() {
  global $MAKE, $UP, $DOWN, $NOW, $argv;
  echo 'Usage: php ' . ($argv[0] ?? 'migrations') . "\n";
  echo "  To migrate the database\n\n";
  echo "  Options:\n";
  echo "    $MAKE [migration_name]    Create a migration\n";
  echo "    $UP                       Update one migration\n";
  echo "    $DOWN                     Rollback the recent migration\n";
  echo "    $NOW                      Get the latest migration\n\n";
  echo "    --help                    Get the manual\n\n";
  exit(1);
}

// Check if the file name is a valid indentifier
function validName(string $name) {
  $re = '/^[A-Za-z](\w+)?([A-Za-z0-9])?$/';
  return preg_match($re, $name) > 0;
}

// Parse the command and execute
if ($argc <= 1) {
  $migration->applyMigrations();
} else if ($argc == 2) {
  if ($argv[1] === $UP) {
    $migration->update();
  } else if ($argv[1] === $DOWN) {
    $migration->rollback();
  } else if ($argv[1] === $NOW) {
    $migration->now();
  } else {
    help();
  }
} else if ($argc == 3 && $argv[1] === $MAKE) {
  if (validName($argv[2])) {
    makeMigration($argv[2]);
  } else {
    echo $argv[2] . " is not a valid name\n";
    exit(1);
  }
} else {
  help();
}
