<?php

namespace kalanis\kw_forms\Form;


use ArrayAccess;
use kalanis\kw_forms\Controls;


trait TControl
{
    /**
     * Get simple form input
     * @param string $type
     * @param string $alias
     * @param string $label
     * @param string $value
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\Input
     */
    public function addInput(string $type, string $alias, string $label = '', $value = null, $attributes = [])
    {
        $input = new Controls\Input();
        $input->set($type, $alias, $value, $label)->addAttributes($attributes);
        $this->addControlDefaultKey($input);
        return $input;
    }

    /**
     * Add input for text
     * @param string $alias
     * @param string $label
     * @param string $value
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\Text
     */
    public function addText(string $alias, string $label = '', $value = null, $attributes = [])
    {
        $text = new Controls\Text();
        $text->set($alias, $value, $label)->addAttributes($attributes);
        $this->addControlDefaultKey($text);
        return $text;
    }

    /**
     * Add input for email
     * @param string $alias
     * @param string $label
     * @param string $value
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\Email
     */
    public function addEmail(string $alias, string $label = '', $value = null, $attributes = [])
    {
        $mail = new Controls\Email();
        $mail->set($alias, $value, $label)->addAttributes($attributes);
        $this->addControlDefaultKey($mail);
        return $mail;
    }

    /**
     * Add input for password
     * @param string $alias
     * @param string $label
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\Password
     */
    public function addPassword(string $alias, string $label = '', $attributes = [])
    {
        $pass = new Controls\Password();
        $pass->set($alias, $label)->addAttributes($attributes);
        $this->addControlDefaultKey($pass);
        return $pass;
    }

    /**
     * Add hidden form input
     * @param string $alias
     * @param string|null $value
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\Hidden
     */
    public function addHidden(string $alias, ?string $value = null, $attributes = [])
    {
        $hidden = new Controls\Hidden();
        $hidden->set($alias, $value)->addAttributes($attributes);
        $this->addControlDefaultKey($hidden);
        return $hidden;
    }

    /**
     * Add input for pick a date
     * @param string $alias
     * @param string $label
     * @param string|null $value
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\DatePicker
     */
    public function addDatePicker(string $alias, string $label = '', $value = null, $attributes = [])
    {
        $date = new Controls\DatePicker();
        $date->set($alias, $value, $label)->addAttributes($attributes);
        $this->addControlDefaultKey($date);
        return $date;
    }

    /**
     * Add input for pick a date and time
     * @param string $alias
     * @param string $label
     * @param string|null $value
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\DateTimePicker
     */
    public function addDateTimePicker(string $alias, string $label = '', $value = null, $attributes = [])
    {
        $date = new Controls\DateTimePicker();
        $date->set($alias, $value, $label)->addAttributes($attributes);
        $this->addControlDefaultKey($date);
        return $date;
    }

    /**
     * Add input for pick a date rage
     * @param string $alias
     * @param string $label
     * @param string|null $value
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\DateRange
     */
    public function addDateRange(string $alias, string $label = '', $value = null, $attributes = [])
    {
        $date = new Controls\DateRange();
        $date->set($alias, $value, $label)->addAttributes($attributes);
        $this->addControlDefaultKey($date);
        return $date;
    }

    /**
     * Add description as control
     * @param string $alias
     * @param string $label
     * @param string|null $value
     * @return Controls\Description
     */
    public function addDescription(string $alias, string $label = '', $value = null)
    {
        $desc = new Controls\Description();
        $desc->setEntry($alias, $value, $label);
        $this->addControlDefaultKey($desc);
        return $desc;
    }

    /**
     * Add html code as control
     * @param string $alias
     * @param string $label
     * @param string|null $value
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\Html
     */
    public function addHtml(string $alias, string $label = '', $value = null, $attributes = [])
    {
        $html = new Controls\Html();
        $html->setEntry($alias, $value, $label)->addAttributes($attributes);
        $this->addControlDefaultKey($html);
        return $html;
    }

    /**
     * Add textarea input
     * @param string $alias
     * @param string $label
     * @param string|int|float|null $value
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\Textarea
     */
    public function addTextarea(string $alias, string $label = '', $value = null, $attributes = [])
    {
        $text = new Controls\Textarea();
        $text->set($alias, $value, $label)->addAttributes($attributes);
        $this->addControlDefaultKey($text);
        return $text;
    }

    /**
     * Add select input
     * @param string $alias
     * @param string $label
     * @param string|int|float|null $value
     * @param iterable<string, string|int|float|Controls\SelectOptgroup|Controls\SelectOption> $children
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\Select
     */
    public function addSelect(string $alias, string $label = '', $value = null, iterable $children = [], $attributes = [])
    {
        $select = new Controls\Select();
        $select->set($alias, $value, $label, $children)->addAttributes($attributes);
        $this->addControlDefaultKey($select);
        return $select;
    }

    /**
     * Add select list input
     * @param string $alias
     * @param string $label
     * @param iterable<string, string|Controls\SelectOption> $children
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\SelectList
     */
    public function addSelectList(string $alias, string $label = '', iterable $children = [], $attributes = [])
    {
        $select = new Controls\SelectList();
        $select->set($alias, $label, $children)->addAttributes($attributes);
        $this->addControlDefaultKey($select);
        return $select;
    }

    /**
     * Add bunch of radios
     * @param string $alias
     * @param string $label
     * @param string|int|float|null $value
     * @param iterable<string, string|int|Controls\Radio> $children
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\RadioSet
     */
    public function addRadios(string $alias, string $label = '', $value = null, iterable $children = [], $attributes = [])
    {
        $radio = new Controls\RadioSet();
        $radio->set($alias, $value, $label, $children)->addAttributes($attributes);
        $this->addControlDefaultKey($radio);
        return $radio;
    }

    /**
     * Add input type checkbox
     * @param string $alias
     * @param string $label
     * @param boolean $checked
     * @param string|int|float|null $value
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\Checkbox
     */
    public function addCheckbox(string $alias, string $label = '', $checked = null, $value = '1', $attributes = [])
    {
        $check = new Controls\Checkbox();
        $check->set($alias, $value, $label)->addAttributes($attributes);
        $check->setValue(strval($checked));
        $this->addControlDefaultKey($check);
        return $check;
    }

    /**
     * Add input type checkbox switch
     * @param string $alias
     * @param string $label
     * @param boolean $checked
     * @param string|int|float|null $value
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\CheckboxSwitch
     */
    public function addCheckboxSwitch(string $alias, string $label = '', $checked = null, $value = 1, $attributes = [])
    {
        $switch = new Controls\CheckboxSwitch();
        $switch->set($alias, $value, $label)->addAttributes($attributes);
        $switch->setValue(strval($checked));
        $this->addControlDefaultKey($switch);
        return $switch;
    }

    /**
     * Add group of checkboxes
     * @param string $alias
     * @param string $label
     * @param array<string, string|int|float|bool> $checked
     * @param iterable<string, string|Controls\Checkbox> $children
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\Checkboxes
     */
    public function addCheckboxes(string $alias, string $label = '', array $checked = [], iterable $children = [], $attributes = [])
    {
        $check = new Controls\Checkboxes();
        $check->set($alias, $checked, $label, $children)->addAttributes($attributes);
        $this->addControlDefaultKey($check);
        return $check;
    }

    /**
     * Add input type file
     * @param string $alias
     * @param string $label
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\File
     */
    public function addFile(string $alias, string $label = '', $attributes = [])
    {
        $file = new Controls\File();
        $file->set($alias, $label)->addAttributes($attributes);
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->addControlDefaultKey($file);
        return $file;
    }

    /**
     * Add group of inputs type file
     * @param string $alias
     * @param string $label
     * @param iterable<string|int, string> $inputs
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\Files
     */
    public function addFiles(string $alias, string $label = '', iterable $inputs = [], $attributes = [])
    {
        $file = new Controls\Files();
        $file->set($alias, $inputs, $label, $attributes);
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->addControlDefaultKey($file);
        return $file;
    }

    /**
     * Add input type Simple Button
     * @param string $alias
     * @param string $label
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\Button
     */
    public function addButton(string $alias, string $label = '', $attributes = [])
    {
        $button = new Controls\Button();
        $button->set($alias, $label)->addAttributes($attributes);
        $this->addControlDefaultKey($button);
        return $button;
    }

    /**
     * Add input type Reset
     * @param string $alias
     * @param string $label
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\Reset
     */
    public function addReset(string $alias, string $label = '', $attributes = [])
    {
        $reset = new Controls\Reset();
        $reset->set($alias, $label)->addAttributes($attributes);
        $this->addControlDefaultKey($reset);
        return $reset;
    }

    /**
     * Add input type Submit
     * @param string $alias
     * @param string $label
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\Submit
     */
    public function addSubmit(string $alias, string $label = '', $attributes = [])
    {
        $submit = new Controls\Submit();
        $submit->set($alias, $label)->addAttributes($attributes);
        $this->addControlDefaultKey($submit);
        return $submit;
    }

    /**
     * Add input type Submit
     * @param string $alias
     * @param ArrayAccess $cookie
     * @param string $errorMessage
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\Security\Csrf
     * @codeCoverageIgnore link adapter remote resource
     */
    public function addCsrf(string $alias, ArrayAccess &$cookie, string $errorMessage, $attributes = [])
    {
        $csrf = new Controls\Security\Csrf();
        $csrf->setHidden($alias, $cookie, $errorMessage)->addAttributes($attributes);
        $this->addControlDefaultKey($csrf);
        return $csrf;
    }

    /**
     * Add input type Submit
     * @param string $alias
     * @param ArrayAccess $cookie
     * @param string $errorMessage
     * @param array<string, string|array<string>>|string $attributes
     * @return Controls\Security\MultiSend
     */
    public function addMultiSend(string $alias, ArrayAccess &$cookie, string $errorMessage, $attributes = [])
    {
        $csrf = new Controls\Security\MultiSend();
        $csrf->setHidden($alias, $cookie, $errorMessage)->addAttributes($attributes);
        $this->addControlDefaultKey($csrf);
        return $csrf;
    }

    /**
     * Add empty captcha
     * @param string $alias
     * @return Controls\Security\Captcha\Disabled
     */
    public function addCaptchaDisabled(string $alias)
    {
        $captcha = new Controls\Security\Captcha\Disabled();
        $captcha->setEntry($alias);
        $this->addControlDefaultKey($captcha);
        return $captcha;
    }

    /**
     * Add simple image-to-text captcha
     * @param string $alias
     * @param ArrayAccess $session
     * @param string $errorMessage
     * @return Controls\Security\Captcha\Text
     */
    public function addCaptchaText(string $alias, ArrayAccess &$session, string $errorMessage = 'Captcha mismatch')
    {
        $captcha = new Controls\Security\Captcha\Text();
        $captcha->set($alias, $session, $errorMessage);
        $this->addControlDefaultKey($captcha);
        return $captcha;
    }

    /**
     * Add captcha check with mathematical operation
     * @param string $alias
     * @param ArrayAccess $session
     * @param string $errorMessage
     * @return Controls\Security\Captcha\Numerical
     */
    public function addCaptchaMath(string $alias, ArrayAccess &$session, string $errorMessage = 'Captcha mismatch')
    {
        $captcha = new Controls\Security\Captcha\Numerical();
        $captcha->set($alias, $session, $errorMessage);
        $this->addControlDefaultKey($captcha);
        return $captcha;
    }

    /**
     * Add captcha check with colourful text fill
     * @param string $alias
     * @param ArrayAccess $session
     * @param string $errorMessage
     * @return Controls\Security\Captcha\ColourfulText
     */
    public function addCaptchaColour(string $alias, ArrayAccess &$session, string $errorMessage = 'Captcha mismatch')
    {
        $captcha = new Controls\Security\Captcha\ColourfulText();
        $captcha->set($alias, $session, $errorMessage);
        $this->addControlDefaultKey($captcha);
        return $captcha;
    }

    /**
     * Add captcha check via service ReCaptcha-NoCaptcha
     * @param string $alias
     * @param string $errorMessage
     * @return Controls\Security\Captcha\NoCaptcha
     */
    public function addNocaptcha(string $alias, string $errorMessage = 'The NoCAPTCHA wasn\'t entered correctly. Please try it again.')
    {
        $recaptcha = new Controls\Security\Captcha\NoCaptcha();
        $recaptcha->set($alias, $errorMessage);
        $this->addControlDefaultKey($recaptcha);
        return $recaptcha;
    }

    abstract public function addControlDefaultKey(Controls\AControl $control): void;

    abstract public function setAttribute(string $name, string $value): void;
}
