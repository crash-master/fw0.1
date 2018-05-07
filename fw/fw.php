<?php

header('Access-Control-Allow-Origin: *');

$start_time = microtime(1);
session_start();

include_once('kernel/includeControll.php');

IncludeControll::customAuto();
IncludeControll::core();
IncludeControll::modules();

Module::includesAllModules();

DBIO::start();
Components::init();

//IncludeControll::migrationsUp();

Router::run(Config::get('system -> showFuncName'));


$end_time = microtime(1);

Log::add('Sys', 'Time of generate page: '.($end_time - $start_time));

phpErrors();

DBIO::end();

dump();

?>
