<?php

/*  Automatically was generated from a template fw/templates/set.php */

namespace Sets;

class Test1Set extends \Extend\Set{

    public function tableName(){ 

        return 'Test1'; 

    }

    public function defaultRows(){
        
        return [
            
            'date' => 'NOW()'
            
        ];
        
    }

}