<?php
namespace Kernel;
header('Access-Control-Allow-Origin: *');

$start_time = microtime(1);
session_start();

include_once('kernel/IncludeControll.php');

IncludeControll::init();

$errHandler = new ErrorHandler();

Module::includesAllModules();

// PackageControll::init();
DBIO::start();

Router::run(Config::get('system -> showFuncName'));

if($errHandler -> err_disp)
	$errHandler -> viewErrs();

$errHandler -> log();

$end_time = microtime(1);

Log::add('Sys', 'Time of generate page: '.($end_time - $start_time));

// phpErrors();

DBIO::end();

dump();

