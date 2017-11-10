# [Queasy PHP Framework](https://github.com/v-dem/queasy-app/)

## Package `v-dem/queasy-config` (namespace `queasy\config`)

This package contains a set of the classes intended for reading configuration files.

### Dependencies

* PHP version 5.3 and higher

### Configuration format and usage

Just a simple `PHP` files containing a return statement which returns an array of key-value pairs, where value can be an array too (nested arrays).
Also it is possible to split configuration into many files as you wish. See example:

    <?php
    return array(
        'database' => array(
            'connection' => array(
                'driver' => 'mysql',
                'host' => 'localhost',
                'name' => 'test',
                'user' => 'test_user',
                'password' => 'test_password'
            ),
            'tables' => new queasy\config\Config('tables.php'),
            'queries' => new queasy\config\Config('queries.php')
        ),
        'logger' => array(
            'path' => 'logs/debug.log',
            'mode' => 'debug'
        )
    );

Of course you can use any PHP expressions there, for example use constants etc. As you can see, there are two objects of class `queasy\config\Config`
created. They will be just instantiated, related configuration file become loaded at the first request. You can access values in the same way as
with regular arrays and use `foreach` with them. See example:

    <?php
    $config = new queasy\config\Config('config.php'); // At this point config.php is not loaded yet
    $databaseName = $config['database']['name']; // Now it is loaded, $databaseName contains 'test'
    $usersTable = $config['database']['tables']['users']; // At this point tables.php is loaded too

Reasons why I decided to use `PHP` code for configurations (instead of `INI`, `YAML`, `XML`, `JSON` etc):

1. It is native to `PHP` and doesn't require any additional parsing.
2. It can be compiled once and cached by `PHP` virtual machine.
3. It's possible to use PHP constants, or any other expressions which may be helpful.
4. It's possible to easily split configuration between different files and access any data just like a regular array as shown above.
5. If there is any syntax error, you'll see it immediately, and you'll see a file and a line number.

### Classes

#### `queasy\config\Config`

The main class, in most cases remaining will not be necessary. It implements `queasy\config\ConfigInterface` which extends standard PHP
interfaces `Iterator`, `ArrayAccess` and `Countable` so `Config` can act as an array (but note that most of array functions will not work with it,
and also `is_array()` function will return `false`, and also it will not work with `array` typehint). So, you can access items by keys, use
`isset()`, `foreach()`, `count()`. More information about those interfaces above is available in official `PHP` documentation.
If you do need to use it as a real array, just call a `toArray()` method (but it will load all configurations if configuration file is splitted
by parts as shown in example above).


