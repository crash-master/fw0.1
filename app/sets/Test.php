<?php

/*  Automatically was generated from a template fw/templates/set.php */

namespace Sets;

class TestSet extends \Extend\Set{

    public function tableName(){ 

        return 'Test'; 

    }

    public function defaultRows(){
        
        return [
            
            'date' => 'NOW()'
            
        ];
        
    }

}