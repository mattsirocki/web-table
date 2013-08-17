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
 * @version    SVN: $Id: LoadTemplate.php 112 2013-03-10 21:06:02Z ll77ll $
 * @since      File available since Initial Release.
 * @filesource
 */

/*
 * $LastChangedBy: ll77ll $
 * $LastChangedDate: 2013-03-10 17:06:02 -0400 (Sun, 10 Mar 2013) $
 */

/*
 * Specify Namespace
 */
namespace Web\Table\Ajax;

/*
 * Specify Usages
 */
use \Web\Table\Autoloader;
use \Web\Table\Exception;

/**
 * web Table Operation: LoadTemplate
 *
 * Dynamically loads template files into the DOM head. Each template may define
 * a single CSS and JavaScript file.
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    Release @release-version@
 * @since      Class available since Initial Release.
 */
class LoadTemplate extends \Web\Table\Ajax
{
    /**
     * Handle LoadTemplate (Data)
     *
     * @return void
     */
    public function processData()
    {
        // Error Checking
        if (count($this->arguments) != 1)
            $this->sendFail('Load Template', 'You must specify exactly one argument in the request.');
        if (!is_string($name = $this->arguments[0]))
            $this->sendFail('Load Template', 'The Template name, the first argument, must be a string.');

        // Manage Load History
        if (!isset($_SESSION['WebTable']['-templates']))
            $_SESSION['WebTable']['-templates'] = array();
        if (in_array($name, $_SESSION['WebTable']['-templates']))
            $this->sendData('pass');
        array_push($_SESSION['WebTable']['-templates'], $name);

        // Template Paths
        $dir_base = Autoloader::getDataDirectory('Templates', $name);
        $www_base = implode(WS, array($_SESSION['WebTable']['-root'], 'Data',
            'Templates', $name));

        // Check Template CSS
        $css = '<link href="%s" media="screen" rel="stylesheet" />';
        if (file_exists($dir_base . DS . $name . '.css'))
            $css = sprintf($css, $www_base . WS . $name . '.css');
        else
            $css = '';

        // Check Template JavaScript
        if (file_exists($dir_base . DS . $name . '.js'))
            $js = $www_base . WS . $name . '.js';
        else
            $js = '';

        // Send Response
        $this->sendData(
            'append', 'head', $css,
            'template-script', $js, null);
    }
}

?>