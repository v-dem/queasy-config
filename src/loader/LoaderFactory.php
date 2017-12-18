<?php

/*
 * Queasy PHP Framework - Configuration
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\config\loader;

use queasy\config\ConfigException;

/**
 * Loader factory
 */
class LoaderFactory
{
    /**
     * @var array Built-in default loaders
     */
    private static $defaultLoaders = array(
        '/\.php$/i' => 'queasy\config\loader\PhpLoader',
        '/\.json$/i' => 'queasy\config\loader\JsonLoader',
        '/\.ini$/i' => 'queasy\config\loader\IniLoader'
    );

    /**
     * @var array Custom loaders
     */
    private static $loaders = array();

    /**
     * Registers a custom loader.
     *
     * @param string $pattern Regexp pattern for paths to handle by this loader
     * @param string $className Loader class name
     * @param bool $ignoreIfRegistered If true, do not throw exception if $pattern is already registered in custom loaders
     *
     * @throws ConfigException When $pattern is already registered and $ignoreIfRegistered is false
     */
    public static function register($pattern, $className, $ignoreIfRegistered = false)
    {
        if (isset(self::$loaders[$pattern])
                && !$ignoreIfRegistered) {
            throw new ConfigException(sprintf('Custom loader for pattern "%s" already registered.', $pattern));
        }

        self::$loaders[$pattern] = $className;
    }

    /**
     * Creates a loader for specified path.
     *
     * @param string $path Path
     *
     * @returns queasy\config\loader\LoaderInterface Loader instance
     *
     * @throws ConfigException When no loader found for $path
     */
    public static function create($path)
    {
        $className = self::find(self::$loaders, $path);

        if (!$className) {
            $className = self::find(self::$defaultLoaders, $path);

            if (!$className) {
                throw new ConfigException(sprintf('No loader found for path "%s".', $path));
            }
        }

        return new $className($path);
    }

    /**
     * Looks for a loader for specified path in an array given.
     *
     * @param array $loaders Array of patterns and loader class names to search in
     * @param string $path Path
     *
     * @returns null|string Loader class name or null if not found
     */
    private static function find(array $loaders, $path)
    {
        foreach ($loaders as $pattern => $className) {
            if (preg_match($pattern, $path)) {
                return $className;
            }
        }
    }
}

