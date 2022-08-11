<?php

namespace kalanis\kw_paths\Params;


/**
 * Class Arrays
 * @package kalanis\kw_paths\Params
 * Pass array as source of data
 */
class Arrays extends AParams
{
    /**
     * @param array<string|int, mixed|null> $params
     * @return $this
     */
    public function setData(array $params = []): self
    {
        $this->preset($params);
        return $this;
    }
}
