<?php
namespace Kernel;

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

    private static function searchFile($name){
        list($rootDir, $secondDir) = explode('/', $name);
        if($rootDir == 'fw' && $secondDir == 'modules'){
            if(file_exists($name)){
                return $name;
            }else{
                if(file_exists($name.'.php')){
                    return $name.'.php';
                }
            }
        }

        $dirList = ['./resources/view/'];
        $packages = PackageControll::getPackageList();
        $count = count($packages['path']);
        for($i=0;$i<$count;$i++){
            $dirList[] = $packages['path'][$i] . '/resources/view/';
        }

        $count = count($dirList);
        for($i=0;$i<$count;$i++){
            $file = $dirList[$i].$name;
            if(file_exists($file)){
                return $file;
            }else{
                if(file_exists($file.'.php')){
                    return $file.'.php';
                }
            }
        }

        return false;
    }

    private static function makeAndParse($name){
        $file = self::searchFile($name);
        if(!$file)
            return false;

        Events::register('before_rendered_page', [
            'file' => $file,
            'vars' => self::$vars
        ]);

        ob_start();
        if(!is_null(self::$vars))
            extract(self::$vars);

        require_once($file);

        $res = ob_get_clean();
        return $res;
    }

    public static function join($name){
        $file = self::searchFile($name);
        if(!$file) return false;
        Events::register('before_rendered_layout', [
            'file' => $file,
            'name' => $name
        ]);
        Components::callToAction($name);
        if(!is_null(self::$vars))
            extract(self::$vars);
        require_once($file);
        Events::register('after_rendered_layout', [
            'file' => $file,
            'name' => $name
        ]);
        return true;
    }

    public static function json($arr){
        return json_encode($arr);
    }

    public static function css($params){
        $list = IncludeControll::fileList($params);
        $path = '/resources/css/';

        $count = count($list);
        $res = '';
        for($i=0;$i<$count;$i++){
            if(!strstr($list[$i],'.css'))
                $list[$i] .= '.css';
            if(file_exists('.'.$path.$list[$i])){
                $list[$i] = $path.$list[$i];
            }

            $res .= '<link type="text/css" rel="stylesheet" href="'.$list[$i].'">';
        }
        return $res;
    }

    public static function js($params){
        $list = IncludeControll::fileList($params);
        $path = '/resources/js/';

        $count = count($list);
        $res = '';
        for($i=0;$i<$count;$i++){
            if(!strstr($list[$i],'.js'))
                $list[$i] .= '.js';

            if(file_exists('.'.$path.$list[$i])){
                $list[$i] = $path.$list[$i];
            }
                
            $res .= '<script type="text/javascript" src="'.$list[$i].'"></script>';
        }
        return $res;
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
