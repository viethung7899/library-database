<?php

class m_20210326022844_payment_table {
  public function up(\PDO $pdo) {
    $query = "CREATE TABLE payment (
      payment_id VARCHAR(255) PRIMARY KEY,
      date DATE NOT NULL,
      paidAmount REAL NOT NULL,
      paymentMethod VARCHAR(255) DEFAULT 'CASH',
      user_id INT,
      FOREIGN KEY (user_id) REFERENCES user(user_id)
        ON DELETE SET NULL
    )";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DROP TABLE payment";
    $pdo->exec($query);
  }
}
