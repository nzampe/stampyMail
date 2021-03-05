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
$result = $userController->delete(16);
  var_dump($result);die;

/* $request['username'] = "asd";
$request['password'] = "asdas";
$request['firstName'] = "123";
$request['lastName'] = "true"; 
$request['email'] = "asd@asd.com"; 
$request['dni'] = "12312123"; 
$result = json_decode($userController->new($request), true);
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