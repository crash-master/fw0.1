<?php
namespace test;
use Kernel\View;

class IndexController extends \Extend\Controller{

    public function menu(){
        return ['item_name' => 'Item'];
    }

    public function site(){
    	return View::make('site');
    }
    
}

