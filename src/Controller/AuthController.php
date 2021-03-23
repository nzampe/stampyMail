<?php

class AuthController {

    public static function login() {
        if(empty($_POST['username']) || empty($_POST['password'])) {
            echo ResponseController::json("Los campos 'username' y 'password' no pueden estar vacíos.", 400);
            die;
        }

        $username = $_POST['username'];
        $password = $_POST['password'];

        $result = UserController::login($username, $password);
        if(empty($result)) {
            echo ResponseController::json("Usuario y/o contraseña incorrecta.", 401);
            die;
        }

        $_SESSION['loggedIn'] = true;
        $_SESSION['id'] = $result['id'];
        $_SESSION['username'] = $result['username'];

        echo ResponseController::json("Logueo exitoso", 200);
        die;
    }

    public static function logout() {
        session_unset();
        session_destroy();
        header('Location: '.BASE_URL.'/default/home');
    }

}
