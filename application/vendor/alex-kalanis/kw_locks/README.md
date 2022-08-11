# kw_locks

[![Build Status](https://travis-ci.org/alex-kalanis/kw_locks.svg?branch=master)](https://travis-ci.org/alex-kalanis/kw_locks)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-kalanis/kw_locks/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-kalanis/kw_locks/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/kw_locks/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_locks)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.3-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/alex-kalanis/kw_locks.svg?v1)](https://packagist.org/packages/alex-kalanis/kw_locks)
[![License](https://poser.pugx.org/alex-kalanis/kw_locks/license.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_locks)
[![Code Coverage](https://scrutinizer-ci.com/g/alex-kalanis/kw_locks/badges/coverage.png?b=master&v=1)](https://scrutinizer-ci.com/g/alex-kalanis/kw_locks/?branch=master)

Locking resources in KWCMS. Process it by files or other storages.

## PHP Installation

```
{
    "require": {
        "alex-kalanis/kw_locks": "1.0"
    }
}
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)


## PHP Usage

1.) Use your autoloader (if not already done via Composer autoloader)

2.) Add some external packages with connection to the local or remote services.

3.) Connect the "kalanis\kw_locks\..." into your app. Extends it for setting your case.

4.) Extend your libraries by interfaces inside the package.

5.) Just call setting and render
