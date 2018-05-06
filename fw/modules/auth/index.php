<?php

Module::register('auth');

// new rules

Validator::addRule('password', function($pass, $len){

    return strlen($pass) >= $len ? md5($pass) : false;

});

Validator::addRule('uniqemail', function($email, $tablename){
    
    return (DBW::s() -> table( $tablename ) -> rows(['id']) -> where(['email', '=', $email]) -> run()) ? false : $email;
    
});

// add events for redirect

Events::add('call_action', function($params){

    $data = require_once(Module::pathToModule('auth').'redirect.php');
    
    foreach($data as $who => $actions){
        
        if(!is_string($params['actionName']))
            continue;
        
        $action = $params['controllerName'] . '@' . $params['actionName'];

        if(isset($actions[$action])){

            switch($who){
                
                case 'guest': module('auth') -> isGuest($actions[$action]); break;
                    
                case 'user': module('auth') -> isUser($actions[$action]); break;
                
            }

        }
        
    }

    return false;

});


