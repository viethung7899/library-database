<?php

namespace app\models;

class Employee extends User {
  // Employee login

  // Register an employee
  public static function register($data) {
    $response = parent::register($data);
    if ($response->ok()) {
      $id = $response->content['id'];
      // Add to the privilege
      $hash = password_hash($data['password'], PASSWORD_DEFAULT);
      Privilege::addPrevilege($id, $hash, $data['level']);

      // Add to the member table
      self::addEmployee($id, $data['role'], $data['supervisor_id']);
    }
    
    return $response;
  }

  // Insert into an employee table
  protected static function addEmployee(int $id, string $role, int $supervisor_id) {
    $statement = self::getDatabase()->prepare("INSERT INTO member (staff_id, role, supervisor_id) VALUES (:id, :role, :sid)");
    $statement->bindValue(':id', $id, \PDO::PARAM_INT);
    $statement->bindValue(':role', $role);
    $statement->bindValue(':sid', $supervisor_id, \PDO::PARAM_INT);
    return $statement->execute();
  }

  // Get information of all employees
  public static function getAll() {
    $statement = self::getDatabase()->prepare("SELECT u.user_id, u.name, e.role FROM user u JOIN library_staff e ON u.user_id = e.staff_id");
    $statement->execute();
    return $statement->fetchAll();
  }
}