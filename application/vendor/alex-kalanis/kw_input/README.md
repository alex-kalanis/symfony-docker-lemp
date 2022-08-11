kw_input
================

[![Build Status](https://travis-ci.org/alex-kalanis/kw_input.svg?branch=master)](https://travis-ci.org/alex-kalanis/kw_input)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-kalanis/kw_input/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-kalanis/kw_input/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/kw_input/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_input)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.3-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/alex-kalanis/kw_input.svg?v1)](https://packagist.org/packages/alex-kalanis/kw_input)
[![License](https://poser.pugx.org/alex-kalanis/kw_input/license.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_input)
[![Code Coverage](https://scrutinizer-ci.com/g/alex-kalanis/kw_input/badges/coverage.png?b=master&v=1)](https://scrutinizer-ci.com/g/alex-kalanis/kw_input/?branch=master)

Contains simplification of inputs from the whole bunch of sources. Allow you
use either get and cli or server and env params as same source.

This is the mixed package - contains sever-side implementation in Python and PHP.

# PHP Installation

```
{
    "require": {
        "alex-kalanis/kw_input": "2.3"
    }
}
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)


# PHP Usage

1.) Use your autoloader (if not already done via Composer autoloader)

2.) Connect the "kalanis\kw_input" into your app. When it came necessary
you can extends every library to comply your use-case; mainly your init ad reading.

# Python Installation

into your "setup.py":

```
    install_requires=[
        'kw_input',
    ]
```

# Python Usage

1.) Connect the "kw_input\inputs" into your app. When it came necessary
you can extends every library to comply your use-case; mainly your storage and
processing.
