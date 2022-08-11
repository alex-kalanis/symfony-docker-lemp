<?php

namespace kalanis\kw_input\Interfaces;


/**
 * Interface ISource
 * @package kalanis\kw_input\Interfaces
 * Source of values to parse
 */
interface ISource
{
    /**
     * @return array<string|int, string|int>|null
     */
    public function cli(): ?array;

    /**
     * @return array<string|int, string|int|bool|string[]|int[]>|null
     */
    public function get(): ?array;

    /**
     * @return array<string|int, string|int|bool|string[]|int[]>|null
     */
    public function post(): ?array;

    /**
     * @return array<string|int, array<string, string>|array<string, array<string, string>>>|null
     */
    public function files(): ?array;

    /**
     * @return array<string|int, string|int|bool|string[]|int[]>|null
     */
    public function cookie(): ?array;

    /**
     * @return array<string|int, string|int|bool|string[]|int[]>|null
     */
    public function session(): ?array;

    /**
     * @return array<string|int, string|int|bool>|null
     */
    public function server(): ?array;

    /**
     * @return array<string|int, string|int|bool|string[]>|null
     */
    public function env(): ?array;

    /**
     * @return string[]|int[]|array<string|int, mixed|null>|null
     */
    public function external(): ?array;
}
