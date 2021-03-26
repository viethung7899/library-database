<?php

class m_20210326022108_borrow_record_table {
  public function up(\PDO $pdo) {
    $query = "CREATE TABLE borrow_record (
      user_id VARCHAR(255) PRIMARY KEY,
      isbn VARCHAR(255) PRIMARY KEY,
      borrowDate DATE NOT NULL,
      returnDate DATE NOT NULL,
      FOREIGN KEY (user_id) REFERENCES user,
      FOREIGN KEY (isbn) REFERENCES book
    )";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DROP TABLE borrow_record";
    $pdo->exec($query);
  }
}
