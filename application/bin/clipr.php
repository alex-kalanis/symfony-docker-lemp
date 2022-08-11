<?php
## processor of CLI - simple mode

# autoloader - kwcms part
require_once(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'vendor', 'alex-kalanis', 'kw_clipr', 'vendor', 'kalanis', 'kw_autoload', 'Autoload.php']));

\kalanis\kw_autoload\Autoload::setBasePath(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'));
# just for calling clipr tasks, main part runs through symfony code and normal composer
\kalanis\kw_autoload\Autoload::addPath('%2$s%1$svendor%1$salex-kalanis%1$skw_clipr%1$srun%1$s%5$s%1$s%6$s');
\kalanis\kw_autoload\Autoload::addPath('%2$s%1$svendor%1$salex-kalanis%1$skw_clipr%1$srun%1$s%6$s');

spl_autoload_register('\kalanis\kw_autoload\Autoload::autoloading');

# autoloader - symfony part
require_once dirname(__DIR__).'/vendor/autoload.php';

# set base for searching the files
$cwd = false !== getcwd() ? getcwd() : __DIR__ ;
\kalanis\kw_input\Loaders\CliEntry::setBasicPath($cwd);

# symfony kernel call steps
$kernel = new \App\Kernel(
    isset($_ENV['APP_ENV']) ? strval($_ENV['APP_ENV']) : 'dev',
    isset($_ENV['APP_DEBUG']) ? boolval(intval(strval($_ENV['APP_DEBUG']))) : true
);
$kernel->initStorage();
$kernel->boot();


try {
    # inputs
    $inputs = new \kalanis\kw_input\Inputs();
    $inputs->setSource($argv)->loadEntries();
    # clipr init
    $clipr = new \kalanis\kw_clipr\Clipr(
        \kalanis\kw_clipr\Loaders\CacheLoader::init(
            \kalanis\kw_clipr\Loaders\MultiLoader::init()->addLoader( # loader for kw_autoloader
                new \kalanis\kw_clipr\Loaders\KwLoader()
            )->addLoader( # DI from Symfony
                new \kalanis\kw_clipr\Loaders\DiLoader(
                    $kernel->getContainer()
                )
            )
        ),
        new \kalanis\kw_clipr\Clipr\Sources(),
        new \kalanis\kw_input\Variables($inputs)
    );
    # define basic paths with tasks
    $clipr->addPath('clipr', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'alex-kalanis' . DIRECTORY_SEPARATOR . 'kw_clipr' . DIRECTORY_SEPARATOR . 'run');
    $clipr->addPath('App\\Tasks', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Tasks');
    # and run!
    $clipr->run();
} catch (\kalanis\kw_clipr\Tasks\SingleTaskException $ex) {
    echo $ex->getMessage() . PHP_EOL;
} catch (\Exception $ex) {
    echo get_class($ex) . ': ' . $ex->getMessage() . ' in ' . $ex->getFile() . ':' . $ex->getLine() . PHP_EOL;
    echo "Stack trace:" . PHP_EOL;
    echo $ex->getTraceAsString() . PHP_EOL;
}
