<?php

namespace kalanis\kw_clipr\Output;


use kalanis\kw_clipr\CliprException;


/**
 * Trait TWrite
 * @package kalanis\kw_clipr\Output
 * @property bool $quiet
 */
trait TWrite
{
    /** @var string[] */
    protected $progressIndicator = ['|', '/', '-', '\\'];
    /** @var bool */
    protected $workingSent = false;
    /** @var int */
    protected $lastOutputLength = 0;

    public function sendOk(): void
    {
        $this->write(' .... [ <green>OK</green> ]');
    }

    public function sendSkipped(): void
    {
        $this->write(' .... [ <yellow>SKIPPED</yellow> ]');
    }

    public function sendWarning(): void
    {
        $this->write(' .... [ <yellow>WARNING</yellow> ]');
    }

    public function sendFail(): void
    {
        $this->write(' .... [ <red>FAIL</red> ]');
    }

    public function sendCustom(string $message): void
    {
        $this->write(" .... [ $message ]");
    }

    public function sendFailExplain(string $message): void
    {
        $this->sendFail();
        $this->write(' ' . $message);
    }

    public function sendErrorMessage(string $message): void
    {
        $this->writeLn();
        $this->writeLn(' <redbg>  ' . str_repeat(' ', mb_strlen($message)) . '  </redbg>');
        $this->writeLn(' <redbg>  ' . $message . '  </redbg>');
        $this->writeLn(' <redbg>  ' . str_repeat(' ', mb_strlen($message)) . '  </redbg>');
        $this->writeLn();
    }

    public function sendSuccessMessage(string $message): void
    {
        $this->writeLn();
        $this->writeLn(' <greenbg>  ' . str_repeat(' ', mb_strlen($message)) . '  </greenbg>');
        $this->writeLn(' <greenbg>  ' . $message . '  </greenbg>');
        $this->writeLn(' <greenbg>  ' . str_repeat(' ', mb_strlen($message)) . '  </greenbg>');
        $this->writeLn();
    }

    /**
     * @param string $message
     * @throws CliprException
     * @codeCoverageIgnore because external effects
     * It ends as risky
     */
    public function terminateWithError(string $message): void
    {
        $this->sendErrorMessage($message);
        throw new CliprException($message);
    }

    public function writeHeadlineLn(string $output, string $colour = 'green'): void
    {
        $this->writeLn("<$colour>$output</$colour>");
        $this->writeLn("<$colour>" . str_repeat('-', strlen($output)) . "</$colour>");
    }

    public function sendWorking(): void
    {
        $this->workingSent = true;
        $op = next($this->progressIndicator);
        if (false === $op) {
            reset($this->progressIndicator);
            $op = current($this->progressIndicator);
        }
        $this->write($this->getTranslator()->getStepsBack());
        $this->write(strval($op));
    }

    public function resetWorking(): void
    {
        if ($this->workingSent) {
            $this->write($this->getTranslator()->getStepsBack());
            $this->workingSent = false;
        }
    }

    public function write(string $output = ''): void
    {
        if (isset($this->quiet) && (true === $this->quiet)) {
            return;
        }

        $output = $this->getTranslator()->translate($output);

        $this->lastOutputLength = strlen($output);
        echo $output;
    }

    public function writeLn(string $output = ''): void
    {
        $this->write($output . $this->getTranslator()->getEol());
    }

    public function writePadded(string $output = '', int $paddingLength = 0): void
    {
        $this->write(str_pad($output, $paddingLength));
    }

    public function writePaddedLn(string $output = '', int $paddingLength = 0): void
    {
        $this->writeLn(str_pad($output, $paddingLength));
    }

    /**
     * @codeCoverageIgnore because it contains timestamp and most of it is already covered
     */
    public function writeHeader(): void
    {
        $this->write('<green>' . str_repeat('*', 20) . '</green>');
        $this->write('<green> ' . get_called_class() . ' - Start Time ' . date('Y-m-d H:i:s') . ' </green>');
        $this->writeLn('<green>' . str_repeat('*', 20) . '</green>');
    }

    /**
     * @codeCoverageIgnore because it contains timestamp and most of it is already covered
     */
    public function writeFooter(): void
    {
        $this->write('<green>' . str_repeat('*', 40) . '</green>');
        $this->write('<green> End Time ' . date('Y-m-d H:i:s') . ' </green>');
        $this->writeLn('<green>' . str_repeat('*', 40) . '</green>');
        $this->writeLn();
    }

    public function removeLastOutput(): void
    {
        if (0 < $this->lastOutputLength) {
            $this->write(
                $this->getTranslator()->getStepsBack($this->lastOutputLength)
                . str_repeat(' ', $this->lastOutputLength)
                . $this->getTranslator()->getStepsBack($this->lastOutputLength)
            );
        }
    }

    /**
     * Get translator for preset platform
     * @return AOutput
     */
    abstract protected function getTranslator(): AOutput;
}
