kw_rules
================

[![Build Status](https://travis-ci.org/alex-kalanis/kw_rules.svg?branch=master)](https://travis-ci.org/alex-kalanis/kw_rules)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-kalanis/kw_rules/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-kalanis/kw_rules/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/kw_rules/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_rules)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.3-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/alex-kalanis/kw_rules.svg?v1)](https://packagist.org/packages/alex-kalanis/kw_rules)
[![License](https://poser.pugx.org/alex-kalanis/kw_rules/license.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_rules)
[![Code Coverage](https://scrutinizer-ci.com/g/alex-kalanis/kw_rules/badges/coverage.png?b=master&v=1)](https://scrutinizer-ci.com/g/alex-kalanis/kw_rules/?branch=master)

Contains simplification of rules from the whole bunch of setting. Allow you
create a variety of checks across your app.

This is the mixed package - contains sever-side implementation in Python and PHP.

# PHP Installation

```
{
    "require": {
        "alex-kalanis/kw_rules": "2.0"
    }
}
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)


# PHP Usage

1.) Use your autoloader (if not already done via Composer autoloader)

2.) Connect the "kw_rules" classes into your app. When it came necessary
you can extends every library to comply your use-case; mainly set checks itself.

# Python Installation

into your "setup.py":

```
    install_requires=[
        'kw_rules',
    ]
```

# Python Usage

1.) Connect the "kw_rules.rules" into your app. When it came necessary
you can extends every library to comply your use-case; mainly set checks itself.
