<?php

namespace Modules;
use Kernel\Router;

$COM_BACKUP_ROUTES;

class Com{
    
    public function __construct(){
        $this -> startedInit();

        Router::get('/com/routes', 'Modules\\comController@routeList');
        Router::get('/com/events', 'Modules\\comController@eventsList');
        Router::get('/com/create/controller/{name}', 'Modules\\comController@createController');
        Router::get('/com/create/model/{name}', 'Modules\\comController@createModel');
        Router::get('/com/create/set/{name}', 'Modules\\comController@createSet');
        Router::get('/com/create/migration/{name}', 'Modules\\comController@createMigration');
        Router::get('/com/help', 'Modules\\comController@help');
        Router::get('/com', 'Modules\\comController@index');
        Router::get('/com/migrations/up/{name}', 'Modules\\comController@migrationUp');
        Router::get('/com/migrations/down/{name}', 'Modules\\comController@migrationDown');
        Router::get('/com/migrations/up', 'Modules\\comController@migrationUpAll');
        Router::get('/com/migrations/down', 'Modules\\comController@migrationDownAll');
        Router::get('/com/migrations/list', 'Modules\\comController@migrationList');
        Router::get('/com/migrations/refresh/{name}', 'Modules\\comController@migrationRefresh');
        Router::get('/com/migrations/refresh', 'Modules\\comController@migrationRefreshAll');
        Router::get('/com/components', 'Modules\\comController@showAllComponents');
    }

    public function startedInit(){
        global $COM_BACKUP_ROUTES;
        $cont = Router::getControllerList();

        if(isset($cont['post'])){
            foreach($cont['post'] as $variableAndRoute => $action){
                if(strstr($variableAndRoute, ':')){
                    $res = explode(':', $variableAndRoute);
                    $route = $res[1];
                    $variable = $res[0];
                    $cont['post'][$variable]['action'] = $action['action'];
                    $cont['post'][$variable]['route'] = $route;
                    unset($cont['post'][$variableAndRoute]);
                }
            }
        }

        $COM_BACKUP_ROUTES = $cont;
        return false;
    }
    
}