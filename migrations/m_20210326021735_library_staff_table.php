<?php

class m_20210326021735_library_staff_table {
  public function up(\PDO $pdo) {
    $query = "CREATE TABLE library_staff (
      staff_id VARCHAR(255) PRIMARY KEY,
      role VARCHAR NOT NULL,
      supervisor_id VARCHAR(255),
      FOREIGN KEY (staff_id) REFERENCES member(member_id),
      FOREIGN KEY (supervisor_id) REFERENCES library_staff
        ON DELETE SET NULL
    )";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DROP TABLE library_staff";
    $pdo->exec($query);
  }
}
