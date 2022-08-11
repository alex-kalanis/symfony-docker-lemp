# kw_templates

[![Build Status](https://travis-ci.org/alex-kalanis/kw_templates.svg?branch=master)](https://travis-ci.org/alex-kalanis/kw_templates)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-kalanis/kw_templates/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-kalanis/kw_templates/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/kw_templates/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_templates)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.3-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/alex-kalanis/kw_templates.svg?v1)](https://packagist.org/packages/alex-kalanis/kw_templates)
[![License](https://poser.pugx.org/alex-kalanis/kw_templates/license.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_templates)
[![Code Coverage](https://scrutinizer-ci.com/g/alex-kalanis/kw_templates/badges/coverage.png?b=master&v=1)](https://scrutinizer-ci.com/g/alex-kalanis/kw_templates/?branch=master)

Simple template system for PHP and Python 

# PHP Installation

```
{
    "require": {
        "alex-kalanis/kw_templates": "2.1"
    }
}
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)


# PHP Usage

1.) Use your autoloader (if not already done via Composer autoloader)

2.) Add some external packages with connection to the local or remote services.

3.) Connect the "kalanis\kw_templates\Template" into your app. Extends it for setting your case.

4.) Extend your libraries by interfaces inside the package.

5.) Just call setting and render

# Python Installation

into your "setup.py":

```
    install_requires=[
        'kw_templates',
    ]
```

# Python Usage

1.) Connect the "kw_templates.template" into your app. When it came necessary
you can extends every library to comply your use-case; mainly your sending agent.
