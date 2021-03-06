<?php

class ResponseController {

    /* public function __construct() {
        session_start();
        if(!isset($_SESSION['loggedIn'])){
            return View::getView('Login');
        }
    } */
    
    public static function json($data, $statusCode) {
        $response['data'] = $data;
        $response['statusCode'] = $statusCode;
        return json_encode($response);
}
}