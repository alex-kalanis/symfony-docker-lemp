# kw_clipr

[![Build Status](https://travis-ci.org/alex-kalanis/kw_clipr.svg?branch=master)](https://travis-ci.org/alex-kalanis/kw_clipr)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-kalanis/kw_clipr/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-kalanis/kw_clipr/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/kw_clipr/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_clipr)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.3-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/alex-kalanis/kw_clipr.svg?v1)](https://packagist.org/packages/alex-kalanis/kw_clipr)
[![License](https://poser.pugx.org/alex-kalanis/kw_clipr/license.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_clipr)
[![Code Coverage](https://scrutinizer-ci.com/g/alex-kalanis/kw_clipr/badges/coverage.png?b=master&v=1)](https://scrutinizer-ci.com/g/alex-kalanis/kw_clipr/?branch=master)

## CLI Processor 

Basic framework for running your scripts from CLI in a bit prettier package. It calls task
from predefined sources and allows them to run. Based on django cli and private CliC. You
can use it as base for running your own scripts like regular checks or menial tasks. All
that with simplified write to CLI output. All that with coloring and runable from web
interface, *nix or Windows CLI. As extra you will get a table engine which creates output
in markdown syntax.

Command line query is simple: ```clipr task --rest-of-params -t here```.
It uses kw_input for determination which params came. So with a bit of tinkering you can
also pass regular files to tasks for some processing.


## PHP Installation

### Direct usage

Install and set PHP on target machine. Then download this project and by following steps fill it by tasks suited for
your needs.

1.) Download clipr somewhere / install via Composer

2a.) For *nix check if your base script with bootstrap can be executed

2b.) For Windows check if you have PHP installed and in %PATH%

3.) Run Clipr from /bin without parameters to test if it works; You must be inside the project dir.

4a.) Here you probably copy clipr initial file to somewhere for better access for users.

4b.) Then it's necessary to include your own autoloader in that file. Preset one probably will not work.

4c.) And you need to set correct paths to basic clipr tasks, mainly due different Composer paths.

5.) Call your clipr initial file and check if it works again. Try Listing for check tasks.

6.) Make another directory with your tasks and fill them with classes based on your use-case.

6.) Call them and check if everything runs


### Composer

```
{
    "require": {
        "alex-kalanis/kw_clipr": ">=3.2"
    }
}
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)


## PHP Usage

Each task is stored in preset directories in which it's possible to find them the fast way.
The paths are set in initial file.
And each task is subclass of kw_clipr\Tasks\ATask, which allows to write outputs and call params.

For running task simply call ```your/path/to/clipr task/name --task-params```

For creating your tasks you must create some directory where they will be, create some tasks
with correct namespacing and add that root namespace into Clipr init file to paths. If
you use DI autoloading for your classes then you also need to specify that autoloader in
Clipr init file - in example there is already a prepared commented-out place. I saw this with
DI of DB or other services accessing classes.

Clipr tasks can be set into tree, so you can separate them by some of your logic. Not need
to fill one directory with one huge list of tasks.

For beginning I advise to just copy one of tasks and play with it.

## Caveats

In default setup it contains subparts of kw_autoload and kw_inputs projects - both
are necessary to run without other dependencies. If you install this via Composer you'll see
kw_input twice and kw_autoload as extra weight. But that's okay. kw_autoload doesn't see
composer files if they aren't in predefined paths where kw_autoload can look for them.
For default run it isn't necessary to use the whole machine of Composer and it has been
developed without it.

And at last - there is NO dependency injection support by default. You must set it by yourself.
Because that usually means at least installing Composer and that's the thing I want to avoid.
Usual DI libraries are very dependent on Composer. And the whole PSR has been made with
Composer in mind. Also original project CliC had no DI support. Version 2 has better support
for DI, but it is not running by default. And default tasks do not have it. 
