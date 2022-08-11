Pager Interfaces
================

[![Build Status](https://travis-ci.org/alex-kalanis/pager.svg?branch=master)](https://travis-ci.org/alex-kalanis/pager)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-kalanis/pager/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-kalanis/pager/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/pager/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/pager)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.3-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/alex-kalanis/pager.svg?v1)](https://packagist.org/packages/alex-kalanis/pager)
[![License](https://poser.pugx.org/alex-kalanis/pager/license.svg?v=1)](https://packagist.org/packages/alex-kalanis/pager)
[![Code Coverage](https://scrutinizer-ci.com/g/alex-kalanis/pager/badges/coverage.png?b=master&v=1)](https://scrutinizer-ci.com/g/alex-kalanis/pager/?branch=master)

Contains simple interfaces for creating pagers compatible across the libraries.
It has been cut from running project and simplified for usage available for another
libraries.

This is the mixed package - contains sever-side implementation in Python and PHP.

# PHP Installation

```
{
    "require": {
        "alex-kalanis/pager": "1.0"
    }
}
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)


# PHP Usage

1.) Use your autoloader (if not already done via Composer autoloader)

2.) Connect the "kalanis\kw_pager" into your app. When it came necessary
you can extends every library to comply your use-case; mainly your processing.

# Python Installation

into your "setup.py":

```
    install_requires=[
        'kw_pager',
    ]
```

# Python Usage

1.) Connect the "kw_pager\pager" into your app. When it came necessary
you can extends every library to comply your use-case; mainly your processing.
