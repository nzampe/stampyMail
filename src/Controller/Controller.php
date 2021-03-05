<?php

include_once('UserController.php');
include_once('DefaultController.php');

class Controller {
    
    private $repository;

    public function __construct() {
        /* session_start();
        if(!isset($_SESSION['loggedIn'])){
            return View::getView('Login');
        } */
    }
    
    public function json($data, $statusCode) {
        $response['data'] = $data;
        $response['statusCode'] = $statusCode;
        return json_encode($response);
}
}