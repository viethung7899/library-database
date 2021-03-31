<?php

class m_20210330163702_book_view {
  public function up(\PDO $pdo) {
    $query = "CREATE VIEW book_view AS
      SELECT b.isbn, b.title, b.author, p.publisher_name, bap.year, b.quantity, c.name as category_name
      FROM book b
      JOIN book_author_publisher bap
        ON bap.title = b.title AND bap.author = bap.author AND b.publisher_id = bap.publisher_id
      JOIN publisher p
      	ON b.publisher_id = p.id
      JOIN book_author ba
      	ON b.author = ba.author AND b.title = ba.title
      JOIN category c
      	ON ba.category_id = c.id";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DROP VIEW book_view";
    $pdo->exec($query);
  }
}
