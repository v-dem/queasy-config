[![Codacy Badge](https://api.codacy.com/project/badge/Grade/82d85625b3154e54af088394d285d6c5)](https://app.codacy.com/manual/v-dem/queasy-config?utm_source=github.com&utm_medium=referral&utm_content=v-dem/queasy-config&utm_campaign=Badge_Grade_Dashboard)
[![Build Status](https://travis-ci.com/v-dem/queasy-config.svg?branch=master)](https://travis-ci.com/v-dem/queasy-config)
[![codecov](https://codecov.io/gh/v-dem/queasy-config/branch/master/graph/badge.svg)](https://codecov.io/gh/v-dem/queasy-config)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fv-dem%2Fqueasy-config%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/v-dem/queasy-config/master)
[![Total Downloads](https://poser.pugx.org/v-dem/queasy-config/downloads)](https://packagist.org/packages/v-dem/queasy-config)
[![License](https://poser.pugx.org/v-dem/queasy-config/license)](https://packagist.org/packages/v-dem/queasy-config)

# [QuEasy PHP Framework](https://github.com/v-dem/queasy-framework/) - Configuration

## Package `v-dem/queasy-config`

This package contains a set of the classes intended for reading configuration files. Formats currently supported are:

*   PHP
*   INI
*   JSON
*   XML
*   CLI (command-line)

### Features

*   Easy to use - just like nested arrays or objects. Also it's possible to use `foreach()` with config instances.
*   Support for default option values.
*   Support for multi-file configurations. You can split your config into many files as you wish without changing program code.
*   Options inheritance. If an option is missing at current config level, it will look for this option on upper levels.
*   Unified config interface. You can switch between config formats without changing your code.
*   Easy to extend with other config formats.
*   Regular expressions support (it's possible to get config options by regular expression).

### Requirements

*   PHP version 5.3 or higher

### Reference

See [Wiki page](https://github.com/v-dem/queasy-config/wiki).

### Installation

    > composer require v-dem/queasy-config:master-dev

### Usage

Let's imagine we have the following `config.php`:

```php
return [
    'connection' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'name' => 'test',
        'user' => 'root',
        'password' => 'secret'
    ]
];
```

Or `config.ini`:

```ini
[connection]
driver = mysql
host = localhost
name = test
user = root
password = secret
```

Or `config.json`:

```json
{
    "connection": {
        "driver": "mysql",
        "host": "localhost",
        "name": "test",
        "user": "root",
        "password": "secret"
    }
}
```

Or `config.xml`:

```xml
<?xml version="1.0">
<config>
    <connection
        driver="mysql"
        host="localhost"
        name="test"
        user="root"
        password="secret" />
</config>
```

> You can mix different config types, for example top-level config of PHP type can refer to config files of other types.

#### Creating config instance

Include Composer autoloader:

```php
require_once('vendor/autoload.php');
```

Create config instance (config file type will be detected by file name extension):

```php
$config = new queasy\config\Config('config.php'); // Can be also '.ini', '.json' or '.xml'
```

#### Accessing config instance

Now you can address config sections and options these ways:

```php
$databaseName = $config->database->name;
```

Or:

```php
$databaseName = $config['database']['name'];
```

It's possible to use a default value if an option is missing:

```php
// If 'host' is missing in config, 'localhost' will be used by default
$databaseHost = $config['database']->get('host', 'localhost');
```

A bit shorter way:

```php
// If 'host' is missing in config, 'localhost' will be used by default
$databaseHost = $config['database']('host', 'localhost');
```

It's also possible to point that an option is required, and to throw `ConfigException` if this option is missing:

```php
// Throw ConfigException if 'name' is missing
$databaseName = $config['database']->need('name');
```

How to check if a section or an option is present in config:

```php
$hasDatabaseName = isset($config['database']);
$hasDatabaseName = isset($config['database']['name']);
```

If you don't want to check each section for presence when accessing a very nested option, you can use this trick:

```php
// $databaseName will contain 'default' if 'name' and/or 'database' options are missing
$databaseName = $config->get('database', [])->get('name', 'default');
```

A bit shorter way:

```php
// $databaseName will contain 'default' if 'name' and/or 'database' options are missing
$databaseName = $config('database', [])('name', 'default');
```

#### Multi-file configs

`config.php`:
```php
return [
    'connection' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'name' => 'test',
        'user' => 'root',
        'password' => 'secret'
    ],
    'queries' => new queasy\config\Config('queries.php') // Can be config of another type (INI, JSON etc)
];
```

`queries.php`:
```php
return [
    'selectActiveUsers' => 'SELECT * FROM `users` WHERE `is_active` = 1'
];
```

Accessing:
```php
$config = new queasy\config\Config('config.php');
$query = $config['queries']['selectActiveUsers'];
```

Almost the same for other config formats:

`config.ini`:
```php
[connection]
driver = mysql
host = localhost
name = test
user = root
password = secret
queries = "@queasy:new queasy\config\Config('queries.ini')"
```

> There can be any PHP code after `@queasy:` so it's possible to use PHP constants etc. Be careful, `eval()` function is used to execute this expression.

> Different config formats can be mixed this way.

#### Merging configs

You can use `Config`'s `merge()` method to merge two configs. For example, you can have a default configuration and allow users to add or override some options:

```php
$defaultConfig = new queasy\config\Config('defaults.php');
$optionalConfig = new queasy\config\Config($arrayWithOptionsToAddOrOverride);
$defaultConfig->merge($optionalConfig);
```

#### Using CLI config type

As an addition it's possible to use command-line arguments as config options source for CLI scripts (just use `.cli` extension, it will create appropriate loader):

```php
$config = new queasy\config\Config('.cli');
```

Options should be passed this way (unfortunately only this is supported currently):

    > php test.php option1=123 option2="some text"

I think it's useful to utilize `merge()` method there - default config file and optional arguments from command line.

### Testing

Tests can be run with miminum PHP 7.2 version due to PHPUnit requirements. To run them use

    > composer test
