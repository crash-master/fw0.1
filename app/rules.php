<?php
use Kernel\Validator;
// Rules

Validator::addRule('email', function($mail){
    
    return filter_var($mail, FILTER_VALIDATE_EMAIL) ? $mail : false;
    
});

Validator::addRule('url', function($url){
    
    return filter_var($url, FILTER_SANITIZE_URL) ? $url : false;
    
});

Validator::addRule('int', function($int){           
    
    return strval(intval($int)) ? $int : false;
    
});

Validator::addRule('float', function($float){                
    
    return is_float($float) ? $float : false;
    
});

Validator::addRule('minlen', function($str, $len){
    
    return strlen($str) >= $len ? $str : false;
    
});

Validator::addRule('maxlen', function($str, $len){
    
    return strlen($str) <= $len ? $str : false;
    
});







