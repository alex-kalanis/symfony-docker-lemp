<?php

namespace kalanis\kw_forms\Controls;


use kalanis\kw_forms\Exceptions\FormsException;


class Factory
{
    /** @var array<string, string> */
    protected static $map = [
        'input' => '\kalanis\kw_forms\Controls\Input',
        'text' => '\kalanis\kw_forms\Controls\Text',
        'textarea' => '\kalanis\kw_forms\Controls\Textarea',
        'email' => '\kalanis\kw_forms\Controls\Email',
        'pass' => '\kalanis\kw_forms\Controls\Password',
        'password' => '\kalanis\kw_forms\Controls\Password',
        'phone' => '\kalanis\kw_forms\Controls\Telephone',
        'telephone' => '\kalanis\kw_forms\Controls\Telephone',
        'chk' => '\kalanis\kw_forms\Controls\Checkbox',
        'check' => '\kalanis\kw_forms\Controls\Checkbox',
        'checkbox' => '\kalanis\kw_forms\Controls\Checkbox',
        'checkboxswitch' => '\kalanis\kw_forms\Controls\CheckboxSwitch',
        'select' => '\kalanis\kw_forms\Controls\Select',
        'selectbox' => '\kalanis\kw_forms\Controls\Select',
        'radio' => '\kalanis\kw_forms\Controls\Radio',
        'radioset' => '\kalanis\kw_forms\Controls\RadioSet',
        'radiobutton' => '\kalanis\kw_forms\Controls\Radio',
        'hidden' => '\kalanis\kw_forms\Controls\Hidden',
        'date' => '\kalanis\kw_forms\Controls\DatePicker',
        'datetime' => '\kalanis\kw_forms\Controls\DateTimePicker',
        'daterange' => '\kalanis\kw_forms\Controls\DateRange',
        'description' => '\kalanis\kw_forms\Controls\Description',
        'desc' => '\kalanis\kw_forms\Controls\Description',
        'html' => '\kalanis\kw_forms\Controls\Html',
        'file' => '\kalanis\kw_forms\Controls\File',
        'button' => '\kalanis\kw_forms\Controls\Button',
        'accept' => '\kalanis\kw_forms\Controls\Submit',
        'submit' => '\kalanis\kw_forms\Controls\Submit',
        'cancel' => '\kalanis\kw_forms\Controls\Reset',
        'reset' => '\kalanis\kw_forms\Controls\Reset',
        'captchadis' => '\kalanis\kw_forms\Controls\Security\Captcha\Disabled',
        'captchatext' => '\kalanis\kw_forms\Controls\Security\Captcha\Text',
        'captchaplus' => '\kalanis\kw_forms\Controls\Security\Captcha\Numerical',
        'nocaptcha' => '\kalanis\kw_forms\Controls\Security\Captcha\NoCaptcha',
        'csrf' => '\kalanis\kw_forms\Controls\Security\Csrf',
        'multisend' => '\kalanis\kw_forms\Controls\Security\MultiSend',
    ];

    /**
     * Factory for getting classes of each input available by kw_forms
     * @param string $type
     * @throws FormsException
     * @return AControl
     */
    public function getControl(string $type): AControl
    {
        $type = strtolower($type);
        if (isset(static::$map[$type])) {
            $class = static::$map[$type];
            $lib = new $class();
            if ($lib instanceof AControl) {
                return $lib;
            }
        }
        throw new FormsException(sprintf('Unknown type %s ', $type));
    }
}
