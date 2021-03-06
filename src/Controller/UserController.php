<?php

include_once('./src/Repository/UserRepository.php');

class UserController {

    public static function index() {
        try {
            $data = UserRepository::findAll();
            return $data;
            return $this->view->getView('Home', ['users' => $data]);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function add($request) {
        try {
            $errors = $this->validNewUser($request);
            if(count($errors) > 0) return ResponseController::json($errors, 400);
            $user = new User(
                null,
                trim($request['username']),
                trim($request['password']),
                trim($request['firstName']), 
                trim($request['lastName']), 
                trim($request['email']), 
                trim($request['dni']), 
                new \DateTime('NOW'), 
                new \DateTime('NOW')
            );
            $result = UserRepository::create($user);
            if($result){
                $message = "El usuario ha sido guardado correctamente.";
                $statusCode = 200;
            }
            else{
                $message = "Ha ocurrido un error al guardar el usuario.";
                $statusCode = 500;
            }
            // return $this->respond();
        } catch (\Throwable $th) {
            $message = "Ha ocurrido un error al guardar el usuario.";
            $statusCode = 500;
            return ResponseController::json($message, $statusCode);
        }
        return ResponseController::json($message, $statusCode);
    }

    public static function edit($request) {
        try {
            $errors = self::validUser($request);
            if(count($errors) > 0) return ResponseController::json($errors, 400);
            $user = new User(
                null,
                trim($request['id']),
                trim($request['username']),
                trim($request['password']),
                trim($request['firstName']), 
                trim($request['lastName']), 
                trim($request['email']), 
                trim($request['dni']), 
                new \DateTime('NOW'), 
                new \DateTime('NOW')
            );
            $result = UserRepository::update($user, $request);
            if($result){
                $message = "El usuario {$request['id']} ha sido editado correctamente.";
                $statusCode = 200;
            }
            else{
                $message = "Ha ocurrido un error al editar el usuario {$request['id']}.";
                $statusCode = 500;
            }
            // return $this->respond();
        } catch (\Throwable $th) {
            $message = "Ha ocurrido un error al editar el usuario.";
            $statusCode = 500;
            return ResponseController::json($message, $statusCode);
        }
        return ResponseController::json($message, $statusCode);
    }

    public static function delete($id) {
        try{
            if(empty($id)){
                return ResponseController::json("El campo 'id' es requerido.", 400);
            }
            $result = UserRepository::delete($id);
            if($result){
                $message = "El usuario {$id} se ha eliminado correctamente.";
                $statusCode = 200;
            }
            else{
                $message = "No se ha podido eliminar el usuario {$id}.";
                $statusCode = 500;
            }
            // return $this->respond();
        } catch (\Throwable $th) {
            $message = "Ha ocurrido un error al momento de verificar si el usuario existe.";
            $statusCode = 500;
            return ResponseController::json($message, $statusCode);
        }
        return ResponseController::json($message, $statusCode);
    }

    public static function exists($username) {
        try {
            if(empty($username)){
                return ResponseController::json("El campo 'username' es requerido.", 400);
            }
            $result = UserRepository::exists($username);
            if($result){
                $message = "El usuario {$username} ya se encuentra en el sistema.";
                $statusCode = 200;
            }
            else{
                $message = "El usuario {$username} no se encuentra en el sistema.";
                $statusCode = 500;
            }
            // return $this->respond();
        } catch (\Throwable $th) {
            $message = "Ha ocurrido un error al momento de verificar si el usuario existe.";
            $statusCode = 500;
            return ResponseController::json($message, $statusCode);
        }
        return ResponseController::json($message, $statusCode);
    }

    public static function validUser($request) {
        $errors = [];

        if(empty($request['username'])){
            $errors[] = "El campo 'username' no puede ser vacío.";
        }
        else if(!is_string($request['username'])){
            $errors[] = "El campo 'username' debe ser de tipo string.";
        }
        else if(strlen($request['username']) > 20){
            $errors[] = "El campo 'username' no debe superar los 20 carácteres.";
        }

        if(empty($request['password'])){
            $errors[] = "El campo 'password' no puede ser vacío.";
        }
        else if(!is_string($request['password'])){
            $errors[] = "El campo 'password' debe ser de tipo string.";
        }
        else if(strlen($request['password']) > 20){
            $errors[] = "El campo 'password' no debe superar los 20 carácteres.";
        }

        if(empty($request['firstName'])){
            $errors[] = "El campo 'firstName' no puede ser vacío.";
        }
        else if(!is_string($request['firstName'])){
            $errors[] = "El campo 'firstName' debe ser de tipo string.";
        }
        else if(strlen($request['firstName']) > 50){
            $errors[] = "El campo 'firstName' no debe superar los 50 carácteres.";
        }

        if(empty($request['lastName'])){
            $errors[] = "El campo 'lastName' no puede ser vacío.";
        }
        else if(!is_string($request['lastName'])){
            $errors[] = "El campo 'lastName' debe ser de tipo string.";
        }
        else if(strlen($request['lastName']) > 50){
            $errors[] = "El campo 'lastName' no debe superar los 50 carácteres.";
        }

        if(empty($request['email'])){
            $errors[] = "El campo 'email' no puede ser vacío.";
        }
        else if(!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
            echo "La dirección de correo es inválida.";
        }
        else if(strlen($request['email']) > 50){
            $errors[] = "El campo 'email' no debe superar los 50 carácteres.";
        }

        if(empty($request['dni'])){
            $errors[] = "El campo 'dni' no puede ser vacío.";
        }
        else if(!is_string($request['dni'])){
            $errors[] = "El campo 'dni' debe ser de tipo string.";
        }
        else if(strlen($request['dni']) > 8){
            $errors[] = "El campo 'dni' no debe superar los 8 carácteres.";
        }

        return $errors;
    }
}