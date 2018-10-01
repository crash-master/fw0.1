<?php
use Kernel\{
	Router,
	View
};

class IndexController extends \Extend\Controller{

    public function _404(){
        return View::make('default/404', ['url' => Router::getUrl()]);
    }

    public function index(){
        return View::make('default/hello');
    }

    public function test($t, $r){
    	return array_merge(\Kernel\Request::get(), [$t, $r]);
    }

    public function qwerty(){
    	return ['hell' => 123];
    }
    
}

