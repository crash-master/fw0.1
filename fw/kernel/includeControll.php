<?php
class IncludeControll{
    public static $dirs;
    public static $listTheInclude;

    public static function scan($path){
        $dir = scandir($path);
        $count = count($dir);
        $files = array();
        for($i=0;$i<$count;$i++){
            if($dir[$i] == '.' or $dir[$i] == '..' or !strstr($dir[$i],'.'))
                continue;
            $files[] = $path.$dir[$i];
        }
        return $files;
    }

    public static function core(){
        $files = array_merge(
            self::scan('./fw/kernel/'),
            self::scan('./fw/extend/'),
            
            self::scan('./app/'),
            self::scan('./app/sets/'),
            self::scan('./app/migrations/')
        );

        return self::inc($files);
    }

    public static function modules(){
        
        spl_autoload_register(function($class){

            $class = explode("\\", $class);

            $class = $class[count($class) - 1];

            $class = Module::pathToModulesDir() . $class . '/' . $class . '.php';

            if(file_exists($class)){

                include_once($class);

                return true;

            }

            return false;

        });
        
    }

    private static function inc($files){
        $count = count($files);
        for($i=0;$i<$count;$i++){
            include_once($files[$i]);
        }
        return true;
    }

    private static function getClassNamesFromFiles($files){
        $count = count($files);
        $sepword = 'class';
        $names = array();
        for($i=0;$i<$count;$i++){
            $f = file_get_contents($files[$i]);
            $f = explode($sepword,$f);
            $countf = count($f);
            for($k = 1;$k<$countf;$k++){
                $name = explode('{',$f[$k]);
                if(strstr($name[0], 'extends'))
                    $name = explode('extends', $name[0]);
                $names[] = trim($name[0]);
            }
        }

        return $names;
    }

    public static function customAuto(){
        self::$dirs = array(
            './app/models/',
            './app/controllers/'
        );

        spl_autoload_register(function ($class){
            
            $dirs = array(
                './app/models/',
                './app/controllers/'
            );
            
            $count = count($dirs);
            
            for($i=0;$i<$count;$i++){
                
                $path = $dirs[$i] . $class . '.php';
            
                if(file_exists($path)){
                    
                    include_once($path);
                    
                    return true;
                    
                }
                
            }
            
            return false;
            
        });

    }
    
    public static function migrationsUp(){
        Maker::cleanMigrations();
        Maker::setAllMigration();
    }

    private static function fileList($arr){
        $page = View::getCurrentPage();
        $list = array();
        if(is_array($arr['*']))
            $list = $arr['*'];
        else
            $list[] = $arr['*'];

        if(!is_null($page) and !empty($page) and isset($arr[$page])){
            if(is_array($arr[$page]))
                $list = array_merge($list,$arr[$page]);
            else
                $list[] = $arr[$page];
        }

        return $list;
    }

    public static function cssInclude($arr){
        $list = self::fileList($arr);
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

    public static function jsInclude($arr){
        $list = self::fileList($arr);
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

}
?>
