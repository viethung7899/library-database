<?php

class m_20210326021735_library_staff_table {
  public function up(\PDO $pdo) {
    $query = "CREATE TABLE library_staff (
      staff_id INT PRIMARY KEY,
      role VARCHAR(255) NOT NULL,
      supervisor_id INT,
      FOREIGN KEY (staff_id) REFERENCES member(member_id) 
        ON DELETE CASCADE,
      FOREIGN KEY (supervisor_id) REFERENCES library_staff(staff_id)
        ON DELETE SET NULL
    )";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DROP TABLE library_staff";
    $pdo->exec($query);
  }
}
