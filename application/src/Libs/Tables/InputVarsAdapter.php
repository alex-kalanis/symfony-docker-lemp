<?php

namespace App\Libs\Tables;


use kalanis\kw_forms\Exceptions\FormsException;
use kalanis\kw_input\Interfaces\IEntry;


/**
 * Class InputVarsAdapter
 * @package App\Libs\Tables
 * Need for Cli
 * @codeCoverageIgnore accessing remote libraries
 */
class InputVarsAdapter extends \kalanis\kw_forms\Adapters\InputVarsAdapter
{
    public function loadEntries(string $inputType): void
    {
        if (IEntry::SOURCE_POST == $inputType) {
            $this->vars = $this->inputs->getInArray(null, [IEntry::SOURCE_POST, IEntry::SOURCE_CLI]);
        } elseif (IEntry::SOURCE_GET == $inputType) {
            $this->vars = $this->inputs->getInArray(null, [IEntry::SOURCE_GET, IEntry::SOURCE_CLI]);
        } else {
            throw new FormsException(sprintf('Unknown input type - %s', $inputType));
        }
        $this->inputType = $inputType;
    }
}
