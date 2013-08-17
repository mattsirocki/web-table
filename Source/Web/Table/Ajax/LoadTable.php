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
 * @version    SVN: $Id: LoadTable.php 117 2013-08-17 17:06:28Z ll77ll $
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
namespace Web\Table\Ajax;

use Web\Table\Autoloader;
use Web\Table\Table;

/**
 * Web Table Operation: LoadTable
 *
 * Load the Table HTML into the target element.
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    Release @release-version@
 * @since      Class available since Initial Release.
 */
class LoadTable extends \Web\Table\Ajax
{
    /**
     * Handle LoadTable (Data)
     *
     * @return void
     */
    public function processData()
    {
        // Error Checking
        //if ($this->table === null)
        //    $this->sendFail('Load Table', 'You must specify a Table in the request.');
        if (count($this->arguments) != 4)
            $this->sendFail('Load Table', 'You must specify exactly four arguments in the request.');
        if (!is_bool($cache = $this->arguments[0]))
            $this->sendFail('Load Table', 'The Table cache flag, the first argument, must be a boolean.');
        if (($path = $this->arguments[1]) !== null && !is_string($path))
            $this->sendFail('Load Table', 'The Table storage path, the second argument, must be a string or null.');
        if (!is_string($target = $this->arguments[2]))
            $this->sendFail('Load Table', 'The Table load target, the third argument, must be a string.');
        if (!is_string($name = $this->arguments[3]))
            $this->sendFail('Load Table', 'The Table name, the fourth argument, must be a string.');

        // Load Table? :)
        $this->table = Table::load($name, $path);

        // Set Session Variables
        $_SESSION['WebTable'][$name]['cache']  = $cache;
        $_SESSION['WebTable'][$name]['path']   = $path;
        $_SESSION['WebTable'][$name]['target'] = $target;
        $_SESSION['WebTable'][$name]['table']  = $this->table;

        $template = $this->table->template->name;

        // Manage Load History
        if (!isset($_SESSION['WebTable']['-templates']))
            $_SESSION['WebTable']['-templates'] = array();
        if (in_array($template, $_SESSION['WebTable']['-templates']))
            $this->sendData('html', $target, $this->table->html());

        array_push($_SESSION['WebTable']['-templates'], $template);

        // Template Paths
        $path_template = Autoloader::getDataDirectory('Templates', $template);
        $path_www      = implode(WS, array($_SESSION['WebTable']['-root'], 'Data', 'Templates', $template));

        // Template Flags
        $is_css = file_exists($path_template . DS . $template . '.css');
        $is_js  = file_exists($path_template . DS . $template . '.js');

        // Check Template CSS/JS
        $css = '<link href="%s" media="screen" rel="stylesheet" />';
        $css = $is_css ? sprintf($css, $path_www . WS . $template . '.css') : '';
        $js  = $is_js ? $path_www . WS . $template . '.js' : '';

        // Send Response
        $this->sendData
        (
            'append',          'head',  $css,
            'template-script', $js,     null,
            'html',            $target, $this->table->html()
        );
    }
}

?>