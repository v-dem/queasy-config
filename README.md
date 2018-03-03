# [Queasy PHP Framework](https://github.com/v-dem/queasy-app/) - Configuration

## Package `v-dem/queasy-config`

This package contains a set of the classes intended for reading configuration files. Formats currently supported are:

* PHP (recommended, see below)
* INI (not recommended but very easy)
* JSON
* XML

> PHP config format supports multi-file configs, also it's possible to use PHP constants and expressions there.

> INI format doesn't support nested configs.

### Features

* Easy to use - just like nested arrays or objects. Also it's possible to use `foreach()` with config instances.
* Support for default option values.
* Support for multi-file configurations. You can split your config into many files as you wish without changing program code (PHP configs only).
* Options inheritance. If an option is missing at current config level, it will look for this option on upper levels.
* Unified config interface. You can switch between config formats without changing your code.
* Easy to extend with other config formats.
* Regular expressions support (it's possible to get config options by regular expression).

#### Planned features:

* YAML format support.

### Requirements

* PHP version 5.3 or higher

### Documentation

See our [Wiki page](https://github.com/v-dem/queasy-config/wiki).

### Installation

    composer require v-dem/queasy-config:master-dev

### Usage

Let's imagine we have the following `config.php`:

```php
<?php
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

Previous sample will return `null` even if `database` section is missing, no need to check it for null to address `name`.

It's possible to use a default value if an option is missing:

```php
$databaseHost = $config['database']->get('host', 'localhost'); // If 'host' is missing in config, 'localhost' will be used by default
```

It's also possible to point that an option is required, and to throw `ConfigException` if this option is missing:

```php
$databaseName = $config['database']->need('name'); // Throw ConfigException if 'name' is missing
```

How to check if a section or an option is present in config:

```php
$hasDatabaseName = isset($config['database']['name']);
```

If you don't want to check each section for presence when accessing a very nested option, you can use this trick:

```php
$databaseName = $config->get('database', [])->get('name', 'default'); // $databaseName will contain 'default'
```

`$databaseName` will contain an empty array if 'database' section is missing, or 'default' if 'name' option is missing in 'database' section.

#### Multi-file configs

`config.php`:
```php
<?php
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

