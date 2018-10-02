<?php
use \Kernel\View;

class PageController{
	public function index(){
		return View::make('test');
	}

	public function laytest($message){
		return ['mess' => strtoupper($message)];
	}
}