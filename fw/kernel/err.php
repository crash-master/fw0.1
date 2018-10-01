<?php
namespace Kernel;

class Err{

//    Variables

    private static $errs;

//    Methods

    public static function add($section, $err){

        if(!is_array(self::$errs[$section]))
            self::$errs[$section] = [];

        self::$errs[$section] = (is_array($err)) ? array_merge(self::$errs[$section], $err) : array_merge(self::$errs[$section], [$err]);

        return true;

    }

    public static function get($section = false){

        if(!$section)
            return (!empty(self::$errs)) ? self::$errs : false;

        return (isset(self::$errs[$section])) ? self::$errs[$section] : false;

    }

    public static function any(){
        $arr = [];
        $count = count(self::$errs);
        if(!$count)
            return false;

        $sections = array_keys(self::$errs);
        for($i=0;$i<$count;$i++){
            $arr = array_merge($arr, self::$errs[$sections[$i]]);
        }

        return $arr;
    }

    public static function getSectionList(){
        if(!is_array(self::$errs))
            return false;

        $sections = @array_keys(self::$errs);
        return $sections ? $sections : false;
    }

    public static function count($section = false){
        if($section)
            return count(self::$errs[$section]);

        $res = 0;
        $count = count(self::$errs);
        $keys = array_keys(self::$errs);
        for($i=0;$i<$count;$i++){
            $res += count(self::$errs[$keys[$i]]);
        }

        return $res;
    }

    public static function log(){
        $sections = self::getSectionList();
        $count = count($sections);
        for($i=0;$i<$count;$i++){
            $count_errs = count(self::$errs[$sections[$i]]);
            for($j=0;$j<$count_errs;$j++){
                Log::add($sections[$i], self::$errs[$sections[$i]][$j]);
            }   
        }

        return false;
    }

}

