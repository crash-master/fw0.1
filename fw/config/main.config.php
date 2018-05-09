<?php

return [
    
    'system' => [

        'showFuncName' => 'show',

        'modules' => require_once('fw/config/modules.config.php'),

        'packages' => require_once('fw/config/packages.config.php'),

        'DB' => require_once('fw/config/db.config.php'),

        'migration' => 'on',

        'path' => [
    
            'dataJSON' => 'fw/config/data.json'
    
        ],

        'log' => [
    
            'on' => true,
    
            'to' => 'fw/log/',
    
            'storageLife' => 3
    
        ]

    ]
    
];