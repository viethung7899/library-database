<?php

class m_20210326044633_fk_book_author_publisher {
  public function up(\PDO $pdo) {
    $query = "ALTER TABLE book_author_publisher
      ADD CONSTRAINT fk_book_author 
      FOREIGN KEY (title, author) 
      REFERENCES book_author(title, author)
      ON UPDATE CASCADE ON DELETE CASCADE";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "ALTER TABLE book_author_publisher
    DROP CONSTRAINT fk_book_author";
    $pdo->exec($query);
  }
}
