<?php

//// Example locking for KWCMS

// ... part for autoloader

// where is the system?
$paths = new \kalanis\kw_paths\Path();
$paths->setDocumentRoot(realpath($_SERVER['DOCUMENT_ROOT']));
$paths->setPathToSystemRoot('/..');

// init config
\kalanis\kw_confs\Config::init(new \kalanis\kw_confs\Loaders\PhpLoader($paths));

// load virtual parts - if exists
$virtualDir = \kalanis\kw_confs\Config::get('Core', 'site.fake_dir', 'dir_from_config/');
$params = new \kalanis\kw_paths\Params\Request\Server();
$params->set($virtualDir)->process();
$paths->setData($params->getParams());

/// ...

// authorization tree
$authenticator = new \kalanis\kw_auth\Sources\Files(
    new \kalanis\kw_locks\Methods\FileLock( // LOCKS!!!
        $paths->getDocumentRoot() . $paths->getPathToSystemRoot() . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . \kalanis\kw_locks\Interfaces\ILock::LOCK_FILE
    ),
    $paths->getDocumentRoot() . $paths->getPathToSystemRoot() . DIRECTORY_SEPARATOR . 'web',
    strval(\kalanis\kw_confs\Config::get('Admin', 'admin.salt'))
);

// the rest of the boot or another usages

/// ...
