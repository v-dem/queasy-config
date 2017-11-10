# [Queasy PHP Framework](https://github.com/v-dem/queasy-app/)

## Package `queasy\config`

This package contains a set of the classes intended for reading configuration files.

### Configuration format and usage

Just a simple PHP files containing a return statement which returns an array of key-value pairs, where value can be an array too (nested arrays).
Also it is possible to split configuration into many files as you wish. See example:

    <?php
    return array(
        'database' => array(
            'connection' => array(
                'driver' => 'mysql',
                'host' => 'localhost',
                'name' => 'test',
                'user' => 'test_user',
                'password' => 'test_password',
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

### Classes


