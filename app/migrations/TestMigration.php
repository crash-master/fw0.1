<?php

/*  Automatically was generated from a template fw/templates/migration.php */

class TestMigration extends \Extend\Migration{

    public static function up(){

        // Create tables in db

        DBW::create('Test',function($t){
            $t -> varchar('her')
            -> datetime('date');
        });

    }

    public static function down(){

        // Drop tables from db

        DBW::drop('Test');

    }

}

