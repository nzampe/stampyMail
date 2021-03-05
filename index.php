<?php
/** Configurations and connections */
include_once('app/config/config.php');
include_once('app/config/database/Connection.php');

include_once('src/Controller/Controller.php');
include_once('src/Repository/Repository.php');

/* $connection = new Connection();
$connection = $connection->getConnection(); */
$userController = new UserController();


/* $result = $userController->findAll();
foreach ($result as $key => $value) {
  var_dump($value->getId());die;
} */
$request['id'] = 9;
$request['username'] = "EDI3";
$request['password'] = "asd";
$request['firstName'] = "E2";
$request['lastName'] = "ED22"; 
$request['email'] = "e2dt@e2dit.com"; 
$request['dni'] = "0000"; 
$today = new \DateTime('NOW');
$request['updatedAt'] = $today->format('Y-m-d H:m:s');
$result = $userController->edit($request);
  var_dump($result);die;

/* $result = json_decode($userController->new($request), true);
if($result) {
  var_dump($result['data']);die;
} */

// $users = json_decode($userController->findAll(), true);
/* $users = $userController->findAll();
foreach ($users as $value) {
  var_dump($value->getFirstName());
} */

/* foreach ($connection->query("SELECT * FROM USER") as $value) {
  var_dump($value);
} */