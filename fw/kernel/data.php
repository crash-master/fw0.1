<?php

class Data{
    
    // Variables
    
    protected static $db;
    
    
    // Methods 
    
    public static function init(){

        self::$db = new JSONDB(Config::get('system -> path -> dataJSON'));

    }
    
    public static function get($path){

        if(!self::$db)
            self::init();

        return self::$db -> get($path);

    }

    public static function set($path, $val){

        if(!self::$db)
            self::init();

        return self::$db -> set($path,$val);

    }

    public static function del($path){

        return self::$db -> del($path);

    }

    public static function dump(){

        self::$db -> dump();

    }
    
}