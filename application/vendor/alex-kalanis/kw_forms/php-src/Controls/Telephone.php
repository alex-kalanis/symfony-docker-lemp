<?php

namespace kalanis\kw_forms\Controls;


/**
 * Class Telephone
 * @package kalanis\kw_forms\Controls
 * Form element for telephone
 */
class Telephone extends Text
{
    protected $templateInput = '<input type="tel" value="%1$s"%2$s />%3$s';
}
