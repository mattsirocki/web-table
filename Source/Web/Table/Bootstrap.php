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
 * @version    SVN: $Id: Bootstrap.php 113 2013-03-13 02:50:17Z ll77ll $
 * @since      File available since Initial Release.
 * @filesource
 */

/*
 * $LastChangedBy: ll77ll $
 * $LastChangedDate: 2013-03-12 22:50:17 -0400 (Tue, 12 Mar 2013) $
 */

/*
 * Specify Namespace
 */
namespace Web\Table;

/**
 * Bootstrap
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    Release @release-version@
 * @since      Class available since Initial Release.
 */
class Bootstrap extends Object
{
    /**
     * Directory Separator Reference Constant
     *
     * @var string
     */
    const DS = DIRECTORY_SEPARATOR;

    /**
     * Newline Reference Constant
     *
     * @var string
     */
    const NL = "\n";

    /**
     * Namespace Separator Reference Constant
     *
     * @var string
     */
    const NS = "\\";

    /**
     * Carriage Return Reference Constant
     *
     * @var string
     */
    const RT = "\r";

    /**
     * Tab Reference Constant
     *
     * @var string
     */
    const TB = "\t";

    /**
     * Web Separator Reference Constant
     *
     * @var string
     */
    const WS = "/";

    /**
     * Pull!
     */
    public static function pull()
    {
        // Configure Error Reporting
        ini_set('display_errors', false);
        ini_set('error_reporting', E_ALL);
        ini_set('error_log', Autoloader::getTemporaryDirectory('errors.log'));

        // Define Constants
        if (!defined('DS'))
            define('DS', Bootstrap::DS);
        if (!defined('NL'))
            define('NL', Bootstrap::NL);
        if (!defined('NS'))
            define('NS', Bootstrap::NS);
        if (!defined('RT'))
            define('RT', Bootstrap::RT);
        if (!defined('TB'))
            define('TB', Bootstrap::TB);
        if (!defined('WS'))
            define('WS', Bootstrap::WS);

        // Check Constants
        if (DS !== self::DS)
            throw Exception::factory('BOOTSTRAP-CONSTANT')->
                localize('DS', self::_e(DS), self::_e(self::DS));
        if (NL !== self::NL)
            throw Exception::factory('BOOTSTRAP-CONSTANT')->
                localize('NL', self::_e(NL), self::_e(self::NL));
        if (NS !== self::NS)
            throw Exception::factory('BOOTSTRAP-CONSTANT')->
                localize('NS', self::_e(NS), self::_e(self::NS));
        if (RT !== self::RT)
            throw Exception::factory('BOOTSTRAP-CONSTANT')->
                localize('RT', self::_e(RT), self::_e(self::RT));
        if (TB !== self::TB)
            throw Exception::factory('BOOTSTRAP-CONSTANT')->
                localize('TB', self::_e(TB), self::_e(self::TB));
        if (WS !== self::WS)
            throw Exception::factory('BOOTSTRAP-CONSTANT')->
                localize('WS', self::_e(WS), self::_e(self::WS));
    }
}

?>