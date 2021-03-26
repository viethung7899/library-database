<?php

namespace app\models;

use app\core\Model;
use app\core\Response;
use app\utils\Rule;

class User extends Model {
  protected static function rules() {
    return [
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
  public static function register($data) {
    $response = new Response();

    // Verify the input data
    $response->errors = self::verifyInput($data, self::rules());

    // Verify the matching password
    if (
      $data['password'] !== $data['confirmPassword']
      && empty($errors['confirmPassword'] ?? '')
    ) {
      echo 'No match';
      $response->errors->addError('confirmPassowrd', 'Passwords are not match');
    }

    // Failed validation
    if (!$response->errors->isEmpty()) {
      return $response;
    }

    // Check for exisitng user
    $existing = self::findOneUserByUsername($data['username']);
    if (!empty($existing)) {
      $response->errors->addError('username', 'Username already existed');
      return $response;
    }

    self::addNewUser($data['username'], $data['password']);
    return $response;
  }

  // Find one user in the system
  public static function login($data) {
    $response = new Response();
    $errors = self::verifyInput($data, self::rules());

    // Failed valiadtion
    if (!$errors->isEmpty()) {
      $response->errors = $errors->content;
      return $response;
    }

    $result = self::findOneUserByUsername($data['username']);

    // Check if the username exists
    if (empty($result)) {
      $errors->addError('username', 'Username not found');
      $response->errors = $errors->content;
      return $response;
    }

    // Check if the password is valid
    $hashPassword = $result[0]['hash_password'];
    if (password_verify($data['password'], $hashPassword)) {
      $errors->addError('password', 'Wrong password');
      $response->errors = $errors->content;
    }

    return $response;
  }

  protected static function findOneUserByUsername(string $username) {
    $statement = self::getDatabase()->prepare('SELECT id FROM user WHERE username = :u');
    $statement->bindValue(':u', $username);
    $statement->execute();
    return $statement->fetchAll();
  }

  protected static function addNewUser(string $username, string $password) {
    $hashPassword = password_hash($password, PASSWORD_ARGON2I);
    $statement = self::getDatabase()->prepare('INSERT INTO user (username, hash_password) VALUES (:u, :h)');
    $statement->bindValue(':u', $username);
    $statement->bindValue(':h', $hashPassword);
    $statement->execute();

    return true;
  }
}
