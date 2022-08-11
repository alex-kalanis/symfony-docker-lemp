<?php

namespace kalanis\kw_clipr\Interfaces;


/**
 * Interface ISources
 * @package kalanis\kw_clipr\Interfaces
 * Which sources combination are available
 */
interface ISources
{
    const SOURCE_CLEAR = 'clear';
    const SOURCE_WEB = 'web';
    const SOURCE_POSIX = 'lin';
    const SOURCE_WINDOWS = 'win';

    const OUTPUT_STD = 'STDOUT';
    const EXT_PHP = '.php';
}
