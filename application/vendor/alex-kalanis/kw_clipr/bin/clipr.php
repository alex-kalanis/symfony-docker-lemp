<?php
## processor of CLI - simple mode
## You want your own autoloader, mainly due need of storage, database connection or the whole dependency injection.
## Because that this one is just basically example, although it can run basic programs.

# autoloader for paths
require_once(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'vendor', 'kalanis', 'kw_autoload', 'Autoload.php']));

\kalanis\kw_autoload\Autoload::setBasePath(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'));
\kalanis\kw_autoload\Autoload::addPath('%2$s%1$svendor%1$s%3$s%1$s%4$s%1$ssrc%1$s%5$s%1$s%6$s');
\kalanis\kw_autoload\Autoload::addPath('%2$s%1$svendor%1$s%3$s%1$s%4$s%1$ssrc%1$s%6$s');
\kalanis\kw_autoload\Autoload::addPath('%2$s%1$svendor%1$s%3$s%1$s%4$s%1$s%5$s%1$s%6$s');
\kalanis\kw_autoload\Autoload::addPath('%2$s%1$svendor%1$s%3$s%1$s%4$s%1$s%6$s');
\kalanis\kw_autoload\Autoload::addPath('%2$s%1$svendor%1$s%4$s%1$s%5$s%1$s%6$s');
\kalanis\kw_autoload\Autoload::addPath('%2$s%1$svendor%1$s%4$s%1$s%6$s');
\kalanis\kw_autoload\Autoload::addPath('%2$s%1$svendor%1$s%3$s%1$s%5$s%1$s%6$s');
\kalanis\kw_autoload\Autoload::addPath('%2$s%1$svendor%1$s%3$s%1$s%6$s');
\kalanis\kw_autoload\Autoload::addPath('%2$s%1$sphp-src%1$s%5$s%1$s%6$s');
\kalanis\kw_autoload\Autoload::addPath('%2$s%1$sphp-src%1$s%6$s');
\kalanis\kw_autoload\Autoload::addPath('%2$s%1$srun%1$s%5$s%1$s%6$s');
\kalanis\kw_autoload\Autoload::addPath('%2$s%1$srun%1$s%6$s');

spl_autoload_register('\kalanis\kw_autoload\Autoload::autoloading');

# set base for searching the files
$cwd = false !== getcwd() ? getcwd() : __DIR__ ;
\kalanis\kw_input\Loaders\CliEntry::setBasicPath($cwd);

try {
    $inputs = new \kalanis\kw_input\Inputs();
    $inputs->setSource($argv)->loadEntries();
    $clipr = new \kalanis\kw_clipr\Clipr(
        \kalanis\kw_clipr\Loaders\CacheLoader::init(
            new \kalanis\kw_clipr\Loaders\KwLoader()
        ),
        new kalanis\kw_clipr\Clipr\Sources(),
        new kalanis\kw_input\Variables($inputs)
    );
    # define basic paths with tasks
    $clipr->addPath('clipr', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'run');
    # and run!
    $clipr->run();
} catch (\kalanis\kw_clipr\Tasks\SingleTaskException $ex) {
    echo $ex->getMessage() . PHP_EOL;
} catch (\Exception $ex) {
    echo get_class($ex) . ': ' . $ex->getMessage() . ' in ' . $ex->getFile() . ':' . $ex->getLine() . PHP_EOL;
    echo "Stack trace:" . PHP_EOL;
    echo $ex->getTraceAsString() . PHP_EOL;
}
