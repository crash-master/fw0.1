<?php

/* PATH: app/migrations/ */
use Kernel\{
    View,
    Model
};

class /*$name*/Migration extends \Extend\Migration{

    public static function up(){

        // Create tables in db

        DBW::create('/*$name*/',function($t){
            $t -> datetime('date');
        });

    }

    public static function down(){

        // Drop tables from db

        DBW::drop('/*$name*/');

    }

}

