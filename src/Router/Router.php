<?php

session_start();

// Divido la url para obtener el controller y la funcion.
$url = !empty($_GET['url']) ? $_GET['url'] : 'default/home';
$urlExploded = explode("/",$url);
$nameController = ucfirst($urlExploded[0]).'Controller';
$action = !empty($urlExploded[1]) ? $urlExploded[1] : 'index' ;
$request = !empty($urlExploded[2]) ? $urlExploded[2] : '';

$file = 'src/controller/'.$nameController.'.php';

if(file_exists($file)){
    // Verifico que el usuario esté logueado para realizar cualquier acción.
    if(empty($_SESSION['loggedIn']) && $nameController !== 'AuthController'){
        return View::getView('Login');
    }
    require_once($file);
    if(method_exists($nameController,$action)){
        $nameController::{$action}($request);
    }
    else {
        return View::getView('Error', ['code' => 404, 'message' => 'Not found']);
    }
}
else {
    return View::getView('Error', ['code' => 404, 'message' => 'Not found']);
}