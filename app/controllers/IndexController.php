<?php

class indexController extends \Extend\Controller{

    public function _404(){
        return View::make('default/404', ['url' => Router::getUrl()]);
    }

    public function index(){
        return View::make('default/hello');
    }
    
}

