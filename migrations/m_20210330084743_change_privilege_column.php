<?php

class m_20210330084743_change_privilege_column {
  public function up(\PDO $pdo) {
    $query = "ALTER TABLE privilege CHANGE password hash_password VARCHAR(255) NOT NULL";
    $pdo->exec($query);
  }

  public function down(\PDO $pdo) {
    $query = "ALTER TABLE privilege CHANGE hash_password password VARCHAR(255) NOT NULL";
    $pdo->exec($query);
  }
}
