<?php

class m_20210326020851_privilege_table {
  public function up(\PDO $pdo) {
    $query = "CREATE TABLE privilege (
      user_id VARCHAR(255),
      password VARCHAR(255),
      access_level INT NOT NULL,
      PRIMARY KEY (user_id, password),
      FOREIGN KEY (user_id) REFERENCES user
          ON DELETE CASCADE
    )";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DROP TABLE privilege";
    $pdo->exec($query);
  }
}
