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
 * @version    SVN: $Id: Initialize.php 112 2013-03-10 21:06:02Z ll77ll $
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

/**
 * Web Table Operation: Initialize
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    Release @release-version@
 * @since      Class available since Initial Release.
 */
class Initialize extends \Web\Table\Ajax
{
    /**
     * Handle Initialize (Data)
     *
     * @return void
     */
    public function processData()
    {
        // Error Checking
        if (count($this->arguments) != 1)
            $this->sendFail('Initialize', 'You must specify exactly one argument in the request.');
        if (!is_string($root = $this->arguments[0]))
            $this->sendFail('Initialize', 'The path to the Web Table Project root, the first argument, must be a string.');

        // Unset Session Values
        unset($_SESSION['WebTable']);

        // Set Web Root
        $_SESSION['WebTable']['-root'] = $root;
        $_SESSION['WebTable']['-templates'] = array();

        // Send Response
        $this->sendData('pass');
    }
}

?>