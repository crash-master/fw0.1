<?php
namespace Kernel;

class Request{
    private static $urlTemp;
    private static $args;
    private static $url;

    public static function getArgs($urlTemp){
        self::$urlTemp = $urlTemp; 
        $url = explode('/',self::getUrl());
        $uri = explode('/',self::$urlTemp); 
        
        $count = count($url);
        for($i=0;$i<$count;$i++){
            if(strpos($uri[$i], '{') === false)
               continue;
               
               $name = explode('{',$uri[$i]);
               list($name) = explode('}',$name[1]);
               $vars[$name] = $url[$i];
        }
            
        self::$args = $vars;
        return $vars;
    }
    
    public static function getAll(){
        return $_GET;
    }
    
    public static function postAll(){
        return $_POST;
    }

    public static function ParseURLModRewrite(){
        $url = $_SERVER['REQUEST_URI'];
        if(strpos($url, '?') !== false){
            list($url) = explode('?', $url);
        }
        $len = strlen($url);
        if($url[$len - 1] == '/' and $len > 1){
            $url = substr($url,0,$len - 1);
        }

        self::$url = $url;
        return $url;
    }

    public static function getUrl(){
        return empty(self::$url) ? self::ParseURLModRewrite() : self::$url;
    }
    
    private static function fromUrl($item){
        $url = explode('/',self::getUrl());
        return urldecode($url[$item]);
    }
    
    public static function get($params = false){
        if(!$params) return self::getAll();
        return $_GET[$params];
    }
    
    public static function post($params = false){
        if(!$params) return self::postAll();
        
        if(is_array($params)){
            $res = array();
            $count = count($params);
            for($i=0;$i<$count;$i++){
                if(isset($_POST[$params[$i]])){
                    $res[$params[$i]] = $_POST[$params[$i]];
                }
            }
            return $res;
        }
        return $_POST[$params];
    }
    
    public static function clearGET(){
        $keys = array_keys($_GET);
        $count = count($_GET);
        for($i=0;$i<$count;$i++){
            $_GET[$keys[$i]] = trim(strip_tags($_GET[$keys[$i]]));
        }
        return true;
    }
    
    public static function clearPOST(){
        $keys = array_keys($_POST);
        $count = count($_POST);
        for($i=0;$i<$count;$i++){
            $_POST[$keys[$i]] = trim(strip_tags($_POST[$keys[$i]]));
        }
        return true;
    }
    
    public static function clear(){
        return self::clearGET() and self::clearPOST();
    }
}