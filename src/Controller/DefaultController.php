<?php

class DefaultController {

    public static function home () {
        session_start();
        if(!empty($_SESSION['loggedIn'])){
            return UserController::index();
        }
        return View::getView('Login');
    }

}