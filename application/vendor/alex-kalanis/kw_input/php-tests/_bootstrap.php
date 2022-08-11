<?php

define('AUTHOR_NAME', 'kalanis');
define('PROJECT_NAME', 'kw_input');
define('PROJECT_DIR', 'php-src');
require_once __DIR__ . '/_autoload.php';
require_once __DIR__ . '/CommonTestClass.php';

\kalanis\kw_input\Loaders\CliEntry::setBasicPath(__DIR__);
