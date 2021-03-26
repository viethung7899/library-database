<?php

class m_20210326021357_member_table {
  public function up(\PDO $pdo) {
    $query = "CREATE TABLE member (
      member_id VARCHAR(255) PRIMARY KEY,
      joining_date DATE NOT NULL,
      period INT DEFAULT 1,
      FOREIGN KEY (member_id) REFERENCES library_staff(staff_id)
          ON DELETE CASCADE
    )";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DROP TABLE member";
    $pdo->exec($query);
  }
}
