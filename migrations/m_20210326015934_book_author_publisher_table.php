<?php

class m_20210326015934_book_author_publisher_table {
  public function up(\PDO $pdo) {
    $query = "CREATE TABLE book_author_publisher (
      title VARCHAR(255) PRIMARY KEY,
      publisher_id INT PRIMARY KEY,
      author VARCHAR(255) PRIMARY KEY,
      year INT NOT NULL,
      quantity INT SET DEFAULT 0,
      FOREIGN KEY (title) REFERENCES book
          ON DELETE CASCADE ON UPDATE CASCADE,
      FOREIGN KEY (author) REFERENCES book
          ON DELETE CASCADE ON UPDATE CASCADE,
      FOREIGN KEY (publisher_id) REFERENCES book
          ON DELETE CASCADE ON UPDATE CASCADE
    )";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DROP TABLE book_author_publisher";
    $pdo->exec($query);
  }
}
