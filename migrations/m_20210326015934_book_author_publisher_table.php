<?php

class m_20210326015934_book_author_publisher_table {
  public function up(\PDO $pdo) {
    $query = "CREATE TABLE book_author_publisher (
      title VARCHAR(255),
      author VARCHAR(255),
      publisher_id INT,
      year INT NOT NULL,
      PRIMARY KEY (title, publisher_id, author),
      FOREIGN KEY (publisher_id) REFERENCES publisher(id)
          ON DELETE CASCADE ON UPDATE CASCADE
    )";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DROP TABLE book_author_publisher";
    $pdo->exec($query);
  }
}
