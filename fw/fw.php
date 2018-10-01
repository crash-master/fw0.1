<?php
namespace Kernel;
header('Access-Control-Allow-Origin: *');

$start_time = microtime(1);
session_start();

include_once('kernel/IncludeControll.php');

IncludeControll::init();

Module::includesAllModules();

// PackageControll::init();
DBIO::start();
Components::init();

Router::run(Config::get('system -> showFuncName'));


$end_time = microtime(1);

Log::add('Sys', 'Time of generate page: '.($end_time - $start_time));

phpErrors();

DBIO::end();

dump();

