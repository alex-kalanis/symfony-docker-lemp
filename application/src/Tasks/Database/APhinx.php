<?php

namespace App\Tasks\Database;


use kalanis\kw_clipr\Support\Posix\Command;
use kalanis\kw_clipr\Tasks\ATask;


/**
 * Class APhinx
 * Actions with Phinx
 * @package App\Tasks\Database
 * @property string environment
 */
abstract class APhinx extends ATask
{
    /**
     * @var array<string, string>
     * Must be same as keys in environment in phinx.php
     */
    protected $targets = [
        'dev' => 'development',
        'prod' => 'production',
        'test' => 'testing',
    ];

    public function startup(): void
    {
        parent::startup();
        $this->params->addParam('environment', 'environ', null, 'dev', null, 'In which environment');
    }

    public function process(): void
    {
        $path = realpath(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', 'vendor', 'bin', 'phinx']));
        $env = in_array($this->environment, array_keys($this->targets))
            ? $this->targets[$this->environment]
            : (in_array($this->environment, $this->targets)
                ? $this->environment
                : null
            )
        ;
        if (is_null($env)) {
            $this->sendErrorMessage(sprintf('Set bad environment - value *%s* is unknown.', $this->environment));
        }
        $command = sprintf('%s %s -e %s', $path, $this->action(), $env);
        $task = new Command();
        $task->setCommand($command);
        $task->exec($output);
        // uncomment on debug
        // $this->writeLn(sprintf('Command: <yellow>%s</yellow>', $command));
        foreach ($output as $line) {
            $this->writeLn($line);
        }
    }

    /**
     * Which action it will perform
     * @return string
     */
    abstract protected function action(): string;
}
