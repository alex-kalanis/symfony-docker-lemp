<?php

//// Example bootstrap code for KWCMS

// where is the system?
$paths = new \kalanis\kw_paths\Path();
$paths->setDocumentRoot(realpath($_SERVER['DOCUMENT_ROOT']));
$paths->setPathToSystemRoot('/..');
\kalanis\kw_paths\Stored::init($paths);

// init config
\kalanis\kw_confs\Config::init(new \kalanis\kw_confs\Loaders\PhpLoader($paths));
\kalanis\kw_confs\Config::load('Core'); // autoload core config

// load virtual parts - if exists
$virtualDir = \kalanis\kw_confs\Config::get('Core', 'net.virtual_dir', 'dir_from_config/');
$params = new \kalanis\kw_paths\Params\Request\Server();
$params->set($virtualDir)->process();
$paths->setData($params->getParams());

// init langs - the similar way like configs, but it's necessary to already have loaded params
\kalanis\kw_langs\Lang::init(
    new \kalanis\kw_langs\Loaders\PhpLoader($paths),
    \kalanis\kw_langs\Support::fillFromPaths(
        $paths,
        \kalanis\kw_confs\Config::get('Core', 'page.default_lang', 'hrk'),
        false
    )
);
\kalanis\kw_langs\Lang::load('Core'); // autoload core lang

// pass parsed params as external source
$source = new \kalanis\kw_input\Sources\Basic();
$source->setCli($argv)->setExternal($params->getParams()); // argv is for params from cli
$inputs = new \kalanis\kw_input\Inputs();
$inputs->setSource($source)->loadEntries();

// And now we have all necessary variables to build the context
