<?php

class ResponseController {
    
    public static function json($data, $statusCode) {
        $response['data'] = $data;
        $response['statusCode'] = $statusCode;
        return json_encode($response);
}
}