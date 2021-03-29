<?php

class m_20210325235156_publisher_table {
  public function up(\PDO $pdo) {
    $query = "CREATE TABLE publisher (
      id INT AUTO_INCREMENT PRIMARY KEY,
      publisher_name VARCHAR(255) NOT NULL
    )";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DROP TABLE publisher";
    $pdo->exec($query);
  }
}
