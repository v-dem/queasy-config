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
* PHP version 5.6 and higher (PHPUnit requirement)
* PHPUnit 5.7

### Documentation

See our [Wiki page](https://github.com/v-dem/queasy-config/wiki).

### Installation

    composer require v-dem/queasy-config:master-dev

### Usage

Include Composer autoloader:

    require_once('vendor/autoload.php');

Create config instance (config file type will be detected by file name extension):

    $config = new queasy\config\Config('config.php');

Or:

    $config = new queasy\config\Config('config.ini');

Now you can address config sections and options these ways:

    $databaseName = $config->database->name;

Or:

    $databaseName = $config['database']['name'];

Previous samples will throw queasy\config\ConfigException if an option is missing.
Tto address possibly missing options without throwing exceptions use this:

    $databaseName = $config['database']->get('name'); // Will return null if 'name' option is missing

Or:

    $databaseName = $config['database']->get('name', 'default'); // Will return 'default' if 'name' option is missing

