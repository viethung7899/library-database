<?php

class m_20210329042232_publisher_data {
  public function up(\PDO $pdo) {
    $query = "INSERT INTO publisher VALUES (1, 'Banana'), (2, 'Turtle'), (3, 'Car'), (4, 'Zoom'), (5, 'Bird')";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DELETE FROM publisher";
    $pdo->exec($query);
  }
}
