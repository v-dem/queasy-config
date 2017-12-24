# [Queasy PHP Framework](https://github.com/v-dem/queasy-app/)

## Package `v-dem/queasy-config`

This package contains a set of the classes intended for reading configuration files. Formats currently supported are:

* PHP (recommended, see below)
* INI
* JSON

### Features

* Easy to use - just like nested arrays or objects. Also it's possible to use `foreach()`.
* Support for default option values.
* Support for multi-file configurations. You can split your config into many files as you wish without changing program code (PHP configs only).
* Options inheritance. If an option is missing at current config level, it will look for this option on upper levels.
* Unified config interface. You can switch between config formats without changing your code.
* Easy to extend with other config formats.

Planned features:

* Ability to change configs at runtime (without save funcitonality meanwhile).
* XML format support.
* XPath queries support (for all config formats).

### Dependencies

#### Production

* PHP version 5.3 or higher

#### Development

* PHP version 5.6 or higher (PHPUnit requirement)
* PHPUnit 5.7

### Documentation

See our [Wiki page](https://github.com/v-dem/queasy-config/wiki).

### Installation

    composer require v-dem/queasy-config:master-dev

### Usage

#### Creating config object

Include Composer autoloader:

    require_once('vendor/autoload.php');

Create config instance (config file type will be detected by file name extension):

    $config = new queasy\config\Config('config.php');

Or:

    $config = new queasy\config\Config('config.ini');

#### Accessing config options

Now you can address config sections and options these ways:

    $databaseName = $config->database->name;

Or:

    $databaseName = $config['database']['name'];

Previous samples will throw `queasy\config\ConfigException` if an option is missing.
Tto address possibly missing options without throwing exceptions use this:

    $databaseName = $config['database']->get('name'); // Return null if 'name' is missing

Or:

    $databaseName = $config['database']->get('name', 'default'); // Return 'default' if 'name' is missing

How to check if a section or an option is present in config:

    $hasDatabaseName = isset($config['database']['name']);

If you don't want to check each section for presence when accessing a very nested option, you can use this trick:

    $databaseName = $config->get('database', [])->get('name', 'default'); // $databaseName will contain 'default'

