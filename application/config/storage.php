<?php

use kalanis\kw_mapper\Interfaces\IDriverSources;
use kalanis\kw_mapper\Storage;


Storage\Database\ConfigStorage::getInstance()->addConfig(
    Storage\Database\Config::init()->setTarget(
        IDriverSources::TYPE_PDO_MYSQL, 'docker',
        $_ENV['DB_SOURCE'] ?? 'k-symfony-mariadb',
        $_ENV['DB_PORT'] ?? 3306,
        $_ENV['DB_USER'] ?? 'kalasymfony',
        $_ENV['DB_PASS'] ?? 'kalasymfony654',
        $_ENV['DB_NAME'] ?? 'dummysymfony'
    ));
