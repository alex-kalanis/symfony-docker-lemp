<?php

function autoload($className)
{
    if (!defined('AUTHOR_NAME')) {
        define('AUTHOR_NAME', '.');
    }
    if (!defined('PROJECT_NAME')) {
        define('PROJECT_NAME', '.');
    }
    if (!defined('PROJECT_DIR')) {
        define('PROJECT_DIR', 'src');
    }
    $className = preg_replace('#^' . AUTHOR_NAME . '\\\\' . PROJECT_NAME . '#', '', $className);
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);

    if (is_file(__DIR__ . DIRECTORY_SEPARATOR . $className . '.php')) {
        require_once(__DIR__ . DIRECTORY_SEPARATOR . $className . '.php');
    }

    if (is_file(__DIR__ . DIRECTORY_SEPARATOR . 'external' . DIRECTORY_SEPARATOR . $className . '.php')) {
        require_once(__DIR__ . DIRECTORY_SEPARATOR . 'external' . DIRECTORY_SEPARATOR . $className . '.php');
    }

    if (is_file(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'run' . DIRECTORY_SEPARATOR . $className . '.php')) {
        require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'run' . DIRECTORY_SEPARATOR . $className . '.php');
    }

    $noClipr = in_array(strpos($className, 'clipr'), [0, 1]) ? str_replace('clipr', '', $className) : $className;
    if (is_file(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'run' . DIRECTORY_SEPARATOR . $noClipr . '.php')) {
        require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'run' . DIRECTORY_SEPARATOR . $noClipr . '.php');
    }

    if (is_file(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . $className . '.php')) {
        require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . $className . '.php');
    }

    if (is_file(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . PROJECT_DIR . DIRECTORY_SEPARATOR . $className . '.php')) {
        require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . PROJECT_DIR . DIRECTORY_SEPARATOR . $className . '.php');
    }
}

spl_autoload_register('autoload');
