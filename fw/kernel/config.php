<?php
namespace Kernel;

class Config{
    protected static $db;

    protected static function init(){
        self::$db = new Services\ArrayWrap('./fw/config/main.config.php', false);
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
