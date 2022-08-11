<?php

namespace kalanis\kw_forms\Controls;


class DateRange extends AControl
{
    /** @var int */
    protected static $uniqid = 0;
    protected $templateLabel = '<label>%2$s</label>';
    protected $templateInput = '%3$s';

    public function set(string $alias, ?string $value = null, string $label = ''): self
    {
        $this->setEntry($alias, $value, $label);
        $picker1 = new DatePicker();
        $picker1->set($alias . '[]');
        $picker1->setAttribute('id', sprintf('%s_%d', $alias, self::$uniqid));
        $picker2 = new DatePicker();
        $picker2->set($alias . '[]');
        $picker2->setAttribute('id', sprintf('%s_%d', $alias, self::$uniqid + 1));
        $this->setChildren([$picker1, $picker2]);
        self::$uniqid++;
        self::$uniqid++;
        return $this;
    }
}
