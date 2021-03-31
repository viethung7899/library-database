<?php

class m_20210330161715_book_data {
  public function up(\PDO $pdo) {
    $query = "INSERT INTO book VALUES 
    (231241, 'Caveman', 'John Jacobs', 1, 7),
    (4324573, 'If I Ran the Zoo', 'Dr.Seuss', 2, 10),
    (14353, 'Jane Eyre', 'Charlotte Bronte', 2, 3),
    (57437534, 'Night', 'Elie Wiesel', 4, 6),
    (342353, 'It', 'Stephen King', 4, 6)";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DELETE FROM book";
    $pdo->exec($query);
  }
}
