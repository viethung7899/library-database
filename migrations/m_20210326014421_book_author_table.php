<?php

class m_20210326014421_book_author_table {
  public function up(\PDO $pdo) {
    $query = "CREATE TABLE book_author (
      title VARCHAR(255) PRIMARY KEY,
      author VARCHAR(255) PRIMARY KEY,
      category_id INT NOT NULL SET DEFAULT 0,
      FOREIGN KEY (title) REFERENCES book(title)
          ON DELETE CASCADE ON UPDATE CASCADE,
      FOREIGN KEY (author) REFERENCES book(author)
          ON DELETE CASCADE ON UPDATE CASCADE,
      FOREIGN KEY (category_id) REFERENCES category(id)    
    )";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DROP TABLE book_author";
    $pdo->exec($query);
  }
}
