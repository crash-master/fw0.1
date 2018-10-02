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

    public function testWork_controller_routing($t, $r){
        $t = str_replace(' ', '', ucwords(str_replace('-', ' ', $t)));

        // controller name route string
        $t = str_replace('Controller', '', $t);
        $t = strtolower(preg_replace('/(?<=\\w)(?=[A-Z])/', "-$1", $t));

        // action name to route string
        $r = str_replace('_', ' ', $r);
        $r = ucwords($r);
        $r = str_replace(' ', '', $r);
        $r = str_replace('Action', '', $r);
        $r = strtolower(preg_replace('/(?<=\\w)(?=[A-Z])/', "-$1", $r));


    	return array_merge(\Kernel\Request::get(), [$t, $r]);
    }

    public function qwerty(){
    	return ['hell' => 123];
    }
    
}

