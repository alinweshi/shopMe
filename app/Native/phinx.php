<?php

return
    [
        'paths' => [
            'migrations' => 'db/migrations',
            'seeds' => 'db/seeds'

        ],
        'environments' => [
            'default_migration_table' => 'phinxlog',
            'default_environment' => 'development',
            'production' => [
                'adapter' => 'mysql',
                'host' => 'localhost',
                'name' => 'blog_db',
                'user' => 'root',
                'pass' => '',
                'port' => '3307',
                'charset' => 'utf8',
            ],
            'development' => [
                'adapter' => 'mysql',
                'host' => 'localhost',
                'name' => 'blog_db',
                'user' => 'root',
                'pass' => '',
                'port' => '3307',
                'charset' => 'utf8',
            ],
            'testing' => [
                'adapter' => 'mysql',
                'host' => 'localhost',
                'name' => 'testing_db',
                'user' => 'root',
                'pass' => '',
                'port' => '3307',
                'charset' => 'utf8',
            ]
        ],
        'version_order' => 'creation'
    ];
