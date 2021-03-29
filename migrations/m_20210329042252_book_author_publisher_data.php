<?php

class m_20210329042252_book_author_publisher_data {
  public function up(\PDO $pdo) {
    $query = "INSERT INTO book_author_publisher VALUES 
      ('Caveman', 'John Jacobs', 1, 1990, 7),
      ('If I Ran the Zoo', 'Dr.Seuss', 2, 1950, 10),
      ('Jane Eyre', 'Charlotte Bronte', 2, 1942, 6),
      ('Night', 'Elie Wiesel', 4, 1956, 6),
      ('It', 'Stephen King', 4, 1994, 3)";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DELETE FROM ";
    $pdo->exec($query);
  }
}
