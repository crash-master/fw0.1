<?php

namespace Modules;

class Auth extends \Extend\Model{
    
    public function __construct(){
        
        if(!file_exists('app/migrations/UserMigration.php')){
        
            \CodeTemplate::create('migration', ['name' => 'User', 'filename' => 'UserMigration'], \Module::pathToModule('auth').'templates/');
            
        }
        
        if(!file_exists('app/models/User.php')){

            \CodeTemplate::create('model', ['name' => 'User', 'filename' => 'User'], \Module::pathToModule('auth').'templates/');

        }
        
        if(!file_exists('app/sets/User.php')){

            \CodeTemplate::create('set', ['name' => 'User', 'filename' => 'User'], \Module::pathToModule('auth').'templates/');

        }
        
        if(!file_exists('app/controllers/AuthController.php')){

            \CodeTemplate::create('controller', ['name' => 'Auth', 'filename' => 'AuthController'], \Module::pathToModule('auth').'templates/');

        }
        
    }
    
    public function login($redirect = NULL){
        
        \Request::clear();

        $email = \Request::post('email');

        $password = \Request::post('password');
        
        $param = ['where' => 
                    [
                        'email', '=', $email,
                        'and',
                        'password', '=', md5($password)
                ]
        ];

        $user = $this -> get($param);
        
        if(!$user){
            
            if(isset($this -> sets -> errLoginText))
                \Err::add('users', $this -> sets -> errLoginText); // add 'errLogin'

            return false;

        }

        \Sess::set('auth -> login',true);

        foreach($user as $key => $val){
            
            \Sess::set('auth -> ' . $key, $val);
            
        }

        if($redirect)
            redirect($redirect);

        return true;
        
    }
    
    public function signup(){

        \Request::clear();

        $post = \Request::post();

        $res = $this -> set( $post );

        if($res)
            return false;

        return true;

    }
    
    public function logout($redirect = NULL){
        
        \Sess::kill('auth');

        if($redirect)
            redirect($redirect);

        return true;
        
    }
    
    public function isUser($redirect = false){
        
        if(\Sess::get('auth -> login')){
            
            if($redirect)
                redirect($redirect);
            
            return true;
            
        }
        
        return false;
        
    }
    
    public function isGuest($redirect = false){

        if(!$this -> isUser()){
            
            if($redirect)
                redirect($redirect);
            
            return true;
            
        }
        
        return false;

    }
    
    public function is($row, $val, $redirect = false){

        if(\Sess::get('auth -> ' . $row) == $val){
            
            if($redirect)
                redirect($redirect);
            
            return true;
            
        }
        
        return false;

    }
    
    public function isNot($row, $val, $redirect = false){

        if(!$this -> is($row, $val)){
            
            if($redirect)
                redirect($redirect);
            
            return true;
            
        }
        
        return false;

    }
    
    public function current(){

        return \Sess::get('auth -> id');

    }
    
    
}