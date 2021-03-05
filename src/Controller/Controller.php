<?php

include_once('UserController.php');

class Controller {
    
    private $repository;
    
    public function json($data, $statusCode) {
        $response['data'] = $data;
        $response['statusCode'] = $statusCode;
        return json_encode($response);
}
}