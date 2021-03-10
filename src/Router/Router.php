<?php

$url = !empty($_GET['url']) ? $_GET['url'] : 'default/home';/** catching url */
$urlParts = explode("/",$url); /** url parts */
$controller = ucfirst($urlParts[0]).'Controller';/** controller */
$method = !empty($urlParts[1]) ? $urlParts[1] : 'index' ; /** verify that method exists in url*/
$params = !empty($urlParts[2]) ? $urlParts[2] : '';/** params */

$fileController = 'src/controller/'.$controller.'.php';

if(file_exists($fileController)){
    require_once($fileController);
    /** check controller method */
    if(method_exists($controller,$method)){
        $controller::{$method}($params);
    }
}