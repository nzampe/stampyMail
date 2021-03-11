<?php

include_once('./src/Repository/UserRepository.php');

class UserController {

    public static function index() {
        try {
            $data = UserRepository::findAll();
            return View::getView('Home', ['users' => $data]);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function formUser($id = null) {
        if(isset($id)){
            $user = UserRepository::find($id);
            return View::getView('FormUser', ['user' => $user]);
        }
        return View::getView('FormUser');
    }

    public static function add() {
        try {
            $request = array(
                'username' => $_POST['username'] ?? null,
                'password' => $_POST['password'] ? $_POST['password'] : null,
                'firstName' => $_POST['firstName'] ?? null,
                'lastName' => $_POST['lastName'] ?? null,
                'email' => $_POST['email'] ?? null,
                'dni' => $_POST['dni'] ?? null,
                'createdAt' => (new \DateTime())->format('Y-m-d'),
                'updatedAt' => (new \DateTime())->format('Y-m-d'),
            );
            $errors = self::validUser($request);
            if(count($errors) > 0) {
                echo ResponseController::json($errors, 400);
                die;
            }
            if(UserRepository::exists($_POST['username'])) {
                $message = "Ese usuario ya existe en el sistema.";
                $statusCode = 400;
                echo ResponseController::json($message, $statusCode);die;
            }
            $result = UserRepository::create($request);
            if($result){
                $message = "El usuario ha sido guardado correctamente.";
                $statusCode = 200;
            }
            else{
                $message = "Ha ocurrido un error al guardar el usuario.";
                $statusCode = 500;
            }
        } catch (\Throwable $th) {
            $message = "Ha ocurrido un error al guardar el usuario.";
            $statusCode = 500;
            echo ResponseController::json($message, $statusCode);die;
        }
        echo ResponseController::json($message, $statusCode);die;
    }

    public static function edit() {
        try {
            $request = array(
                'id' => $_POST['id'] ?? null,
                'firstName' => $_POST['firstName'] ?? null,
                'lastName' => $_POST['lastName'] ?? null,
                'username' => $_POST['username'] ?? null,
                'password' => $_POST['password'] ? $_POST['password'] : null,
                'email' => $_POST['email'] ?? null,
                'dni' => $_POST['dni'] ?? null,
                'updatedAt' => (new \DateTime())->format('Y-m-d'),
            );

            $errors = self::validUser($request);

            $user = UserRepository::find($_POST['id']);
            if(UserRepository::exists($_POST['username']) && $_POST['username'] !== $user['username']) {
                $message = "Ese usuario ya existe en el sistema.";
                $statusCode = 400;
                echo ResponseController::json($message, $statusCode);die;
            }
            if(count($errors) > 0) {
                echo ResponseController::json($errors[0], 400);
                die;
            }
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
            $result = UserRepository::update($user, $request);
            if($result){
                $message = "El usuario {$request['id']} ha sido editado correctamente.";
                $statusCode = 200;
            }
            else{
                $message = "Ha ocurrido un error al editar el usuario {$request['id']}.";
                $statusCode = 500;
            }
        } catch (\Throwable $th) {
            $message = "Ha ocurrido un error al editar el usuario.";
            $statusCode = 500;
            echo ResponseController::json($message, $statusCode);die;
        }
        echo ResponseController::json($message, $statusCode);die;
    }

    public static function delete() {
        try{
            isset($_POST['id']) ? $id = $_POST['id'] : $id = '';
            if(empty($id)){
                echo ResponseController::json("El campo 'id' es requerido.", 400);die;
            }
            UserRepository::delete($id);
            $message = "El usuario {$id} se ha eliminado correctamente.";
            $statusCode = 200;
        } catch (\Throwable $th) {
            $message = "Ha ocurrido un error al momento de verificar si el usuario existe.";
            $statusCode = 500;
            echo ResponseController::json($message, $statusCode);die;
        }
        echo ResponseController::json($message, $statusCode);die;
    }

    public static function login($username, $password) {
        try {
            $result = UserRepository::login($username, $password);
            return $result;
        } catch (\Throwable $th) {
            $message = "Ha ocurrido un error al momento de verificar si el usuario existe.";
            $statusCode = 500;
            return ResponseController::json($message, $statusCode);
        }
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
        } catch (\Throwable $th) {
            $message = "Ha ocurrido un error al momento de verificar si el usuario existe.";
            $statusCode = 500;
            return ResponseController::json($message, $statusCode);
        }
        return ResponseController::json($message, $statusCode);
    }

    public static function validUser($request) {
        $errors = [];
        foreach ($request as $key => $value) {
            if(empty($request[$key])){
                $errors[] = "El campo ${key} no puede ser vacío.";
                return $errors;
            }
        }
        if(!is_string($request['username'])){
            $errors[] = "El campo 'username' debe ser de tipo string.";
        }
        else if(strlen($request['username']) > 20){
            $errors[] = "El campo 'username' no debe superar los 20 carácteres.";
        }
        if(!is_string($request['password'])){
            $errors[] = "El campo 'password' debe ser de tipo string.";
        }
        else if(strlen($request['password']) > 20){
            $errors[] = "El campo 'password' no debe superar los 20 carácteres.";
        }
        if(!is_string($request['firstName'])){
            $errors[] = "El campo 'firstName' debe ser de tipo string.";
        }
        else if(strlen($request['firstName']) > 50){
            $errors[] = "El campo 'firstName' no debe superar los 50 carácteres.";
        }
        if(!is_string($request['lastName'])){
            $errors[] = "El campo 'lastName' debe ser de tipo string.";
        }
        else if(strlen($request['lastName']) > 50){
            $errors[] = "El campo 'lastName' no debe superar los 50 carácteres.";
        }

        if(!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "La dirección de correo es inválida.";
        }
        else if(strlen($request['email']) > 50){
            $errors[] = "El campo 'email' no debe superar los 50 carácteres.";
        }

        if(!is_numeric($request['dni'])){
            $errors[] = "El campo 'dni' debe ser de tipo numérico.";
        }
        else if(strlen($request['dni']) > 8){
            $errors[] = "El campo 'dni' no debe superar los 8 carácteres.";
        }

        return $errors;
    }
}