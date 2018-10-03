<?php

return [
    
    'system' => [
        'showFuncName' => 'show',
        'debug' => true,
        'ErrorHandler' => ['E_WARNING', 'E_ERROR', 'E_PARSE'],
        'modules' => require_once('fw/config/modules.config.php'),
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
    ],

    'rating-engine' => [
        'view-template' => 'yellow-drops',
    ]
    
];