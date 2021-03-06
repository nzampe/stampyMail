<?php

class AuthController {

    public static function login() {
        if(empty($_POST['username']) || empty($_POST['password'])) {
            return $this->json("Los campos 'username' y 'password' no pueden estar vacíos.", 400);
        }
        $username = $_POST['username'];
        $password = $_POST['password'];

        $userController = new UserController();
        $user = $userController->find($username, $password);
        if(!$user) {
            return $this->json("Usuario y/o contraseña incorrecta.", 401);
        }

        $_SESSION['loggedIn'] = true;
        $_SESSION['id'] = $user->getId();
        $_SESSION['username'] = $user->getUsername();

        return $this->json("Logueo exitoso", 200);

    }

    public static function logout() {
        session_unset();
        session_destroy();
        return View::getView('Login');
    }

}