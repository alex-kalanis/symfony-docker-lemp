<?php

use kalanis\kw_rules\Exceptions\RuleException;
use kalanis\kw_rules\Interfaces;
use kalanis\kw_rules\Validate;
use kalanis\kw_rules\SubRules;


class ValidateTest extends CommonTestClass
{
    /**
     * @throws RuleException
     */
    public function testSimple()
    {
        $entry = MockEntry::init('foo', 'bar');
        $this->assertEmpty($entry->getRules());
        $entry->addRule(Interfaces\IRules::IS_FILLED, 'Not filled');
        $entry->addRule(Interfaces\IRules::IS_STRING, 'Not string');
        $validate = new Validate();
        $this->assertTrue($validate->validate($entry));
        $this->assertEmpty($validate->getErrors());
    }

    /**
     * @throws RuleException
     */
    public function testFailed()
    {
        $entry = MockEntry::init('baz', 0);
        $this->assertEmpty($entry->getRules());
        $entry->addRule(Interfaces\IRules::IS_FILLED, 'Not filled');
        $entry->addRule(Interfaces\IRules::IS_STRING, 'Not string');
        $validate = new Validate();
        $this->assertFalse($validate->validate($entry));
        $this->assertNotEmpty($validate->getErrors());
    }

    /**
     * @throws RuleException
     */
    public function testOr()
    {
        $entry = MockEntry::init('vfr', 75);
        $subRules = new SubRules();
        $subRules->addRule(Interfaces\IRules::IS_STRING, 'Not string');
        $subRules->addRule(Interfaces\IRules::IS_NUMERIC, 'Not number');
        $entry->addRule(Interfaces\IRules::IS_FILLED, 'Not filled');
        $entry->addRule(Interfaces\IRules::MATCH_ANY, 'Must be following', $subRules->getRules());
        $validate = new Validate();
        $this->assertTrue($validate->validate($entry));
        $this->assertEmpty($validate->getErrors());
    }

    /**
     * @throws RuleException
     */
    public function testOrFail()
    {
        $entry = MockEntry::init('vfr', 75);
        $this->assertEmpty($entry->getRules());
        $entry->addRule(Interfaces\IRules::IS_STRING, 'Not string');
        $entry->addRule(Interfaces\IRules::IS_BOOL, 'Not boolean');
        $presetRules = $entry->getRules();
        $entry->removeRules();
        $entry->addRule(Interfaces\IRules::IS_FILLED, 'Not filled');
        $entry->addRule(Interfaces\IRules::MATCH_ANY, 'Must be following', $presetRules);
        $presetRules = $entry->getRules();
        $entry->removeRules();
        $this->assertEmpty($entry->getRules());
        $entry->addRules($presetRules);
        $validate = new Validate();
        $this->assertFalse($validate->validate($entry));
        $this->assertNotEmpty($validate->getErrors());
    }

    /**
     * @throws RuleException
     */
    public function testAddFile()
    {
        $entry = $this->getMockNoFile();
        $this->assertEmpty($entry->getRules());
        $entry->addRule(Interfaces\IRules::FILE_RECEIVED, 'Must be received');
        $entry->addRule(Interfaces\IRules::FILE_SENT, 'Must be sent');
        $presetRules = $entry->getRules();
        $entry->removeRules();
        $this->assertEmpty($entry->getRules());
        $entry->addRules($presetRules);
        $validate = new Validate();
        $this->assertFalse($validate->validate($entry));
        $this->assertNotEmpty($validate->getErrors());
    }
}
