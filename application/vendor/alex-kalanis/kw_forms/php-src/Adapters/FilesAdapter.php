<?php

namespace kalanis\kw_forms\Adapters;


use kalanis\kw_forms\Exceptions\FormsException;


class FilesAdapter extends AAdapter
{
    public function loadEntries(string $inputType): void
    {
        $this->vars = $this->loadVars($_FILES);
    }

    /**
     * @param array<string|int, array<string, string|int|array<string|int>>> $array
     * @return array<string, FileEntry>
     */
    protected function loadVars(&$array): array
    {
        $entry = new FileEntry();
        $result = [];
        foreach ($array as $postedKey => $posted) {
            if (is_array($posted['name']) && is_array($posted['tmp_name']) && is_array($posted['type']) && is_array($posted['error']) && is_array($posted['size'])) {
                foreach ($posted['name'] as $key => $value) {
                    $data = clone $entry;
                    $data->setData(
                        sprintf('%s[%s]', $this->removeNullBytes(strval($postedKey)), $this->removeNullBytes(strval($key))),
                        $this->removeNullBytes(strval($value)),
                        strval($posted['tmp_name'][$key]),
                        $this->removeNullBytes(strval($posted['type'][$key])),
                        intval($posted['error'][$key]),
                        intval($posted['size'][$key])
                    );
                    $result[$data->getKey()] = $data;
                }
            } else {
                $data = clone $entry;
                $data->setData(
                    $this->removeNullBytes(strval($postedKey)),
                    $this->removeNullBytes(strval($posted['name'])),
                    strval($posted['tmp_name']),
                    $this->removeNullBytes(strval($posted['type'])),
                    intval($posted['error']),
                    intval($posted['size'])
                );
                $result[$data->getKey()] = $data;
            }
        }
        return $result;
    }

    /**
     * @throws FormsException
     * @return mixed|null
     */
    #[\ReturnTypeWillChange]
    public function current()
    {
        if ($this->valid()) {
            return $this->offsetGet($this->key);
        }
        throw new FormsException(sprintf('Unknown offset %s', $this->key));
    }

    public function getSource(): string
    {
        return static::SOURCE_FILES;
    }
}
