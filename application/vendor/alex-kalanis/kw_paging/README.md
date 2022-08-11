Pager Render
================

[![Build Status](https://travis-ci.org/alex-kalanis/kw_paging.svg?branch=master)](https://travis-ci.org/alex-kalanis/kw_paging)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-kalanis/kw_paging/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-kalanis/kw_paging/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/kw_paging/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_paging)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.3-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/alex-kalanis/kw_paging.svg?v1)](https://packagist.org/packages/alex-kalanis/kw_paging)
[![License](https://poser.pugx.org/alex-kalanis/kw_paging/license.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_paging)
[![Code Coverage](https://scrutinizer-ci.com/g/alex-kalanis/kw_paging/badges/coverage.png?b=master&v=1)](https://scrutinizer-ci.com/g/alex-kalanis/kw_paging/?branch=master)

Contains simple render for displaying pagers compatible across the libraries.
It has been cut from running project and simplified for usage available for another
libraries.

By default you can use it for display paging on normal web page or inside the CLI.

# PHP Installation

```
{
    "require": {
        "alex-kalanis/kw_paging": "1.1"
    }
}
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)


# PHP Usage

1.) Use your autoloader (if not already done via Composer autoloader)

2.) Connect the "kalanis\kw_paging" into your app. When it came necessary
you can extends every library to comply your use-case; mainly your processing.
