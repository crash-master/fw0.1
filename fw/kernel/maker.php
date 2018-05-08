<?php
namespace Kernel;

class Maker{
    public static $params;

    public static function setMigration($params = NULL){
        if(Config::get('system -> migration') != "on"){
            Err::add('Maker', 'Migration set to off in fw/config/main.config.php');
            return false;
        }

        if(is_null($params)){
            $params = self::$params;
        }
        include_once('app/migrations/'.$params[1].'Migration.php');
        @call_user_func(array($params[1].'Migration','up'));
        
        Log::add('Maker', "Set migration '{$params[1]}'");
        
        CodeTemplate::create('set', ['tablename' => $params[1], 'setname' => $params[1], 'filename' => $params[1]]);

        CodeTemplate::create('model', ['modelname' => $params[1], 'setname' => $params[1], 'filename' => $params[1]]);

        return true;
    }

    // public static function cleanMigrations(){
    //     if(Config::get('system -> migration') != "on"){
    //         Err::add('Maker', 'Migration set to off in fw/config/main.config.php');
    //         return false;
    //     }

    //     $arr = IncludeControll::scan('app/migrations/');
    //     $migs = Data::get('system -> migrationUpdate_at');
    //     $keys = @array_keys($migs);
    //     $count = count($keys);
    //     $count_arr = count($arr);

    //     for($i=0;$i<$count_arr;$i++){
    //         list($arr[$i]) = explode('Migration.php',basename($arr[$i]));
    //     }

    //     for($i=0;$i<$count;$i++){
    //         $f = false;
    //         for($k=0;$k<$count_arr;$k++){
    //             if($keys[$i] == $arr[$k]){
    //                 $f = true;
    //                 break;
    //             }
    //         }
    //         if(!$f){
    //             DBW::drop($keys[$i]);
    //             unset($migs[$keys[$i]]);
    //         }
    //     }
    //     Data::set('system -> migrationUpdate_at',$migs);
    //     return true;
    // }

    // public static function cleanMigrations(){
    //     if(Config::get('system -> migration') != "on"){
    //         Err::add('Maker', 'Migration set to off in fw/config/main.config.php');
    //         return false;
    //     }

    //     $arr = IncludeControll::scan('app/migrations/');
    //     $count = count($arr);

    //     for($i=0;$i<$count;$i++){
    //         list($classname) = explode('Migration.php', basename($arr[$i]));
    //         DBW::drop($classname);
    //         Log::add('Maker', "Unset migration '{$classname}'");
    //     }

    //     return true;
    // }

    public static function setAllMigration(){
        $arr = IncludeControll::scan('app/migrations/');
        $count = count($arr);
        for($i=0;$i<$count;$i++){
            $tmp = explode('Migration.php',basename($arr[$i]));
            self::setMigration(array(1=>$tmp[0]));
        }
        return true;
    }

    public static function unsetMigration($params = NULL){
        if(Config::get('system -> migration') != "on"){
            Err::add('Maker', 'Migration set to off in fw/config/main.config.php');
            return false;
        }

        if(is_null($params)){
            $params = self::$params;
        }
        include_once('app/migrations/'.$params[1].'Migration.php');
        @call_user_func(array($params[1].'Migration','down'));

        Log::add('Maker', "Unset migration '{$params[1]}'");

        return true;
    }

    public static function unsetAllMigration(){
        $arr = IncludeControll::scan('app/migrations/');
        $count = count($arr);
        for($i=0;$i<$count;$i++){
            $tmp = explode('Migration.php',basename($arr[$i]));
            self::unsetMigration(array(1=>$tmp[0]));
        }
        return true;
    }

    public static function refreshMigration(){
        if(self::unsetAllMigration() and self::setAllMigration()){
            return true;
        }
        return false;
    }

}
