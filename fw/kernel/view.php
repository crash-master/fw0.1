<?php
class View{
    private static $vars;
    private static $currentPage;

    public static function make($name,$arr = NULL,$varname = NULL){
        if(!is_array(self::$vars))
            self::$vars = [];

        if(!is_null($arr) and !is_null($varname))
            self::$vars[$varname] = $arr;
        elseif(!is_null($arr) and is_null($varname)){
            $names = @array_keys($arr);
            $count = count($names);
            if($count){
                self::$vars = array_merge(self::$vars,$arr);
            }
        }

        self::$currentPage = $name;
        return self::makeAndParse($name);
    }

    public static function getCurrentPage(){
        return self::$currentPage;
    }

    private static function makeAndParse($name){
        $page = './resources/view/'.$name.'.php';
        if(!file_exists($page)){
            if(file_exists($name.'.php')){
                $page = $name.'.php';
            }else
                return false;
        }
        ob_start();

        if(!is_null(self::$vars))
            extract(self::$vars);
        require_once($page);

        $res = ob_get_clean();
        return $res;
    }

    public static function join($name){
        $file = './resources/view/'.$name.'.php';
        if(!file_exists($file)){
            if(file_exists($name.'.php')){
                $file = $name.'.php';
            }else
                return false;
        }
        Components::callToAction($name);
        if(!is_null(self::$vars))
            extract(self::$vars);
        require_once($file);
        return true;
    }

    public static function json($arr){
        return json_encode($arr);
    }

    public static function css($params){
        return IncludeControll::cssInclude($params);
    }

    public static function js($params){
        return IncludeControll::jsInclude($params);
    }

    /**
     * [addVars for adding new vars]
     * @param [array] $arr [array like [$varname => value]]
     */
    public static function addVars($arr){
        self::$vars = array_merge(self::$vars, $arr);
    }

}

?>
