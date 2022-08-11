<?php

namespace kalanis\kw_clipr\Support\Posix;


/**
 * Class Command
 * @package kalanis\kw_clipr\Support\Posix
 * Processing external commands on posix machine
 * @codeCoverageIgnore because it runs Exec
 */
class Command
{
    const E_NO_PROCESS_ID = 249;

    const E_TIMED_OUT = 248;

    /** @var string */
    protected $command = '';
    /** @var bool */
    protected $success = false;
    /** @var int */
    protected $returnStatus = 0;
    /**
     * Output - what it write to output lines
     * @var array<int, string>
     */
    protected $outputLines = [];

    /**
     * Run command immediately
     * @param string|null $command
     * @param array<int, string>|null $outputLines
     */
    public function __construct(?string $command = null, ?array &$outputLines = null)
    {
        if (!$this->isExecFuncAvailable()) {
            throw new \LogicException('This system did not allow to use Exec.');
        }
        if (!is_null($command)) {
            $this->setCommand($command);
            $this->exec($outputLines);
        }
    }

    protected function isExecFuncAvailable(): bool
    {
        if (
            in_array(strtolower(strval(ini_get('safe_mode'))), array('on', '1'), true)
            || (!function_exists('exec'))
        ) {
            return false;
        }
        return !in_array('exec', array_map('trim', explode(',', strval(ini_get('disable_functions')))));
    }

    public function setCommand(string $command): void
    {
        $this->command = $command;
        $this->success = false;
        $this->returnStatus = 0;
        $this->outputLines = [];
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function hasSuccess(): bool
    {
        return $this->success;
    }

    public function getReturnStatus(): int
    {
        return $this->returnStatus;
    }

    /**
     * @return array<int, string>
     */
    public function getOutputLines(): array
    {
        return $this->outputLines;
    }

    /**
     * Run preset command via EXEC
     * @param array<int, string>|null $outputLines
     * @return bool
     */
    public function exec(array &$outputLines = null): bool
    {
        exec($this->command, $outputLines, $return);
        $this->outputLines = $outputLines;
        $this->returnStatus = $return;
        $this->success = (0 === $return);
        return $this->success;
    }

    /**
     * Run preset command and return process id
     * @return string
     */
    public function runOnBackground(): string
    {
        $this->command .= ' & echo $!';
        $this->exec();
        return $this->outputLines[0];
    }

    /**
     * Run preset command on background, yet still wait for finish
     * @param int $processCheckPeriod
     * @return bool
     */
    public function execOnBackground(int $processCheckPeriod = 5): bool
    {
        $iTimeStarted = time();
        $processId = $this->runOnBackground();
        if (!$processId) {
            return $this->returnError(self::E_NO_PROCESS_ID);
        }
        while (true) {
            $cmd = new self('ps ' . $processId);
            if ($cmd->hasSuccess()) {
                if ((time() - $iTimeStarted) >= $iTimeStarted) {
                    return $this->returnError(self::E_TIMED_OUT);
                }
                sleep($processCheckPeriod);
            } else {
                $this->success = true;
                return true;
            }
        }
        // @phpstan-ignore-next-line
        return false;
    }

    protected function returnError(int $iErrorCode): bool
    {
        $this->success = false;
        $this->returnStatus = $iErrorCode;
        return false;
    }
}
