<?php

/* PATH: app/sets/ */

namespace Sets;
use Kernel\{
	View,
	Model
};

class /*$setname*/Set extends \Extend\Set{

    public function tableName(){ 

        return '/*$tablename*/'; 

    }

    public function defaultRows(){
        
        return [
            
            'date' => 'NOW()'
            
        ];
        
    }

}