<?php

class m_20210331050855_returned_column {
  public function up(\PDO $pdo) {
    $query = "ALTER TABLE borrow_record ADD COLUMN rerturned VARCHAR(1) DEFAULT 'N'";
    $pdo->exec($query);
    $query = "ALTER TABLE borrow_record CHANGE COLUMN `borrowDate` `borrowDate` DATE DEFAULT CURRENT_DATE";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "ALTER TABLE borrow_record CHANGE COLUMN `borrowDate` `borrowDate` DATE NOT NULL";
    $pdo->exec($query);
    $query = "ALTER TABLE borrow_record DROP COLUMN rerturned";
    $pdo->exec($query);
  }
}
