<?php
/*
*   Router::_404(action_name)
*   Router::get('route', 'action');
*   Router::post('field', 'action', 'route'?);
*   Router::actions(array_actions)
*   Router::controller(controller_name)
*/

Router::_404('IndexController@_404');

Router::controller('IndexController', [
    '_404',
    'poweredBy'
]);
