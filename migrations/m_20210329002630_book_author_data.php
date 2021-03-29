<?php

class m_20210329002630_book_author_data {
  public function up(\PDO $pdo) {
    $query = "INSERT INTO `book_author` VALUES 
      ('Caveman', 'John Jacobs', 1),
      ('If I Ran the Zoo', 'Dr.Seuss', 4),
      ('Jane Eyre', 'Charlotte Bronte', 4),
      ('Night', 'Elie Wiesel', 1),
      ('It', 'Stephen King', 2);";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DELETE FROM `book_author`";
    $pdo->exec($query);
  }
}
