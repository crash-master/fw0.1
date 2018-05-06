<?php

class Model{
    
    private static $data;
    
    public static function register($name){
        
        if(!isset(self::$data[$name])){
            
            self::$data[$name] = new $name();
            
        }
        
        return self::$data[$name];
        
    }
    
    public static function getRegisteredList(){
        
        return array_keys(self::$data);
        
    }
    
    public static function get($name){
        
        return self::$data[$name];
        
    }
    
}