<?php

namespace kalanis\kw_rules\Interfaces;


interface IRules
{
    /* Match all subrules, fail if any fails */
    const MATCH_ALL = 'matchall';
    /* Match any subrule, fail if every one fails */
    const MATCH_ANY = 'matchany';
    /* Match by entry, fail if subrule or entry itself is not valid */
    const MATCH_ENTRY = 'matchentry';

    /* Match always - usually kill the rest of processing */
    const ALWAYS = 'always';
    /* Match when input equals expected value */
    const EQUALS = 'equals';
    /* Match when input not equals expected value */
    const NOT_EQUALS = 'nequals';
    /* Match when input is in array of expected values */
    const IN_ARRAY = 'inarr';
    /* Match when input is not in array expected values */
    const NOT_IN_ARRAY = 'ninarr';
    /* Check if input is greater than preset value */
    const IS_GREATER_THAN = 'greater';
    /* Check if input is lower than preset value */
    const IS_LOWER_THAN = 'lower';
    /* Check if input is greater than or equals preset value */
    const IS_GREATER_THAN_EQUALS = 'gteq';
    /* Check if input is lower than or equals preset value */
    const IS_LOWER_THAN_EQUALS = 'lweq';
    /* Check if input is number */
    const IS_NUMERIC = 'numeric';
    /* Check if input is string */
    const IS_STRING = 'string';
    /* Check if input is boolean (true, false, 0, 1) */
    const IS_BOOL = 'bool';
    /* Check if input matches preset pattern in regular expression */
    const MATCHES_PATTERN = 'match';
    /* Check if input length is longer than preset value */
    const LENGTH_MIN = 'min';
    /* Check if input length is shorter than preset value */
    const LENGTH_MAX = 'max';
    /* Check if input length equals preset value */
    const LENGTH_EQUALS = 'eql';
    /* Check if input is in range of values (x and y) */
    const IN_RANGE = 'range';
    /* Check if input is in range of values <x and y> */
    const IN_RANGE_EQUALS = 'rangeequals';
    /* Check if input is not in range of values (x and y) */
    const NOT_IN_RANGE = 'nrange';
    /* Check if input is not in range of values <x and y> */
    const NOT_IN_RANGE_EQUALS = 'nrangeeqals';
    /* Check if value is filled with something */
    const IS_FILLED = 'fill';
    const IS_NOT_EMPTY = 'nemtpy';
    /* Check if value is considered empty */
    const IS_EMPTY = 'empty';
    /* Check if value satisfies callback function */
    const SATISFIES_CALLBACK = 'call';
    /* Check if value is correct email */
    const IS_EMAIL = 'mail';
    /* Check if value is valid domain */
    const IS_DOMAIN = 'domain';
    /* Check if input is callable URL (got code 200) */
    const URL_EXISTS = 'url';
    /* Check if input is active domain callable from the line */
    const IS_ACTIVE_DOMAIN = 'domainactive';
    /* Check if input is valid JSON string */
    const IS_JSON_STRING = 'json';

    /// Checks for files ///
    /* Has file been sent */
    const FILE_EXISTS = 'fileexist';
    /* Has file been sent */
    const FILE_SENT = 'fileout';
    /* Has file been received */
    const FILE_RECEIVED = 'filein';
    /* Check file max size */
    const FILE_MAX_SIZE = 'filesize';
    /* Check if file mime type is in preset array */
    const FILE_MIMETYPE_IN_LIST = 'filemimelist';
    /* Check if file mime type equals preset one */
    const FILE_MIMETYPE_EQUALS = 'filemime';
    /* Check if input file is an image */
    const IS_IMAGE = 'image';
    /* Check if input image has correct size */
    const IMAGE_DIMENSION_EQUALS = 'imgsizeeq';
    /* Check if input image has size defined in preset list */
    const IMAGE_DIMENSION_IN_LIST = 'imgsizelist';
    /* Check if input image is not larger than preset values */
    const IMAGE_MAX_DIMENSION = 'imgmaxsize';
    /* Check if input image is not smaller than preset values */
    const IMAGE_MIN_DIMENSION = 'imgminsize';

    /// Need external sources ///
    /* Check if input is post code */
    const IS_POST_CODE = 'postcode';
    /* Check if input is valid phone number */
    const IS_TELEPHONE = 'phone';
    /* Check if input is correct EU VAT number */
    const IS_EU_VAT = 'euvat';
    /* Check if input is correct date in expected format */
    const IS_DATE = 'date';
    /* Check if input is correct date in expected format */
    const IS_DATE_REGEX = 'rgxdate';

    /// Secured matching - like for passwords ///
    /* Match when hash of input equals hashed expected value */
    const SAFE_EQUALS_BASIC = 'hbequals';
    /* Match when input equals expected value via direct function */
    const SAFE_EQUALS_FUNC = 'hfequals';
    /* Match when hashes of input and expected value equals via password check */
    const SAFE_EQUALS_PASS = 'hpass';
}
