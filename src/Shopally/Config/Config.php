<?php

if (!isset($config)) $config = [];

$config['exception'] = [
    'rules'=> [
        'add_product'=> [
            'rule'=> '/(AddProductException)/i',
            'out'=> 'file',
            'enabled'=> true
        ],
        'default'=> [
            'rule'=> '/(.*)/i',
            'out'=> 'mail',
            'enabled'=> true
        ]
    ]
];
