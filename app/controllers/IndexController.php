<?php

class indexController extends \Extend\Controller{

    public function _404(){
        
        return View::make('default/404', ['url' => Router::getUrl()]);
        
    }

    public function poweredBy(){
        
        return View::make('default/hello');
        
    }

    public function hello_world(){
    	
    	return "Hello World";
    }
    
}

