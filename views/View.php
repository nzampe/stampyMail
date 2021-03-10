<?php

class View {

    public static function getView($view, $data = []) {
        require_once('views/'.$view.'.php');
    }
}