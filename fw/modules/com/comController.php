<?php

namespace Modules;

class comController{
    
    public function help(){
        
        return \View::make(\Module::pathToModule('com').'view/help', [
            'breadcrumbs' => ['Com' => '/com', 'Help' => '/com/help']
        ]);
        
    }
    
    public function index(){
        
        return \View::make(\Module::pathToModule('com').'view/about', [
            'breadcrumbs' => ['Com' => '/com']
        ]);
        
    }
    
    public function eventsList(){
        
        $events = \Events::getList();
        
        $html = '<h2>Events</h2>';
        
        foreach($events as $name => $count){
            
            $html .= '<p><big>' . $name . '</big> (' . $count . ')';
            
        }
        
        $html .= '<h3>Waste Events</h3>';
        
        $waste = \Events::getWaste();
        
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
        return \View::make(\Module::pathToModule('com').'view/component-list', [
            'components' => \Components::getAll(),
            'breadcrumbs' => ['Com' => '/com', 'Help' => '/com/help', 'Components' => '/com/components']
        ]);
    }
    
    public function createController($name){
        
        if($name){
            
            \CodeTemplate::create('controller', ['name' => $name, 'filename' => $name.'Controller']);
            
            return 'TRUE';
            
        }
        
        return 'FALSE';
        
    }
    
    public function createSet($name){
        
        if($name){

            \CodeTemplate::create('set', ['setname' => $name, 'tablename' => $name, 'filename' => $name]);

            return 'TRUE';

        }

        return 'FALSE';
        
    }
    
    public function createModel($name){

        if($name){

            \CodeTemplate::create('model', ['modelname' => $name, 'setname' => $name, 'filename' => $name]);

            return 'TRUE';

        }

        return 'FALSE';

    }
    
    public function createMigration($name){

        if($name){

            \CodeTemplate::create('migration', ['name' => $name, 'filename' => $name.'Migration']);

            return 'TRUE';

        }

        return 'FALSE';

    }
    
    public function migrationUpAll(){
        
        file_put_contents('fw/config/data.json','');
        
        if(\Config::get('system -> migration') != 'on'){
            if(\Maker::refreshMigration())
                return 'TRUE';
        }
        
        return 'TRUE';
        
    }
    
    public function migrationDownAll(){

        file_put_contents('fw/config/data.json','');

        if(\Maker::unsetAllMigration())
            return 'TRUE';

        return 'TRUE';

    }
    
    public function migrationDown($name){
        
        if(!file_exists('app/migrations/'.$name.'Migration.php')){
            
            return 'FALSE';
            
        }
        
        if(!\Maker::unsetMigration([NULL, $name])){
            
            \Err::add('ERR Com',"Migration {$name} was not unset");
            
            return 'FALSE';
            
        }
        
        return 'TRUE';
        
    }
    
    public function migrationUp($name){

        if(!file_exists('app/migrations/'.$name.'Migration.php')){

            return 'FALSE';

        }

        if(!\Maker::setMigration([NULL, $name])){

            \Err::add('ERR Com',"Migration {$name} was not unset");

            return 'FALSE';

        }

        return 'TRUE';

    }
    
    public function routeList(){
       
        $cont = \Router::getControllerList();

        if(isset($cont['post'])){
            foreach($cont['post'] as $variableAndRoute => $action){
                if(strstr($variableAndRoute, ':')){
                    $res = explode(':', $variableAndRoute);
                    $route = $res[1];
                    $variable = $res[0];
                    $cont['post'][$variable]['action'] = $action['action'];
                    $cont['post'][$variable]['route'] = $route;
                    unset($cont['post'][$variableAndRoute]);
                }
            }
        }

        return \View::make(\Module::pathToModule('com').'view/route-list', [
            'routes' => $cont,
            'breadcrumbs' => ['Com' => '/com', 'Help' => '/com/help', 'Routes' => '/com/routes']
        ]);
        
    }
    
}