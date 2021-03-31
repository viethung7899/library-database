<?php

class m_20210326012047_book_table {
  public function up(\PDO $pdo) {
    $query = "CREATE TABLE book (
      isbn VARCHAR(255) PRIMARY KEY,
      title VARCHAR(255) NOT NULL,
      author VARCHAR(255) NOT NULL,
      publisher_id INT NOT NULL,
      quantity INT DEFAULT 0
    )";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DROP TABLE book";
    $pdo->exec($query);
  }
}
