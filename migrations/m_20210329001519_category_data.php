<?php

class m_20210329001519_category_data {
  public function up(\PDO $pdo) {
    $query = "INSERT INTO `category` VALUES (0,  'Unassigned'), (1, 'Non-fiction'), (2, 'Horror'), (3, 'Comedy'), (4, 'Fiction')";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DELETE FROM `category`";
    $pdo->exec($query);
  }
}