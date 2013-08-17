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
 * @version    SVN: $Id: CheckItem.php 118 2013-08-17 22:12:38Z matt $
 * @since      File available since Initial Release.
 * @filesource
 */

/*
 * $LastChangedBy: matt $
 * $LastChangedDate: 2013-08-17 18:12:38 -0400 (Sat, 17 Aug 2013) $
 */

/*
 * Specify Namespace
 */
namespace Web\Table\Ajax;

/**
 * Web Table Operation: CheckItem
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    Release @release-version@
 * @since      Class available since Initial Release.
 */
class CheckItem extends \Web\Table\Ajax
{
    /**
     * Handle CheckItem (Data)
     *
     * @return void
     */
    public function processData()
    {
        // Error Checking
        if ($this->table === null)
            $this->sendFail('Check Item', 'You must specify a Table in the request.');
        if (count($this->arguments) != 1)
            $this->sendFail('Check Item', 'You must specify exactly one argument in the request.');

        // Extract Arguments
        $completed = $this->arguments[0] === 'on';

        // Perform Modification
        $this->item->completed = $completed;

        // Save Table
        $this->save();

        // Send Response
        $this->sendData('pass');
    }
}

?>