<?php

/*  Automatically was generated from a template fw/templates/migration.php */
use Kernel\{
    DBW
};

class Test1Migration extends \Extend\Migration{

    public static function up(){

        // Create tables in db

        DBW::create('Test1',function($t){
            $t -> datetime('date');
        });

    }

    public static function down(){

        // Drop tables from db

        DBW::drop('Test1');

    }

}

