<?php

class m_20210326022646_fine_table {
  public function up(\PDO $pdo) {
    $query = "CREATE TABLE fine (
      amount REAL,
      user_id VARCHAR(255),
      PRIMARY KEY (amount, user_id),
      FOREIGN KEY (user_id) REFERENCES user(user_id)
    )";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DROP TABLE fine";
    $pdo->exec($query);
  }
}
