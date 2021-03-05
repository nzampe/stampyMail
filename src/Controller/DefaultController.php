<?php

class DefaultController extends Controller {

    public function home () {
        if(isset($_SESSION['loggedIn'])){
            return View::getView('Home');
        }
        return View::getView('Login');
    }

}