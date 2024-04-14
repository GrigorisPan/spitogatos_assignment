<?php

namespace Framework;

use PDO, PDOException, Exception;

class Database
{
  public $conn;

  /**
   * Constructor for Database class
   * 
   * @param array $config
   */

  public function __construct($config)
  {
    // Connection string (DSN)
    $dns =  "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};";

    //Set PDO to throw excepions on error
    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ];

    try {
      //Create PDO instance
      $this->conn = new PDO($dns, $config['username'], $config['password'], $options);

      //echo 'Datebase connected';
    } catch (PDOException $e) {

      //If there is an error with connection, catch it here
      throw new Exception("Database conection failed: {$e->getMessage()}");
    }
  }

  public function query($query, $params = [])
  {
    try {
      // Prepare the statement
      $stmt = $this->conn->prepare($query);

      foreach ($params as $param => $value) {
        $stmt->bindValue(':' . $param, $value);
      }
      // Execute the statement
      $stmt->execute();

      // Return the results
      return $stmt;
    } catch (PDOException $e) {
      throw new Exception("Query failed to execute: {$e->getMessage()}");
    }
  }

  public function lastInsertId()
  {
    try {
      // Prepare the statement
      $last = $this->conn->lastInsertId();

      // Return the results
      return $last;
    } catch (PDOException $e) {
      throw new Exception("Query failed to execute: {$e->getMessage()}");
    }
  }
}
