<?php

use kalanis\kw_rules\Exceptions\RuleException;
use kalanis\kw_rules\Interfaces\IRules;
use kalanis\kw_rules\Rules;


class FileFactoryTest extends CommonTestClass
{
    public function testFileFactory()
    {
        $factory = new Rules\File\Factory();
        $data = $factory->getRule(IRules::IMAGE_MAX_DIMENSION); // known to factory
        $this->assertInstanceOf('\kalanis\kw_rules\Rules\File\AFileRule', $data);
        $this->expectException(RuleException::class);
        $factory->getRule(IRules::SATISFIES_CALLBACK); // not set in factory
    }

    /**
     * @param string $rule
     * @param bool $gotResult
     * @throws RuleException
     * @dataProvider inputFilesProvider
     */
    public function testFileFactoryAvailability(string $rule, bool $gotResult)
    {
        $factory = new Rules\File\Factory();
        if (!$gotResult) $this->expectException(RuleException::class);
        $data = $factory->getRule($rule);
        if ($data) $this->assertInstanceOf('\kalanis\kw_rules\Rules\File\AFileRule', $data);
    }

    public function inputFilesProvider()
    {
        return [
            [IRules::MATCH_ALL, false],
            [IRules::MATCH_ANY, false],
            [IRules::MATCH_ENTRY, false],
            [IRules::EQUALS, false],
            [IRules::NOT_EQUALS, false],
            [IRules::IN_ARRAY, false],
            [IRules::NOT_IN_ARRAY, false],
            [IRules::IS_GREATER_THAN, false],
            [IRules::IS_LOWER_THAN, false],
            [IRules::IS_GREATER_THAN_EQUALS, false],
            [IRules::IS_LOWER_THAN_EQUALS, false],
            [IRules::IS_NUMERIC, false],
            [IRules::IS_STRING, false],
            [IRules::IS_BOOL, false],
            [IRules::MATCHES_PATTERN, false],
            [IRules::LENGTH_MIN, false],
            [IRules::LENGTH_MAX, false],
            [IRules::LENGTH_EQUALS, false],
            [IRules::IN_RANGE, false],
            [IRules::IN_RANGE_EQUALS, false],
            [IRules::NOT_IN_RANGE, false],
            [IRules::NOT_IN_RANGE_EQUALS, false],
            [IRules::IS_FILLED, false],
            [IRules::IS_NOT_EMPTY, false],
            [IRules::IS_EMPTY, false],
            [IRules::SATISFIES_CALLBACK, false],
            [IRules::IS_EMAIL, false],
            [IRules::IS_DOMAIN, false],
            [IRules::URL_EXISTS, false],
            [IRules::IS_ACTIVE_DOMAIN, false],
            [IRules::IS_JSON_STRING, false],

            [IRules::FILE_EXISTS, true],
            [IRules::FILE_SENT, true],
            [IRules::FILE_RECEIVED, true],
            [IRules::FILE_MAX_SIZE, true],
            [IRules::FILE_MIMETYPE_IN_LIST, true],
            [IRules::FILE_MIMETYPE_EQUALS, true],
            [IRules::IS_IMAGE, true],
            [IRules::IMAGE_DIMENSION_EQUALS, true],
            [IRules::IMAGE_DIMENSION_IN_LIST, true],
            [IRules::IMAGE_MAX_DIMENSION, true],
            [IRules::IMAGE_MIN_DIMENSION, true],

            [IRules::IS_POST_CODE, false],
            [IRules::IS_TELEPHONE, false],
            [IRules::IS_EU_VAT, false],
            [IRules::IS_DATE, false],
            [IRules::IS_DATE_REGEX, false],

            [IRules::SAFE_EQUALS_BASIC, false],
            [IRules::SAFE_EQUALS_FUNC, false],
            [IRules::SAFE_EQUALS_PASS, false],
        ];
    }
}
