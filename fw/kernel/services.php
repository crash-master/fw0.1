<?php

function dd($var){
    echo '<pre>';
    die(var_dump($var));
}

function redirect($url){
    header('Location: '.$url);
    return true;
}

function decompressJSON($json){

    $len = strlen($json);

    $tabs = 0;

    $c = 0;

    $res = '';

    for($i=0;$i<$len;$i++){

        $res[$c++] = $json[$i];

        if($json[$i+1] == ','){

            continue;

        }

        if($json[$i] == ','){

            $res[$c++] = PHP_EOL;

            for($k=0;$k<$tabs;$k++){

                $res[$c++] = chr(9);

            }

        }

        if($json[$i] == '{' or $json[$i] == '['){

            $tabs++;

            $res[$c++] = PHP_EOL;

            for($k=0;$k<$tabs;$k++){

                $res[$c++] = chr(9);

            }

        }

        if($json[$i] == '}' or $json[$i] == ']'){

            $tabs -= 1;

            $res[$c++] = PHP_EOL;

            for($k=0;$k<$tabs;$k++){

                $res[$c++] = chr(9);

            }

            $res[$c - 1] = chr(0);

        }

        if($i == $len - 1){

            $res[$c - 3] = PHP_EOL;
            $res[$c - 2] = chr(0);

            $res[$c] = '}';

        }


    }

    return implode('',$res);

}

function show($data){
    if(is_array($data) or is_object($data)){
        echo('<pre>');
        var_dump($data);
        echo('</pre>');
        return false;
    }
    echo($data);
    return true;
}

function phpErrors(){
    $err = error_get_last();
    if(!is_array($err))
        return false;

    Err::add('PHP ERR', $err['message'].' '.$err['file'].' in line '.$err['line']);

    return true;
}

function arrayToArray($arr){
    
    $keys = @array_keys($arr);
    
    if(!is_array($arr[$keys[0]]))
        return [$arr];
    else
        return $arr;
    
}

function dump(){
    Err::log();
    Log::dump();

    return true;
}

function model($name){
    
    return Model::register($name);
    
}

function module($name){
    
    return Module::get($name);
    
}

function linkTo($controller, $args = false){
    
    return Router::linkTo($controller, $args);
    
}

?>
