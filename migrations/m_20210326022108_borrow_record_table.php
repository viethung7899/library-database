<?php

class m_20210326022108_borrow_record_table {
  public function up(\PDO $pdo) {
    $query = "CREATE TABLE borrow_record (
      user_id INT NOT NULL,
      isbn VARCHAR(255) NOT NULL,
      borrowDate DATE NOT NULL,
      returnDate DATE NOT NULL,
      FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE,
      FOREIGN KEY (isbn) REFERENCES book(isbn) ON DELETE CASCADE
    )";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DROP TABLE borrow_record";
    $pdo->exec($query);
  }
}
