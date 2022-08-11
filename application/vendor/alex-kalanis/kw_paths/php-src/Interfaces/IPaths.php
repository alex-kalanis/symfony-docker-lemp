<?php

namespace kalanis\kw_paths\Interfaces;


/**
 * Interface IPaths
 * @package kalanis\kw_paths\Interfaces
 * Paths interface - this will be shared across the project
 */
interface IPaths
{
    const DIR_CORE = 'core'; # dir with module core - basics of kwcms
    const DIR_CONF = 'conf'; # dir with basic configuration
    const DIR_USER = 'user'; # dir with users accounts
    const DIR_LANG = 'lang'; # dir with language translations
    const DIR_DATA = 'data'; # dir with page data
    const DIR_TEMP = 'temp'; # dir with temporary data
    const DIR_STYLE = 'style'; # dir with page styling
    const DIR_THEME = 'theme'; # dir with styling themes
    const DIR_MODULE = 'modules'; # dir with modules
    const DIR_NO_SUB = '.'; # current dir
    const FILE_INDEX = 'index.htm'; # basic file
    const FILE_FAIL  = 'index.htm'; # file to show on fail
    const EXT   = '.php'; # file extension

    const SPLITTER_SLASH = '/'; # split path by slash
    const SPLITTER_QUOTE = '?'; # split path by quote sign
    const SPLITTER_AMP   = '&'; # split path by ampersand
    const SPLITTER_DOT   = '.'; # split path by dot
}
