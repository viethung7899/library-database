<?php

class m_20210326022844_payment_table {
  public function up(\PDO $pdo) {
    $query = "CREATE TABLE payment (
      payment_id VARCHAR(255) PRIMARY KEY,
      date DATE NOT NULL,
      paidAmount REAL NOT NULL,
      paymentMethod VARCHAR(255) SET DEFAULT 'CASH'
      user_id VARCHAR(255),
      FOREIGN KEY (user_id) REFERENCES user
        ON DELETE SET NULL
    )";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "DROP TABLE payment";
    $pdo->exec($query);
  }
}