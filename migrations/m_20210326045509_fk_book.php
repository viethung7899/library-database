<?php

class m_20210326045509_fk_book {
  public function up(\PDO $pdo) {
    $query = "ALTER TABLE book
    ADD CONSTRAINT fk_book_author_publisher 
    FOREIGN KEY (title, author, publisher_id) 
    REFERENCES book_author_publisher(title, author, publisher_id)
    ON UPDATE CASCADE ON DELETE CASCADE";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "ALTER TABLE book
    DROP CONSTRAINT fk_book_author_publisher";
    $pdo->exec($query);
  }
}
