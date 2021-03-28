<?php

class m_20210326022108_borrow_record_table {
  public function up(\PDO $pdo) {
    $query = "CREATE TABLE borrow_record (
      user_id VARCHAR(255),
      isbn VARCHAR(255),
      borrowDate DATE NOT NULL,
      returnDate DATE NOT NULL,
      PRIMARY KEY (user_id, isbn),
      FOREIGN KEY (user_id) REFERENCES user(user_id),
      FOREIGN KEY (isbn) REFERENCES book(isbn)
    )";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DROP TABLE borrow_record";
    $pdo->exec($query);
  }
}
