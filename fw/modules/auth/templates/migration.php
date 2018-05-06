<?php

/* PATH: app/migrations/ */

class /*$name*/Migration extends \Extend\Migration{

    public static function up(){

        // Create tables in db

        DBW::create('/*$name*/',function($t){
            $t -> varchar('email')
                -> varchar('password')
                -> datetime('date');
        });

    }

    public static function down(){

        // Drop tables from db

        DBW::drop('/*$name*/');

    }

}

