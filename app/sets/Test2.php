<?php

/*  Automatically was generated from a template fw/templates/set.php */

namespace Sets;

class Test2Set extends \Extend\Set{

    public function tableName(){ 

        return 'Test2'; 

    }

    public function defaultRows(){
        
        return [
            
            'date' => 'NOW()'
            
        ];
        
    }

}