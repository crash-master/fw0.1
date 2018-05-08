<?php

/* PATH: app/models/ */
use Kernel\{
	View,
	Model
};

class /*$modelname*/ extends \Extend\Model{

    public $sets;

    public function __construct(){

        $this -> sets = new \Sets\/*$setname*/Set;

    }

}
