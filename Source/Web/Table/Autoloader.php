<?php

/**
 * This file is part of Web_Table.
 *
 * PHP version 5
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    SVN: $Id: Autoloader.php 117 2013-08-17 17:06:28Z ll77ll $
 * @since      File available since Initial Release.
 * @filesource
 */

/*
 * $LastChangedBy: ll77ll $
 * $LastChangedDate: 2013-08-17 13:06:28 -0400 (Sat, 17 Aug 2013) $
 */

/*
 * Specify Namespace
 */
namespace Web\Table;

/**
 * Autoloader
 *
 * {@link https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md PSR-0 Compliant}
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    Release @release-version@
 * @since      Class available since Initial Release.
 */
class Autoloader
{
    /**
     * Autoloader Missing File Error Message
     *
     * @var string
     */
    const AUTOLOADER_MISSING_FILE = 'Autoloader: The class ‘{0}’ could not be automatically loaded; the file ‘{1}’ does not exist in any of the registered paths.';

    /**
     * Autoloader Missing Definition Error Message
     *
     * @var string
     */
    const AUTOLOADER_MISSING_DEFINITION = 'Autoloader: The class ‘{0}’ could not be automatically loaded; please make sure it is properly defined in the file ‘{1}’.';

    /**
     * Add Additional Paths
     *
     * @param string $path [$path ...]
     *     Accepts one or more paths to search in.
     *
     * @return void
     */
    public static function add($path)
    {
        self::_addPaths(func_get_args());
    }

    /**
     * Binaries Directory Path
     *
     * @param string $addendum [$addendum ...]
     *     Accepts one or more addenda to be added to the path. Each of the
     *     addenda are automatically prefixed by a directory separator.
     *     (Default: null)
     *
     * @return string
     *     Path to the binaries directory.
     */
    public static function getBinariesDirectory($addendum = null)
    {
        return self::_getDirectory('Binaries', func_get_args());
    }

    /**
     * Build Directory Path
     *
     * @param string $addendum [$addendum ...]
     *     Accepts one or more addenda to be added to the path. Each of the
     *     addenda are automatically prefixed by a directory separator.
     *     (Default: null)
     *
     * @return string
     *     Path to the binaries directory.
     */
    public static function getBuildDirectory($addendum = null)
    {
        return self::_getDirectory('Build', func_get_args());
    }

    /**
     * Cache Directory Path
     *
     * @param string $addendum [$addendum ...]
     *     Accepts one or more addenda to be added to the path. Each of the
     *     addenda are automatically prefixed by a directory separator.
     *     (Default: null)
     *
     * @return string
     *     Path to the cache directory.
     */
    public static function getCacheDirectory($addendum = null)
    {
        return self::_getDirectory('Cache', func_get_args());
    }

    /**
     * Configuration Directory Path
     *
     * @param string $addendum [$addendum ...]
     *     Accepts one or more addenda to be added to the path. Each of the
     *     addenda are automatically prefixed by a directory separator.
     *     (Default: null)
     *
     * @return string
     *     Path to the configuration directory.
     */
    public static function getConfiguationDirectory($addendum = null)
    {
        return self::_getDirectory('Configuration', func_get_args());
    }

    /**
     * Data Directory Path
     *
     * @param string $addendum [$addendum ...]
     *     Accepts one or more addenda to be added to the path. Each of the
     *     addenda are automatically prefixed by a directory separator.
     *     (Default: null)
     *
     * @return string
     *     Path to the data directory.
     */
    public static function getDataDirectory($addendum = null)
    {
        return self::_getDirectory('Data', func_get_args());
    }

    /**
     * Documentation Directory Path
     *
     * @param string $addendum [$addendum ...]
     *     Accepts one or more addenda to be added to the path. Each of the
     *     addenda are automatically prefixed by a directory separator.
     *     (Default: null)
     *
     * @return string
     *     Path to the documentation directory.
     */
    public static function getDocumentationDirectory($addendum = null)
    {
        return self::_getDirectory('Documentation', func_get_args());
    }

    /**
     * Downloads Directory Path
     *
     * @param string $addendum [$addendum ...]
     *     Accepts one or more addenda to be added to the path. Each of the
     *     addenda are automatically prefixed by a directory separator.
     *     (Default: null)
     *
     * @return string
     *     Path to the downloads directory.
     */
    public static function getDownloadsDirectory($addendum = null)
    {
        return self::_getDirectory('Downloads', func_get_args());
    }

    /**
     * Root Directory Path
     *
     * @param string $addendum [$addendum ...]
     *     Accepts one or more addenda to be added to the path. Each of the
     *     addenda are automatically prefixed by a directory separator.
     *     (Default: null)
     *
     * @return string
     *     Path to the root directory.
     */
    public static function getRootDirectory($addendum = null)
    {
        return self::_getDirectory('Root', func_get_args());
    }

    /**
     * Source Directory Path
     *
     * @param string $addendum [$addendum ...]
     *     Accepts one or more addenda to be added to the path. Each of the
     *     addenda are automatically prefixed by a directory separator.
     *     (Default: null)
     *
     * @return string
     *     Path to the source directory.
     */
    public static function getSourceDirectory($addendum = null)
    {
        return self::_getDirectory('Source', func_get_args());
    }

    /**
     * Temporary Directory Path
     *
     * @param string $addendum [$addendum ...]
     *     Accepts one or more addenda to be added to the path. Each of the
     *     addenda are automatically prefixed by a directory separator.
     *     (Default: null)
     *
     * @return string
     *     Path to the temporary directory.
     */
    public static function getTemporaryDirectory($addendum = null)
    {
        return self::_getDirectory('Temporary', func_get_args());
    }

    /**
     * Tests Directory Path
     *
     * @param string $addendum [$addendum ...]
     *     Accepts one or more addenda to be added to the path. Each of the
     *     addenda are automatically prefixed by a directory separator.
     *     (Default: null)
     *
     * @return string
     *     Path to the tests directory.
     */
    public static function getTestsDirectory($addendum = null)
    {
        return self::_getDirectory('Tests', func_get_args());
    }

    /**
     * Web Directory Path
     *
     * @param string $addendum [$addendum ...]
     *     Accepts one or more addenda to be added to the path. Each of the
     *     addenda are automatically prefixed by a directory separator.
     *     (Default: null)
     *
     * @return string
     *     Path to the web directory.
     */
    public static function getWebDirectory($addendum = null)
    {
        return self::_getDirectory('Web', func_get_args());
    }

    /**
     * Initialize Autoloader
     *
     * Configures the Web\Table autoloader and loads the Bootstrap. If the
     * Bootstrap is loaded successfully, the pull() method is executed. If an
     * error is encountered while attempting to load the Bootstrap, it is
     * suppressed.
     *
     * @param string $path [$path ...]
     *     Accepts one or more paths to search in.
     *
     * @return void
     */
    public static function initialize($path)
    {
        self::_addPaths(func_get_args());
        self::_register();

        if (self::load('Web\Table\Bootstrap'))
            Bootstrap::pull();
    }

    /**
     * Autoload Function
     *
     * This function is registered with spl_autoload_register() as part of the
     * initialize() method's actions.
     *
     * @param string $resource
     *     Accepts the name of the resource to load.
     * @param boolean $gentle
     *     If true, no Exception is thrown if the resource cannot be loaded.
     *     (Default: false)
     *
     * @return boolean
     *     Returns true on success; false on failure.
     */
    public static function load($resource, $gentle = false)
    {
        // Trim Leading Namespace Separators
        $resource = ltrim($resource, '\\');

        // If the resource has already been loaded, return true.
        if (self::_check_load($resource))
            return true;

        // If the $name doesn't begin with either "Web\Table" or
        // "\Web\Table" it isn't our problem; return false.
        if (!preg_match('(^(Tests\\\\)?Web\\\\Table)', $resource))
            return false;

        // Initialize File Path. Replace namespace ('\') separators in the
        // namespace. Replace underscore ('_') package separators in only the
        // class name.
        $class = $resource;
        $file  = '';
        if ($last = strrpos($resource, '\\'))
        {
            $namespace = substr($resource, 0, $last);
            $class     = substr($resource, $last + 1);
            $file      = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $file .= str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';

        // Search Paths for Resource
        foreach (self::$_paths as $path)
        {
            if (file_exists($path . DIRECTORY_SEPARATOR . $file))
            {
                require_once $path . DIRECTORY_SEPARATOR . $file;

                if (!$gentle && !self::_check_load($resource))
                    self::_error('AUTOLOADER-MISSING-RESOURCE', $resource, $file);

                return true;
            }
        }

        if (!$gentle)
            self::_error('AUTOLOADER-MISSING-FILE', $resource, $file);

        return false;
    }

    /**
     * Remove Paths
     *
     * Note the path must be specified without a trailing directory separator,
     * even if it was added with one.
     *
     * @param string $path [$path ...]
     *     Accepts one or more paths to remove.
     *
     * @return void
     */
    public static function remove($path)
    {
        foreach (func_get_args() as $path)
            foreach (array_keys(self::$_paths, $path) as $key)
                unset(self::$_paths[$key]);

        self::$_paths = array_values(self::$_paths);
    }

    /**
     * Array of search paths.
     *
     * @var string[integer]
     */
    protected static $_paths;

    /**
     * Whether the Autoloader has been registered.
     *
     * @var boolean
     */
    protected static $_registered;

    /**
     * Add search paths.
     *
     * @param string[] $paths
     *     Array of paths to add.
     *
     * @return void
     */
    protected static function _addPaths($paths)
    {
        foreach ($paths as $path)
            if (is_string($path) && file_exists($path))
                self::$_paths[] = rtrim($path, DIRECTORY_SEPARATOR);
    }

    /**
     * Check if the resource was loaded.
     *
     * @param string $name
     *     Name of the resource.
     *
     * @return boolean
     *     Returns whether the resource was loaded.
     */
    protected static function _check_load($name)
    {
        if (!class_exists($name, false) && !interface_exists($name, false))
            return false;

        return true;
    }

    /**
     * Raise an error using Exception if it is available. Otherwise, the
     * generic \Exception class is used.
     *
     * @param string $key
     *     Accepts the Exception key.
     * @param string $resource
     *     Accepts the name of the resource being loaded.
     * @param string $file
     *     Accepts the path of the file where the resource was expected.
     *
     * @return void
     *
     * @throws Exception('AutoloaderMissingFile')
     *     If the file could not be located.
     * @throws Exception('AutoloaderMissingDefinition')
     *     If the class definition was not found in the file.
     */
    protected static function _error($key, $resource, $file)
    {
        if (self::load('\\Web\\Table\\Exception', true))
            throw Exception::factory($key)->localize($resource, $file);
        elseif ($key === 'AutoloaderMissingFile')
            $message = self::AUTOLOADER_MISSING_FILE;
        elseif ($key === 'AutoloaderMissingDefinition')
            $message = self::AUTOLOADER_MISSING_DEFINITION;
        else
            $message = 'Autoloader Error';

        throw new \Exception(str_replace(array('{0}', '{1}'), array($resource, $file), $message));
    }

    /**
     * Get specified directory path.
     *
     * @param string $directory
     *     Accepts a directory identifier.
     * @param array $addenda
     *     Accepts an array of additional path addenda. Each of the addenda
     *     are automatically prefixed by a directory separator.
     *     (Default: array())
     *
     * @return string
     *     Returns the path to the specified directory. If the requested
     *     directory does not exist, the path to the project root is returned.
     */
    protected static function _getDirectory($directory, $addenda = array())
    {
        // Note that within this function, we cannot use the DS constant which
        // is defined in the Bootstrap class. Since this function is static, it
        // it possible that it could be called before the Bootstrap class is
        // loaded.

        $root = dirname(dirname(dirname(dirname(__FILE__))));
        $rest = implode(DIRECTORY_SEPARATOR, $addenda);

        // Each of the standard directory identifiers points to an array of
        // potential paths which are listed by preference.
        $directories = array
        (
            'Root'          => array('{path.root}',          $root),
            'Binaries'      => array('{path.binaries}',      $root . DIRECTORY_SEPARATOR . 'Binaries'),
            'Build'         => array('{path.build}',         $root . DIRECTORY_SEPARATOR . 'Build'),
            'Cache'         => array('{path.cache}',         $root . DIRECTORY_SEPARATOR . 'Cache'),
            'Configuration' => array('{path.configuration}', $root . DIRECTORY_SEPARATOR . 'Configuration'),
            'Data'          => array('{path.data}',          $root . DIRECTORY_SEPARATOR . 'Data'),
            'Documentation' => array('{path.documentation}', $root . DIRECTORY_SEPARATOR . 'Documentation'),
            'Downloads'     => array('{path.downloads}',     $root . DIRECTORY_SEPARATOR . 'Downloads'),
            'Source'        => array('{path.source}',        $root . DIRECTORY_SEPARATOR . 'Source'),
            'Temporary'     => array('{path.temporary}',     $root . DIRECTORY_SEPARATOR . 'Temporary'),
            'Tests'         => array('{path.tests}',         $root . DIRECTORY_SEPARATOR . 'Tests'),
            'Web'           => array('{path.web}',           $root . DIRECTORY_SEPARATOR . 'Web'),
        );

        foreach ($directories[$directory] as $path)
            if (file_exists($path))
                return rtrim($path . DIRECTORY_SEPARATOR . $rest, DIRECTORY_SEPARATOR);

        return rtrim($root . DIRECTORY_SEPARATOR . $rest, DIRECTORY_SEPARATOR);
    }

    /**
     * Register the Autoloader
     *
     * @return void
     */
    protected static function _register()
    {
        if (!self::$_registered)
        {
            spl_autoload_register('\Web\Table\Autoloader::load');
            self::$_registered = true;
        }
    }
}

// Auto-Initialization
Autoloader::initialize(dirname(dirname(dirname(__FILE__))));