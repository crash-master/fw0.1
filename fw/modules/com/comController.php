<?php

namespace Modules;
use Kernel\{
    View,
    Router,
    Model,
    Module,
    Events,
    Err,
    Log,
    Components,
    CodeTemplate,
    Config,
    Maker,
    PackageControll
};

class comController{
    
    public function help(){
        return View::make(Module::pathToModule('com').'view/help', [
            'breadcrumbs' => ['Com' => '/com', 'Help' => '/com/help']
        ]);
    }
    
    public function index(){
        return View::make(Module::pathToModule('com').'view/about', [
            'breadcrumbs' => ['Com' => '/com']
        ]);
    }
    
    public function eventsList(){
        $events = Events::getList();
        $html = '<h2>Events</h2>';
        
        foreach($events as $name => $count){
            $html .= '<p><big>' . $name . '</big> (' . $count . ')';
        }
        
        $html .= '<h3>Waste Events</h3>';
        $waste = Events::getWaste();
        
        foreach($waste as $name => $args){
            $html .= "<p><big>{$name}</big> - ";
            foreach($args as $key => $val){
                if(!$val) continue;
                $html .= " <b>{$key}</b>: {$val}; ";
            }
            
            $html .= '</p>';
        }
        
        return $html;
    }

    public function showAllComponents(){
        return View::make(Module::pathToModule('com').'view/component-list', [
            'components' => Components::getAll(),
            'breadcrumbs' => ['Com' => '/com', 'Help' => '/com/help', 'Components' => '/com/components']
        ]);
    }
    
    public function createController($name){
        if($name){
            CodeTemplate::create('controller', ['name' => $name, 'filename' => $name.'Controller']);
            return 'TRUE';
        }
        
        return 'FALSE';
    }
    
    public function createSet($name){
        if($name){
            CodeTemplate::create('set', ['setname' => $name, 'tablename' => $name, 'filename' => $name.'Set']);
            return 'TRUE';
        }

        return 'FALSE';
    }
    
    public function createModel($name){
        if($name){
            CodeTemplate::create('model', ['modelname' => $name, 'setname' => $name, 'filename' => $name]);
            return 'TRUE';
        }

        return 'FALSE';
    }
    
    public function createMigration($name){
        if($name){
            CodeTemplate::create('migration', ['name' => $name, 'filename' => $name.'Migration']);
            return 'TRUE';
        }

        return 'FALSE';
    }

    public function migrationRefreshAll(){
       return $this -> migrationUpAll();
    }

    public function migrationRefresh($name){
        $res = $this -> migrationDown($name);
        if($res == 'TRUE'){
            $res = $this -> migrationUp($name);
        }

        return $res;
    }
    
    public function migrationUpAll(){
        if(Config::get('system -> migration') == 'on'){
            if(Maker::refreshMigration())
                return 'TRUE';
        }
        Err::add("Err COM", 'Migrations is off in config');
        return 'FALSE';
        
    }
    
    public function migrationDownAll(){
        if(Config::get('system -> migration') == 'on'){
            if(Maker::unsetAllMigration())
                return 'TRUE';
        }

        Err::add("Err COM", 'Migrations is off in config');
        return 'FALSE';

    }
    
    public function migrationDown($name){
        if(Config::get('system -> migration') == 'on'){
            if(!file_exists('app/migrations/'.$name.'Migration.php')){
                return 'FALSE';
            }
            
            if(Maker::unsetMigration([NULL, $name])){
                return 'TRUE';
            }
        }

        Err::add("Err COM", 'Migrations is off in config');
        Err::add('ERR Com',"Migration {$name} was not unset");
        
        return 'TRUE';
    }
    
    public function migrationUp($name){
        if(!file_exists('app/migrations/'.$name.'Migration.php')){
            return 'FALSE';
        }

        if(!Maker::setMigration([NULL, $name])){
            Err::add('ERR Com',"Migration {$name} was not unset");
            return 'FALSE';
        }

        return 'TRUE';
    }

    public function migrationList(){
        $migs = Maker::getMigrationList();
        $packages = PackageControll::getPackageList();
        $packages['name'][] = 'app';

        $count = count($packages['name']);
        $countMigs = count($migs);
        $arr = [];
        for($i=0;$i<$count;$i++){
            if(!isset($arr[$packages['name'][$i]])){
                $arr[$packages['name'][$i]] = [];
            }

            for($n=0;$n<$countMigs;$n++){
                if($packages['name'][$i] == $migs[$n]['package']){
                    $arr[$packages['name'][$i]][] = $migs[$n];
                }

            }
        }

        return View::make(Module::pathToModule('com').'view/migration-list', [
            'migrations' => $arr,
            'breadcrumbs' => ['Com' => '/com', 'Help' => '/com/help', 'Migrations' => '/com/migrations/list']
        ]);
    }
    
    public function routeList(){
       global $COM_BACKUP_ROUTES;
       $cont = $COM_BACKUP_ROUTES;

        return View::make(Module::pathToModule('com').'view/route-list', [
            'routes' => $cont,
            'breadcrumbs' => ['Com' => '/com', 'Help' => '/com/help', 'Routes' => '/com/routes']
        ]);
        
    }
    
}