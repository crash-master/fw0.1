<?php

class Module{
    
    public static $modules;
    
    public static function register($name){
        
        if(isset(self::$modules[$name])){
            
            Err::add('ERR Module', "Module with the name '{$name}' already exists");
            
            return false;
            
        }
        
        $classname = $name;
        
        $name = '\\Modules\\' . $name;
        
        self::$modules[$classname] = new $name();
        
    }
    
    public static function includesAllModules(){
        
        $dirs = Config::get('system -> modules');
        
        $count = count($dirs);
        
        for($i=0;$i<$count;$i++){
            
            $pathToIndex = 'fw/modules/'.$dirs[$i].'/index.php';
            
            if(!file_exists($pathToIndex)){
                
                Err::add('ERR Module', "In module '{$dirs[$i]}' not exists file index.php");
                
                continue;
                
            }
        
            include_once($pathToIndex);

        }
        
        return true;
        
    }
    
    public static function pathToModulesDir(){
        
        return 'fw/modules/';
        
    }
    
    public static function pathToModule($name){
        
        return self::pathToModulesDir() . $name . '/';
        
    }
    
    public static function get($name){
        
        return self::$modules[$name];
        
    }
    
}