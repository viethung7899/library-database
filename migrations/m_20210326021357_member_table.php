<?php

class m_20210326021357_member_table {
  public function up(\PDO $pdo) {
    $query = "CREATE TABLE member (
      member_id INT PRIMARY KEY,
      joining_date DATE DEFAULT CURRENT_DATE,
      period INT DEFAULT 1,
      FOREIGN KEY (member_id) REFERENCES user(user_id)
          ON DELETE CASCADE
    )";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DROP TABLE member";
    $pdo->exec($query);
  }
}
