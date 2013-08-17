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
 * @version    SVN: $Id: AppendCell.php 112 2013-03-10 21:06:02Z ll77ll $
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
use \Web\Table\Template;

/**
 * Web Table Operation: AppendCell
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    Release @release-version@
 * @since      Class available since Initial Release.
 */
class AppendCell extends \Web\Table\Ajax
{
    /**
     * Handle AppendCell (Data)
     *
     * @return void
     */
    public function processData()
    {
        // Error Checking
        if ($this->table === null)
            $this->sendFail('Append Cell', 'You must specify a Table in the request.');
        if (count($this->arguments) != 1)
            $this->sendFail('Append Cell', 'You must specify exactly one argument in the request.');
        if (!is_string($name = $this->arguments[0]))
            $this->sendFail('Append Cell', 'The new Cell name, the first argument, must be a string.');

        // Perform Modification
        $cell = $this->row->appendCell($name);

        // Save Table
        $this->save();

        // Send Response
        $this->sendData(
            'append',
            '#' . $this->row->id('children'),
            $cell->html());
    }

    /**
     * Handle AppendCell (Form)
     *
     * @return void
     */
    public function processForm()
    {
        // Error Checking
        if ($this->table === null)
            $this->sendFail('Append Cell', 'You must specify a Table in the request.');

        // Get Template
        $template = $this->table->template;

        // Construct Message
        $message = 'Please specify the name of the new Cell below:';

        // Construct Item Identifiers
        $name = $template->htmlFormInputIdentifier($this->table, 'name');

        // Construct Items
        $items = $template->htmlFormItem(
            'Name',
            $template->htmlFormInputText($name));

        // Construct Note
        $note = <<<HTML
            <p>Click <b>Submit</b> to <b>Append</b> a new Cell to the
            Row <b>{$this->row->name}
            (<code>#{$this->row->index}</code>)</b> in the
            Table <b>{$this->table->alias}
            (<code>#{$this->table->name}</code>)</b>.</p>
HTML;

        // Construct Buttons
        $submit = $template->htmlFormInputSubmit('Submit');
        $close  = $template->htmlFormInputButton($this->table, 'Close');

        // On-Submit Script
        $onsubmit = $template->jsRequest(
            'AppendCell',
            $template->jsFormValues($name),
            $this->table,
            $this->row);

        // Send Response
        $this->sendForm(
            'append',
            'Append Cell',
            $message,
            $items,
            $note,
            $submit . $close,
            '#' . $name,
            $onsubmit);
    }
}

?>