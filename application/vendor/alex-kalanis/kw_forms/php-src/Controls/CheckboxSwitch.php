<?php

namespace kalanis\kw_forms\Controls;


/**
 * Class CheckboxSwitch
 * @package kalanis\kw_forms\Controls
 * Form element for checkbox switches - styles are set on web
 */
class CheckboxSwitch extends Checkbox
{
    public $templateInput =
    '<label class="checkbox-switch">
        <input type="checkbox" value="%1$s"%2$s />
        <span class="label" data-on="On" data-off="Off"></span>
        <span class="handle"></span>
    </label>';
}
