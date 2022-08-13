<?php

namespace clipr;


use kalanis\kw_clipr\Clipr\Paths;
use kalanis\kw_clipr\Clipr\Useful;
use kalanis\kw_clipr\CliprException;
use kalanis\kw_clipr\Interfaces\ISources;
use kalanis\kw_clipr\Output\TPrettyTable;
use kalanis\kw_clipr\Tasks\ATask;


/**
 * Class Lister
 * @package clipr
 * @property string $path
 */
class Lister extends ATask
{
    use TPrettyTable;

    protected function startup(): void
    {
        parent::startup();
        $this->params->addParam('path', 'path', null, null, null, 'Specify own path to tasks');
    }

    public function desc(): string
    {
        return 'Render list of tasks available in paths defined for lookup';
    }

    public function process(): void
    {
        $this->writeLn('<yellow><bluebg>+====================================+</bluebg></yellow>');
        $this->writeLn('<yellow><bluebg>|              kw_clipr              |</bluebg></yellow>');
        $this->writeLn('<yellow><bluebg>+====================================+</bluebg></yellow>');
        $this->writeLn('<yellow><bluebg>| List all tasks available by lookup |</bluebg></yellow>');
        $this->writeLn('<yellow><bluebg>+====================================+</bluebg></yellow>');

        if (empty($this->loader)) {
            $this->sendErrorMessage('Need any loader to get tasks!');
            return;
        }

        $this->setTableHeaders(['Task name', 'Call target', 'Description']);
        $this->setTableColors(['lgreen', 'lcyan', '']);

        try {
            if ($this->path) {
                $this->createOutput($this->path);
            } else {
                foreach (Paths::getInstance()->getPaths() as $namespace => $path) {
                    $this->createOutput($path);
                }
            }
        } catch (CliprException $ex) {
            $this->writeLn($ex->getMessage());
            return;
        }
        $this->dumpTable();
    }

    /**
     * @param string $path
     * @param bool $skipEmpty
     * @throws CliprException
     */
    protected function createOutput(string $path, bool $skipEmpty = false): void
    {
        if (!is_dir($path)) {
            throw new CliprException(sprintf('<redbg> !!! </redbg> Path leads to something unreadable. Path: <yellow>%s</yellow>', $path));
        }
        $allFiles = array_diff((array) scandir($path), [false, '', '.', '..']);
        $files = array_filter($allFiles, [$this, 'onlyPhp']);
        if (empty($files) && !$skipEmpty) {
            throw new CliprException(sprintf('<redbg> !!! </redbg> No usable files returned. Path: <yellow>%s</yellow>', $path));
        }
        foreach ($files as $fileName) {
            $className = Paths::getInstance()->realFileToClass($path, $fileName);
            if ($className) {
                /** @scrutinizer ignore-call */
                $task = $this->loader->getTask($className);
                if (!$task) {
                    continue;
                }
                $task->initTask($this->translator, $this->inputs, $this->loader);
                $this->setTableDataLine([$className, Useful::getTaskCall($task), $task->desc()]);
            }
        }
        foreach ($allFiles as $fileName) {
            $fullPath = $path . DIRECTORY_SEPARATOR . $fileName;
            if (is_dir($fullPath)) {
                $this->createOutput($fullPath, true);
            }
        }
    }

    public function onlyPhp(string $filename): bool
    {
        $extPos = mb_strripos($filename, ISources::EXT_PHP);
        return mb_substr($filename, 0, $extPos) . ISources::EXT_PHP == $filename; // something more than ext - and die!
    }
}
