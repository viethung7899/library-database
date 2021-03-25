<?php

class m_20210325225124_category_table {
  public function up(\PDO $pdo) {
    $query = 'CREATE TABLE category (
      id INT PRIMARY KEY,
      name VARCHAR(255) UNIQUE
    );';
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = 'DROP TABLE category;';
    $pdo->exec($query);
  }
}
