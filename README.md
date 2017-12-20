# [Queasy PHP Framework](https://github.com/v-dem/queasy-app/)

## Package `v-dem/queasy-config`

This package contains a set of the classes intended for reading configuration files. Formats currently supported are:
* PHP (recommended, see below)
* INI
* JSON

### Dependencies

#### Production
* PHP version 5.3 and higher

#### Development
* PHP version 5.6 and higher
* PHPUnit 5.7

### Configuration formats and usage

Configuration factory detects config file format and tries to find a loader. When it is found, it is to be created and initialized.
It's possible to register custom config formats.

#### PHP

In this case configuration files are just simple `PHP` files containing a return statement (returning an array of single values
or key-value pairs, depending on what is required by config destination), where values can be arrays too (nested arrays). Also
it is possible to split configuration into many files as you wish. See example:

    use queasy\config\Config;

    return array(
        'database' => array(
            'driver' => 'mysql',
            'host' => 'localhost',
            'name' => 'test',
            'user' => 'test_user',
            'password' => 'test_password',
            'tables' => new Config('tables.php'),
            'queries' => new Config('queries.php')
        ),
        'logger' => array(
            'path' => 'debug.log',
            'minLevel' => 'warning',
            array(
                'loggerClass' => 'queasy\log\ConsoleLogger',
                'minLevel' => 'debug'
            )
        )
    );

Of course you can use any PHP expressions here, for example use constants etc. As you can see, there are two objects of class
`queasy\config\Config` created. They aren't going to load their config files at this moment. When you try to access any config key
they will load respective config files. You can access its values in almost the same way as you use regular arrays, for example
when you are using `foreach` with arrays, or trying to get a value by a key etc. See example:

    $config = new queasy\config\Config('config.php'); // At this point config.php is not loaded yet

    $databaseName = $config['database']['name']; // Now it is loaded, $databaseName contains 'test'

    $usersTable = $config['database']['tables']['users']; // At this point tables.php is loaded too

Reasons why I decided to use `PHP` code for configurations by default (instead of `INI`, `YAML`, `XML`, `JSON` etc):

* It is native `PHP` solution and doesn't require any additional parsing.
* It can be compiled once and cached by `PHP` virtual machine.
* It's possible to use `PHP` constants, or any other expressions which may be helpful.
* It's possible to easily split configuration between different files and access to any data just like a regular array as shown above.
* If there is any syntax error, you'll see it immediately, and you'll see a file and a line number.

Anyway you can extend this with loaders of other custom config formats.

#### INI

This config format is not recommended because it doesn't support nestings. Anyway it's possible to use it. Some people are thinking
it's better because it's very easy (but doesn't allow cool things other formats provide). See:

    [database]
    driver = mysql
    host = localhost
    name = test
    user = test_user
    password = test_password

    [logger]
    path = "debug.log"
    minLevel = warning

Accessing config options is very similar:

    $config = new queasy\config\Config('config.ini'); // At this point config.php is not loaded yet

    $databaseName = $config['database']['name']; // Now it is loaded, $databaseName contains 'test'

#### JSON

Well, this format supports nestings (but doesn't support config files inclusions as PHP does).

    {
        "database": {
            "driver": "mysql",
            "host": "localhost",
            "name": "test",
            "user": "test_user",
            "password": "test_password",
            "tables": {
                "users": {
                    "selectRecentActiveUsers": {
                        "query": "..."
                    }
                }
            },
            "queries": {
                "calculateLatestVisitsReport": {
                    ...
                }
            }
        }
    }

Accessing config options is the same:

    $config = new queasy\config\Config('config.php'); // At this point config.php is not loaded yet

    $databaseName = $config['database']['name']; // Now it is loaded, $databaseName contains 'test'

    $usersTable = $config['database']['tables']['users'];

### Classes

#### `queasy\config\Config`

The main class, in most cases remaining will not be necessary. It implements `queasy\config\ConfigInterface` which extends standard PHP
interfaces `Iterator`, `ArrayAccess` and `Countable` so `Config` can act as an array (but note that most of array functions will not work with it,
and also `is_array()` function will return `false`, and also it will not work with `array` typehint). So, you can access items by keys, use
`isset()`, `foreach()`, `count()`. More information about those interfaces above is available in official `PHP` documentation.
If you do need to use it as a real array, just call a `toArray()` method (but it will load all configurations if configuration file is splitted
by parts as shown in example above).

#### `queasy\config\ConfigInterface`

Interface implemented by `queasy\config\Config`. Can be useful to write a replacement to `Config`.

#### `queasy\config\ConfigException`

Exception that will be thrown on any configuration errors, like missing or invalid configuration file (for example when it doesn't return `array`).

#### `queasy\config\Loader`

Just loads a configuration file from a given path. Used by `queasy\config\Config`.

#### `queasy\config\LoaderInterface` and `queasy\config\AbstractLoader`

They can be used to replace `Loader` (which loads configuration from a file system) with another source. Just need to extend `AbstractLoader`
with own `Loader` implementation, extend `Config` and override `createLoader()` method there.

