<?php

class m_20210326020532_username_table {
  public function up(\PDO $pdo) {
    $query = "CREATE TABLE username (
      username VARCHAR(255) PRIMARY KEY,
      name VARCHAR(255) NOT NULL,
      phone_number INT,
      FOREIGN KEY (username) REFERENCES user
          ON DELETE CASCADE ON UPDATE CASCADE
    )";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DROP TABLE username";
    $pdo->exec($query);
  }
}
