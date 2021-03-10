<?php

class DefaultController {

    public static function home () {
        if(!empty($_SESSION['loggedIn'])){
            return UserController::index();
        }
        return View::getView('Login');
    }

}