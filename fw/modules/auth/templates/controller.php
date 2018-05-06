<?php

/* PATH: app/controllers/ */

class /*$name*/Controller extends \Extend\Controller{
    
    public function login(){

        Request::post() and model('User') -> login('/');

        return View::make(Module::pathToModule('auth').'view/login');

    }

    public function logout(){

        return model('User') -> logout('/');

    }

    public function signup(){

        Request::post() and model('User') -> signup();

        return View::make(Module::pathToModule('auth').'view/signup');

    }
    
}