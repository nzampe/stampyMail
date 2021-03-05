<?php

class Connection {

    private $connection;

    function getConnection() {
      try {
        if(!isset($this->connection)){
          $this->connection = new PDO("mysql:host=".DB_HOST.";"."dbname=".DB_NAME, DB_USER, DB_PASS);
          $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $this->connection;
      } catch (Exception $e) {
        print "¡Error!: " . $e->getMessage();
        die();
      }
  }
}