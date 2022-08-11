<?php

namespace kalanis\kw_rules\Exceptions;


use Exception;
use Throwable;


class RuleException extends Exception
{
    /** @var Throwable|null */
    protected $prev = null;

    public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->prev = $previous;
    }

    public function setPrev(?Throwable $prev): void
    {
        $this->prev = $prev;
    }

    public function getPrev(): ?Throwable
    {
        return $this->prev;
    }
}
