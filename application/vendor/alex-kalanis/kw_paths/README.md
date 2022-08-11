# kw_paths

[![Build Status](https://travis-ci.org/alex-kalanis/kw_paths.svg?branch=master)](https://travis-ci.org/alex-kalanis/kw_paths)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-kalanis/kw_paths/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-kalanis/kw_paths/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/kw_paths/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_paths)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.3-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/alex-kalanis/kw_paths.svg?v1)](https://packagist.org/packages/alex-kalanis/kw_paths)
[![License](https://poser.pugx.org/alex-kalanis/kw_paths/license.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_paths)
[![Code Coverage](https://scrutinizer-ci.com/g/alex-kalanis/kw_paths/badges/coverage.png?b=master&v=1)](https://scrutinizer-ci.com/g/alex-kalanis/kw_paths/?branch=master)

Define used paths inside the KWCMS tree. Parse them from REQUEST_URI or other sources.

## PHP Installation

```
{
    "require": {
        "alex-kalanis/kw_paths": ">=2.0"
    }
}
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)


## PHP Usage

1.) Use your autoloader (if not already done via Composer autoloader)

2.) Add some external packages with connection to the local or remote services.

3.) Connect the "kalanis\kw_paths" into your app. Extends it for setting your case.

4.) Connect library into your bootstrap process.

5.) Just use class "kalanis\kw_paths\Path" as data storage

This package contains example file from KWCMS bootstrap. Use it as reference.
