<?php

class m_20210326022410_reservation_table {
  public function up(\PDO $pdo) {
    $query = "CREATE TABLE reservation (
      user_id INT,
      isbn VARCHAR(255),
      pickupDate DATE NOT NULL,
      PRIMARY KEY (user_id, isbn),
      FOREIGN KEY (user_id) REFERENCES user(user_id)
        ON DELETE CASCADE,
      FOREIGN KEY (isbn) REFERENCES book(isbn)
        ON DELETE CASCADE
    )";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DROP TABLE reservation";
    $pdo->exec($query);
  }
}
