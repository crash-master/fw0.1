<?php

//class Mod{
//    
//    //Variables
//    
//    private static $mods;
//    
//    // Methods
//    
//    public static function get(){
//        
//        return $files;
//        
//    }
//    
//    
//    public static function autoRemove(){
//        
//        
//        
//    }
//    
//    
//    public static function autoInstall(){
//        
//        $dir = 'backend/custom/mods/';
//        
//        $installed = Data::get('mod -> installed');
//        
//        $files = IncludeControll::scan($dir);
//        
//        if(!$installed){
//            
//            Data::get('mod -> installed',[]);
//            
//            $installed = [];
//            
//        }
//        
//        $countInstalled = count($installed);
//        
//        $installed = array_flip($installed);
//        
//        $countfiles = count($files);
//        
////        $count = ($countfiles > $countInstalled) ? $countfiles : $countInstalled;
//        $count = $countfiles;
//        
//        $all = [];
//        
//        $list = [];
//        
//        for($i=0;$i<$count;$i++){
//            
//            list($name) = explode('.',basename($files[$i]));
//            
//            $all[] = $name;
//            
//            if(!isset($installed[$name]))
//                $list[] = $files[$i];
//            
//        }
//        
//        self::$mods = $all;
//        
//        $count = count($list);
//        
//        for($i=0;$i<$count;$i++){
//            
//            self::install($list[$i]);
//            
//        }
//        
//        return true;
//        
//    }
//    
//    
//    public static function createDirs($dirs){
//        
//        $count = count($dirs);
//        
//        $c = 0;
//        
//        for($i=0;$i<$count;$i++){
//            
//            if(mkdir($dirs[$i]))
//                $c++;
//            
//        }
//        
//        return ($c == $count) ? true : false;
//        
//    }
//    
//    
//    public static function removesDirs($dirs){
//        
//        $count = count($dirs);
//
//        $c = 0;
//
//        for($i=0;$i<$count;$i++){
//
//            if(@rmdir($dirs[$i]))
//                $c++;
//
//        }
//
//        return ($c == $count) ? true : false;
//        
//    }
//    
//    public static function removeFiles($files){
//        
//        $count = count($files);
//        
//        $c = 0;
//        
//        foreach($files as $key => $val){
//            
//            if(@unlink($val))
//                $c++;
//            
//        }
//        
//        return ($c == $count) ? true : false;
//        
//    }
//    
//    
//    public static function install($path){
//        
//        $tmpdir = 'backend/fw/tmp/';
//        
//        $zip = new ZipArchive;
//        
//        dd(new ZipArchive);
//        
//        $res = $zip -> open($path);
//        
//        if(!$res){
//            
//            Err::add('Mod', 'Error installation mod. Fail unpacking archive.');
//            
//            return false;
//            
//        }
//        
//        $zip -> extractTo($tmpdir, ['instructions.json']);
//        
//        $instructions = json_decode(file_get_contents($tmpdir.'instructions.json'), true);
//        
//        if(!self::createDirs($instructions['dirs'])){
//            
//            Err::add('Mod', 'Error installing mod. Fail created directories.');
//            
//            self::removeDirs($instructions['dirs']);
//            
//            return false;
//            
//        }
//        
//        $count = count($instructions['files']);
//        
//        $modfiles = array_keys($instructions['files']);
//        
//        for($i=0;$i<$count;$i++){
//            
//            if(strstr($instructions['files'][$modfiles[$i]],'core') or file_exists(dirname($instructions['files'][$modfiles[$i]]))){
//                
//                Err::add('Mod','Error of access for writing file');
//                
//                self::removeFiles($instructions['files']);
//                
//                self::removeDirs($instructions['dirs']);
//                
//                return false;
//                
//            }
//            
//            $zip -> extractTo($instructions['files'][$modfiles[$i]], [$modfiles[$i]]);
//            
//        }
//        
//        $zip -> close();
//        
//        Log::add('Mod','Installed mod '.$instructions['name'].' is successful.');
//        
//        return true;
//        
//    }
//    
//}





