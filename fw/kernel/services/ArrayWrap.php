<?php
namespace Kernel\Services;

class ArrayWrap{

    private $data;
    private $config;
    private $path;
    public $lang;
    
    public function __construct($path, $json = true){
        $this -> init($path, $json);
        $this -> lang = $json ? 'json' : 'php';
        $this -> path = $path;
    }

    public function init($path, $json){
        $this -> data = $json ? json_decode(file_get_contents($path),true) : require_once($path);
        return false;
    }

    private function getPart($arr,$partName){
        return $arr[$partName];
    }

    public function get($name){
        if(strstr($name,'->')){
            $part = explode('->',$name);
            $count = count($part);
            $res = $this -> data;
            for($i=0;$i<$count;$i++){
                $res = $this -> getPart($res,trim($part[$i]));
            }

            return $res;
        }

        return $this -> data[$name];
    }
    
    public function getDataArray(){
        return $this -> data;
    }
    
    public function dump(){
        
//        return file_put_contents(Config::get('system -> path -> dataJSON'),decompressJSON(json_encode($this -> data)));
        return file_put_contents($this -> path,json_encode($this -> data));
        
    }
    
    private function toPath($arr,$name,$val){
        $part = explode('->',$name);
        $count = count($part);

        $result = $val;

        for($i = $count-1;$i > 0;$i--){
            $result = $this -> setPart(trim($part[$i]),$result);
        }

        $part[0] = trim($part[0]);

        if(isset($arr[$part[0]]))
            $arr[$part[0]] = @array_merge($arr[$part[0]],$result);
        else
            $arr[$part[0]] = $result;
        
        return $arr;
    }
    
    private function setPart($partName,$val){
        $arr = array();
        $arr[$partName] = $val;
        return $arr;
    }
    
    public function set($name,$val){
        
        if(strpos($name,'->') !== false){
            $this -> data = $this -> toPath($this -> data,$name,$val);
            return true;
        }

        $this -> data[$name] = $val;
        
        return true;
    }
    
    public function del($path){
        $this -> set($path, NULL);
        return true;
    }

}