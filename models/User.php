<?php

namespace app\models;

use app\core\Model;
use app\utils\Rule;

class User extends Model {
  protected static function rules() {
    return [
      'name' => [
        [Rule::REQUIRED],
      ],
      'username' => [
        [Rule::REQUIRED],
        [Rule::MIN, 6],
        [Rule::MAX, 20],
      ],
      'password' => [
        [Rule::REQUIRED],
        [Rule::MIN, 6],
        [Rule::MAX, 20],
      ],
      'confirmPassword' => [
        [Rule::REQUIRED]
      ]
    ];
  }

  // Add new user to the system
  // $data is an array having the field of username, password, confirmPassword
  public static function register($data) {
    // Verify the input data
    $response = self::verifyInput($data, self::rules());

    // Verify the matching password
    if (
      $data['password'] !== $data['confirmPassword']
      && empty($errors['confirmPassword'] ?? '')
    ) {
      echo 'No match';
      $response->addError('confirmPassowrd', 'Passwords are not match');
    }

    // Failed validation
    if (!$response->ok()) {
      return $response;
    }

    // Check for exisitng user
    $existing = self::findOneUserByUsername($data['username']);
    if (!empty($existing)) {
      $response->addError('username', 'Username already existed');
      return $response;
    }

    // Add new user
    $id = self::addNewUser($data['name'], $data['username']);
    $response->content['id'] = $id;

    return $response;
  }

  // $data is an array having the field of username, password
  public static function login($data) {
    $response = self::verifyInput($data, self::rules());

    // Failed valiadtion
    if (!$response->ok()) {
      return $response;
    }

    $result = self::findOneUserByUsername($data['username']);

    // Check if the username exists
    if (empty($result)) {
      $response->addError('username', 'Username not found');
      return $response;
    }

    // Check if the password is valid
    $hashPassword = $result[0]['hash_password'];
    if (password_verify($data['password'], $hashPassword)) {
      $response->addError('password', 'Wrong password');
    }

    return $response;
  }

  protected static function findOneUserByUsername(string $username) {
    $statement = self::getDatabase()->prepare('SELECT * FROM user WHERE username = :u LIMIT 1');
    $statement->bindValue(':u', $username);
    $statement->execute();
    return $statement->fetchAll();
  }

  // Return last inserted id when adding new user
  protected static function addNewUser(string $name, string $username) {
    $statement = self::getDatabase()->prepare('INSERT INTO user (name, username) VALUES (:name, :username)');
    if ($statement->execute([':username' => $username, ':name' => $name])) {
      return self::getDatabase()->pdo->lastInsertId();
    }
    return -1;
  }
}
