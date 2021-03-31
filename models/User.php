<?php

namespace app\models;

use app\core\Model;
use app\utils\Dumpster;
use app\utils\Rule;

class User extends Model {
  public ?int $user_id;
  public string $name;
  public string $username;
  protected ?string $password;
  protected ?string $confirmPassword;
  protected ?string $hash_password;
  public ?int $access_level;

  // Rules for validation
  protected static function rules() {
    return [
      'name' => [
        [Rule::REQUIRED],
      ],
      'username' => [
        [Rule::REQUIRED],
        [Rule::MIN, 5],
        [Rule::MAX, 20],
      ],
      'password' => [
        [Rule::REQUIRED],
        [Rule::MIN, 5],
        [Rule::MAX, 20],
      ],
      'confirmPassword' => [
        [Rule::REQUIRED]
      ]
    ];
  }

  public function __construct() {
    $this->loadDataFromRequest();
  }

  // Add new user to the system
  // $data is an array having the field of username, password, confirmPassword
  public function register() {
    // Verify the input data
    $response = $this->verifyInput();

    // Verify the matching password
    if (isset($this->confirmPassword) && $this->password !== $this->confirmPassword) {
      $response->addError('confirmPassword', 'Passwords are not match');
    }

    // Failed validation
    if (!$response->ok()) {
      return $response;
    }

    // Check for exisitng user
    $existing = self::findOneInfoByUsername($this->username);
    if (!empty($existing)) {
      $response->addError('username', 'Username already existed');
      return $response;
    }

    // Adding new user to User table
    $id = self::addNewUser($this->name, $this->username);
    $this->user_id = $id;
    $response->content['user'] = $this;

    return $response;
  }

  // Update user to the system
  // $data is an array having the field of username, password, confirmPassword
  public function update(User $old) {
    // Verify the input data
    $response = $this->verifyInput();

    // Failed validation
    if (!$response->ok()) {
      return $response;
    }

    // Check for exisitng user or ignore if the username not change
    if ($old->username !== $this->username) {
      $existing = self::findOneInfoByUsername($this->username);
      if (!empty($existing)) {
        $response->addError('username', 'Username already existed');
        return $response;
      }
    }

    // Update new user
    $id = self::updateUser($this->user_id, $this->name, $this->username);
    Privilege::updatePassword($this->user_id, $this->password);
    $this->user_id = $id;
    $response->content['user'] = $this;

    return $response;
  }

  // $data is an array having the field of username, password
  public function login() {
    $response = $this->verifyInput();

    // Failed valiadtion
    if (!$response->ok()) {
      return $response;
    }

    $result = self::findOneInfoByUsername($this->username);

    // Check if the username exists
    if (empty($result)) {
      $response->addError('username', 'Username not found');
      return $response;
    }

    // Check if the password is valid
    $hashPassword = $result[0]->hash_password;
    if (!password_verify($this->password, $hashPassword)) {
      $response->addError('password', 'Wrong password');
    } else {
      // Set out the content
      $response->content['user'] = $result[0];
    }

    return $response;
  }

  // Find one user by id
  public static function findOneById(int $id) {
    $statement = self::getDatabase()->prepare('SELECT * FROM user WHERE user_id = :id LIMIT 1');
    $statement->bindValue(':id', $id, \PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(\PDO::FETCH_CLASS, self::class);
  }

  // Find one user by username
  protected static function findOneInfoByUsername(string $username) {
    $statement = self::getDatabase()->prepare('SELECT u.user_id, u.name, p.hash_password, p.access_level 
      FROM user u JOIN privilege p ON u.user_id = p.user_id 
      WHERE u.username = :u');
    $statement->bindValue(':u', $username);
    $statement->execute();
    return $statement->fetchAll(\PDO::FETCH_CLASS, User::class);
  }

  protected static function updateUser(int $id, string $name, string $username) {
    $statement = self::getDatabase()->prepare('UPDATE user SET username = :u, name = :n WHERE user_id = :id');
    $statement->bindValue(':id', $id, \PDO::PARAM_INT);
    $statement->bindValue(':u', $username);
    $statement->bindValue(':n', $name);
    return $statement->execute();
  }

  protected static function deleteUser(int $id) {
    $statement = self::getDatabase()->prepare('DELETE FROM user WHERE user_id = :id');
    $statement->bindValue(':id', $id, \PDO::PARAM_INT);
    return $statement->execute();
  }

  // Return last inserted id when adding new user
  protected static function addNewUser(string $name, string $username) {
    $statement = self::getDatabase()->prepare('INSERT INTO user (name, username) VALUES (:name, :username)');
    if ($statement->execute([':username' => $username, ':name' => $name])) {
      return self::getDatabase()->pdo->lastInsertId();
    }
    return -1;
  }

  // Count the number of users
  public static function count() {
    $statement = self::getDatabase()->query("SELECT count(*) FROM user");
    return $statement->fetchColumn();
  }
}
