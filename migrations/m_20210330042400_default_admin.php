<?php

class m_20210330042400_default_admin {
  public function up(\PDO $pdo) {
    $username = 'admin';
    $password = password_hash($username, PASSWORD_DEFAULT);
    $query = "INSERT INTO `user` (user_id, username, name) VALUES (0, '$username', '$username')";
    $pdo->exec($query);
    $id = $pdo->lastInsertId();
    $query = "INSERT INTO `privilege` (user_id, password, access_level) VALUES ($id, '$password', 2)";
    $pdo->exec($query);

  }

  public function down(\PDO $pdo) {
    $query = "DELETE FROM `user` WHERE username = 'admin'";
    $pdo->exec($query);
  }
}
