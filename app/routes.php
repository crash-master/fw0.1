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

Router::get('/', 'IndexController@index');
// Router::get('/{t}/{r}', 'IndexController@test');
// Router::get('/', function(){
// 	model('Profile') -> get(['catid', '=', 4]);
// });
Router::post('field', 'IndexController@test', '/hello');