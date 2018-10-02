<?php
use Kernel\Router;
/*
*   Router::_404(action_name)
*   Router::get('route', 'action');
*   Router::post('field', 'action', 'route'?);
*   Router::actions(array_actions)
*   Router::controller(controller_name, [only])
*/

Router::_404('IndexController@_404');

route('/', 'IndexController@index');

