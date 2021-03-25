<?php

class m_20210309082950_initial {
  public function up() {
    $db = \app\core\Application::$app->db;
    $userTable = "CREATE TABLE user (
      id INT AUTO_INCREMENT PRIMARY KEY,
      username VARCHAR(255) UNIQUE NOT NULL,
      hash_password VARCHAR(255) NOT NULL
    );";
    $db->pdo->exec($userTable);
  }

  public function down() {
    $db = \app\core\Application::$app->db;
    $dropUser = "DROP TABLE user";
    $db->pdo->exec($dropUser);
  }
}
