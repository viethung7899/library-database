<?php

class m_20210326022646_fine_table {
  public function up(\PDO $pdo) {
    $query = "CREATE TABLE fine (
      amount REAL PRIMARY KEY,
      user_id VARCHAR(255) PRIMARY KEY,
      FOREIGN KEY (user_id) REFERENCES user
    )";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DROP TABLE fine";
    $pdo->exec($query);
  }
}