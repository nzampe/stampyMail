<?php

include_once('app/config/config.php');

class Connection {

    private static $connection;

    public static function getConnection() {
      try {
        if(!isset(self::$connection)){
          self::$connection = new PDO("mysql:host=".DB_HOST.";"."dbname=".DB_NAME, DB_USER, DB_PASS);
          self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
      } catch (Exception $e) {
        print "¡Error!: " . $e->getMessage();
        die();
      }
  }
}