kw_connect
================

[![Build Status](https://travis-ci.org/alex-kalanis/kw_connect.svg?branch=master)](https://travis-ci.org/alex-kalanis/kw_connect)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-kalanis/kw_connect/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-kalanis/kw_connect/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/kw_connect/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_connect)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.3-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/alex-kalanis/kw_connect.svg?v1)](https://packagist.org/packages/alex-kalanis/kw_connect)
[![License](https://poser.pugx.org/alex-kalanis/kw_connect/license.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_connect)
[![Code Coverage](https://scrutinizer-ci.com/g/alex-kalanis/kw_connect/badges/coverage.png?b=master&v=1)](https://scrutinizer-ci.com/g/alex-kalanis/kw_connect/?branch=master)

Contains connection between content lookups like tables and storage engines. Allow you
use any of them as the same source and one table engine over everything.

# PHP Installation

```
{
    "require": {
        "alex-kalanis/kw_connect": "3.1"
    }
}
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)


# PHP Usage

1.) Use your autoloader (if not already done via Composer autoloader)

2.) Connect the "kalanis\kw_connect" into your app. When it came necessary
you can extends every library to comply your use-case; mainly for describe your
searched inputs.
