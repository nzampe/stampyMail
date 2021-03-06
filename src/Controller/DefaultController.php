<?php

class DefaultController {

    public static function home () {
        if(isset($_SESSION['loggedIn'])){
            return View::getView('Home');
        }
        return View::getView('Login');
    }

}