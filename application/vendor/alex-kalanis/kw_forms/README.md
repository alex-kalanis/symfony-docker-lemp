kw_forms
================

[![Build Status](https://travis-ci.org/alex-kalanis/kw_forms.svg?branch=master)](https://travis-ci.org/alex-kalanis/kw_forms)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-kalanis/kw_forms/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-kalanis/kw_forms/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/kw_forms/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_forms)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.3-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/alex-kalanis/kw_forms.svg?v1)](https://packagist.org/packages/alex-kalanis/kw_forms)
[![License](https://poser.pugx.org/alex-kalanis/kw_forms/license.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_forms)
[![Code Coverage](https://scrutinizer-ci.com/g/alex-kalanis/kw_forms/badges/coverage.png?b=master&v=1)](https://scrutinizer-ci.com/g/alex-kalanis/kw_forms/?branch=master)

Contains simplification of inputs from the whole bunch of sources. Allow you
use either get and cli or server and env params as same source.

# PHP Installation

```
{
    "require": {
        "alex-kalanis/kw_forms": "2.0"
    }
}
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)


# PHP Usage

1.) Use your autoloader (if not already done via Composer autoloader)

2.) Connect the "kw_forms" into your app. When it came necessary
you can extends every library to comply your use-case; mainly set your inputs.
