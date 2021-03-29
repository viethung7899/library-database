<?php

class m_20210326015358_user_table {
  public function up(\PDO $pdo) {
    $query = "CREATE TABLE user (
      user_id INT AUTO_INCREMENT PRIMARY KEY,
      username VARCHAR(255) UNIQUE NOT NULL,
      name VARCHAR(255) NOT NULL,
      phone_number INT NOT NULL
    )";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DROP TABLE user";
    $pdo->exec($query);
  }
}
