<?php

namespace Modules;

class Com{
    
    public function __construct(){
        
        \Router::get('/com/routes', '\Modules\comController@routeList');
        
        \Router::get('/com/events', '\Modules\comController@eventsList');
        
        \Router::get('/com/create/controller/{name}', '\Modules\comController@createController');
        
        \Router::get('/com/create/model/{name}', '\Modules\comController@createModel');
        
        \Router::get('/com/create/set/{name}', '\Modules\comController@createSet');
        
        \Router::get('/com/create/migration/{name}', '\Modules\comController@createMigration');
        
        \Router::get('/com/help', '\Modules\comController@help');
        
        \Router::get('/com', '\Modules\comController@index');
        
        \Router::get('/com/migrations/up/{name}', '\Modules\comController@migrationUp');
        
        \Router::get('/com/migrations/down/{name}', '\Modules\comController@migrationDown');
        
        \Router::get('/com/migrations/up', '\Modules\comController@migrationUpAll');
        
        \Router::get('/com/migrations/down', '\Modules\comController@migrationDownAll');

        \Router::get('/com/components', '\Modules\comController@showAllComponents');
        
    }
    
}