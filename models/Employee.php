<?php

namespace app\models;

use app\core\Response;

class Employee extends User {
  public string $role;
  public ?int $supervisor_id = NULL;

  // Register an employee
  public function register() {
    $response = parent::register();
    if ($response->ok()) {
      $id = $this->user_id;

      if ($this->supervisor_id != NULL) {
        // Search for employee
        $supervisor = self::getOneById($this->supervisor_id);
        if (empty($supervisor)) {
          $response->addError('supervisor_id', 'Supervisor ID not found');
          self::deleteUser($id);
          return $response;
        }
      }

      // Add to the privilege
      $hash = password_hash($this->password, PASSWORD_DEFAULT);
      Privilege::addPrevilege($id, $hash, $this->access_level);

      // Add to the member table
      self::addEmployee($id, $this->role, $this->supervisor_id);
    }
    
    return $response;
  }

  public function search() {
    $response = new Response();
    $employees = self::getEmployeesByName($this->name);
    $response->content['employees'] = $employees;
    return $response;
  }

  // Insert into an employee table
  protected static function addEmployee(int $id, string $role, ?int $supervisor_id = NULL) {
    $statement = self::getDatabase()->prepare("INSERT INTO library_staff (staff_id, role, supervisor_id) VALUES (:id, :role, :sid)");
    $statement->bindValue(':id', $id, \PDO::PARAM_INT);
    $statement->bindValue(':role', $role);
    $statement->bindValue(':sid', $supervisor_id, \PDO::PARAM_INT);
    return $statement->execute();
  }

  public static function getEmployeesByName(string $name) {
    $key = "%$name%";
    $statement = self::getDatabase()->prepare("SELECT e.role, u.user_id, u.name  
      FROM user u JOIN library_staff e ON u.user_id = e.staff_id 
      WHERE u.name LIKE :k");
    $statement->bindValue(':k', $key);
    $statement->execute();
    return $statement;
  }

  public static function getOneById(int $id) {
    $statement = self::getDatabase()->prepare("SELECT u.user_id, u.name, e.role
      FROM user u JOIN library_staff e ON u.user_id = e.staff_id AND e.staff_id = :id");
    $statement->bindValue(':id', $id, \PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(\PDO::FETCH_CLASS, Employee::class);
  }
  
  // Count the number of employees
  public static function count() {
    $statement = self::getDatabase()->query("SELECT count(*) FROM library_staff");
    return $statement->fetchColumn();
  }
}