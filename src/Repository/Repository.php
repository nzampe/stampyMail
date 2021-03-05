<?php

include_once('./src/Entity/User.php');
include_once('UserRepository.php');

class Repository {

    private $connection;

    public function __construct() {
        $connection = new Connection();
        $this->connection = $connection->getConnection();
    }

    public function getConnection() {
        return $this->connection;
    }
}