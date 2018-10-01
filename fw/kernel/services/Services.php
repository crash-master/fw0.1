<?php
use Kernel\{
	Router,
	Err,
	Log,
	Model,
	Module,
	View,
	Events
};

function ddump($data, $indent=0) {
  $retval = '';
  $prefix=\str_repeat(' |  ', $indent);
  if (\is_numeric($data)) $retval.= big(b("Number: ")) . col($data, 'red');
  elseif (\is_string($data)) $retval.= big(b("String: ")) . col("'{$data}'", 'green');
  elseif (\is_null($data)) $retval.= b("NULL");
  elseif ($data===true) $retval.= b("TRUE");
  elseif ($data===false) $retval.= b("FALSE");
  elseif (is_array($data)) {
	$retval.= big(b("Array"))." ( ".col(big(b(count($data))), 'blue').' )';
	$indent++;
	foreach($data AS $key => $value) {
	  $retval.= "\n\n$prefix [ " . col(big(b($key)), 'blue') . " ] = ";
	  $retval.= ddump($value, $indent);
	}
  }
  elseif (is_object($data)) {
	$retval.= big(b("Object"))." (".col(big(b(get_class($data))), 'blue').")";
	$indent++;
	foreach($data AS $key => $value) {
	  $retval.= "\n\n$prefix " . col(big(b($key)), 'blue') . " -> ";
	  $retval.= ddump($value, $indent);
	}
  }
  return $retval;
}

function dd($var){
	function col($str, $c){
	  return '<span style="color: ' . $c . '">' . $str . '</span>';
	}

	function b($str){
	  return '<b>' . $str . '</b>';
	}

	function big($str){
	  return '<big>' . $str . '</big>';
	}

	die('<pre>'.ddump($var).'</pre>');
}

function redirect($url){
	header('Location: '.$url);
	return true;
}

function show($data){
	if(is_array($data) or is_object($data)){
		dd($data);
		return false;
	}
	echo($data);
	Events::register('after_rendered_page', [
        'html' => $data
    ]);
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
	if(!$arr)
		return [];
	elseif(!isset($arr[0]))
		return [$arr];
	else
		return $arr;
}

function atarr($arr){
	return arrayToArray($arr);
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

function vjoin($name){
	return View::join($name);
}

