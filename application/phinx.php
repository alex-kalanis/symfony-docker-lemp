<?php

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/migrations/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'mysql',
            'host' => $_ENV['DB_SOURCE'] ?? 'k-symfony-mariadb',
            'name' => $_ENV['DB_NAME'] ?? 'dummysymfony',
            'user' => $_ENV['DB_USER'] ?? 'root',
            'pass' => $_ENV['DB_PASS'] ?? '951357456852',
            'port' => $_ENV['DB_PORT'] ?? '3306',
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'mysql',
            'host' => $_ENV['DB_SOURCE'] ?? 'k-symfony-mariadb',
            'name' => $_ENV['DB_NAME'] ?? 'dummysymfony',
            'user' => $_ENV['DB_USER'] ?? 'root',
            'pass' => $_ENV['DB_PASS'] ?? '951357456852',
            'port' => $_ENV['DB_PORT'] ?? '3306',
            'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => $_ENV['DB_SOURCE'] ?? 'k-symfony-mariadb',
            'name' => 'testsymfony',
            'user' => $_ENV['DB_USER'] ?? 'root',
            'pass' => $_ENV['DB_PASS'] ?? '951357456852',
            'port' => $_ENV['DB_PORT'] ?? '3306',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
