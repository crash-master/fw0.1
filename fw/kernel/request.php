<?php
namespace Kernel;

class Request{
    
    private static $urlTemp;
    
    public static function setUrlTemp($urlTemp){
        
        self::$urlTemp = $urlTemp;
        
    }
    
    public static function getArgs(){
        
        $url = explode('/',self::getUrl());

        $uri = explode('/',self::$urlTemp);
        
        if(!(strstr(self::$urlTemp, '{') and strstr(self::$urlTemp,'}')))
            return false;
        
        $count = count($url);
        
        for($i=0;$i<$count;$i++){
            
            if(!(strstr($uri[$i], '{') and strstr($uri[$i],'}')))
               continue;
               
               $name = explode('{',$uri[$i]);
               
               list($name) = explode('}',$name[1]);
            
               $vars[$name] = $url[$i];
            
        }
               
        return $vars;
        
    }
    
    public static function getAll(){
        return $_GET;
    }
    
    public static function postAll(){
        return $_POST;
    }
    
    public static function getUrl(){
        return $_SERVER['REQUEST_URI'];
    }
    
    private static function fromUrl($item){
        
        $url = explode('/',self::getUrl());
        
        return urldecode($url[$item]);
        
    }
    
    public static function get($params = false){
        if(!$params) return self::getAll();
        
        if(is_int($params))
            return self::fromUrl($params);
        
        if(is_array($params)){
            $res = array();
            $count = count($params);
            for($i=0;$i<$count;$i++){
                if(isset($_GET[$params[$i]])){
                    $res[$params[$i]] = $_GET[$params[$i]];
                }
            }
            return $res;
        }
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
?>