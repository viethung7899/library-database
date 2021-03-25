<?php

namespace app\core;

// To facilitate the database migration
class DatabaseMigration extends Database {
  private string $migrationDirectory;
  
  public function __construct(array $config, string $dir) {
    parent::__construct($config);
    $this->migrationDirectory = $dir;
  }

  // Create a migration table if the exists
  public function createMigrationTable() {
    $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255),
        createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      )");
  }

  // Get all the migrations which haven't applied to the database
  private function getToApplyMigrations() {
    $files = scandir($this->migrationDirectory);
    $toApplyMigrations = array_diff($files, [...$this->getAppliedMigrations(), '.', '..']);
    return $toApplyMigrations;
  }

  // Get all the migration which already applied to the database
  private function getAppliedMigrations() {
    $statement = $this->pdo->prepare("SELECT migration FROM migrations");
    $statement->execute();
    return $statement->fetchAll(\PDO::FETCH_COLUMN);
  }

  // Apply migrations to the database for the newest version
  public function applyMigrations() {
    $this->createMigrationTable();
    $toApplyMigrations = $this->getToApplyMigrations();
    if (empty($toApplyMigrations)) {
      DatabaseMigration::log('All migrations applied');
      return;
    }

    foreach ($toApplyMigrations as $migration) {
      $this->apply($migration);
    }
  }

  // Applied a specific migration to the database
  private function apply($migration) {
    require_once $this->migrationDirectory . "/$migration";
    $className = pathinfo($migration, PATHINFO_FILENAME);
    $instance = new $className();
    $instance->up($this->pdo);
    $this->save($migration);
    DatabaseMigration::log("Applied migration $migration");
  }

  // Save the info of the migration to the database
  private function save($migration) {
    $val = "('$migration')";
    $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $val");
    $statement->execute();
  }

  // Get the current status about migration
  public function now() {
    $this->createMigrationTable();
    $applied = $this->getAppliedMigrations();
    if (empty($applied)) {
      DatabaseMigration::log('No migration applied');
    } else {
      DatabaseMigration::log('Latest migration: ' . end($applied));
    }
  }

  // Apply one migration forward to the database
  public function update() {
    $this->createMigrationTable();
    $toApplyMigrations = $this->getToApplyMigrations();
    if (empty($toApplyMigrations)) {
      DatabaseMigration::log('All migrations applied');
    } else {
      $first = array_values($toApplyMigrations)[0];
      $this->apply($first);
    }
  }

  // Rollback migration to the previous migration
  public function rollback() {
    $this->createMigrationTable();
    $applied = $this->getAppliedMigrations();
    if (empty($applied)) {
      DatabaseMigration::log('No more migration to rollback');
    } else {
      $last = end($applied);
      require_once $this->migrationDirectory."/$last";
      $className = pathinfo($last, PATHINFO_FILENAME);
      $instance = new $className();
      $instance->down($this->pdo);

      // Delete migration
      $statement = $this->pdo->prepare("DELETE FROM migrations WHERE migration='$last'");
      $statement->execute();

      DatabaseMigration::log("Rollback migration $last");
      $this->now();
    }
  }

  // Log messeage
  private static function log($message) {
    echo '[' . date('Y-m-d H:i:s') . "] $message\n";
  }
}