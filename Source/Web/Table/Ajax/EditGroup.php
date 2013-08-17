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
 * @version    SVN: $Id: EditGroup.php 118 2013-08-17 22:12:38Z matt $
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

/*
 * Specify Usages
 */
use \Web\Table\Template;

/**
 * Web Table Operation: EditGroup
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    Release @release-version@
 * @since      Class available since Initial Release.
 */
class EditGroup extends \Web\Table\Ajax
{
    /**
     * Handle EditGroup (Data)
     *
     * @return void
     */
    public function processData()
    {
        // Error Checking
        if ($this->table === null)
            $this->sendFail('Edit Group Name', 'You must specify a Table in the request.');
        if (count($this->arguments) != 1)
            $this->sendFail('Edit Group Name', 'You must specify exactly one argument in the request.');
        if (!is_string($name = $this->arguments[0]))
            $this->sendFail('Edit Group Name', 'The Group name, the first argument, must be a string.');

        // Perform Modification
        $this->group->name = htmlspecialchars_decode($name);

        // Save Table
        $this->save();

        // Send Response
        $this->sendData(
            'html',
            '#' . $this->group->id('content'),
            $this->group->html('group-content'));
    }

    /**
     * Handle EditGroup (Form)
     *
     * @return void
     */
    public function processForm()
    {
        // Error Checking
        if ($this->table === null)
            $this->sendFail('Edit Group Name', 'You must specify a Table in the request.');

        // Get Template
        $template = $this->table->template;

        // Construct Message
        $message  = 'Please edit the name of the Group below:';

        // Construct Item Identifiers
        $name = $template->htmlFormInputIdentifier($this->table, 'name');

        // Construct Items
        $items = $template->htmlFormItem(
            'Name',
            $template->htmlFormInputText($name, $this->group->name));

        // Construct Note
        $note = <<<HTML
            <p>
                Click <b>Submit</b> to <b>Change</b> the name of the
                Group <b>{$this->group->name}
                (<code>#{$this->group->index}</code>)</b> in the
                Cell <b>{$this->cell->name}
                (<code>#{$this->cell->index}</code>)</b> in the
                Row <b>{$this->row->name}
                (<code>#{$this->row->index}</code>)</b> in the
                Table <b>{$this->table->alias}
                (<code>#{$this->table->name}</code>)</b>.
            </p>
HTML;

        // Construct Buttons
        $submit = $template->htmlFormInputSubmit('Submit');
        $close  = $template->htmlFormInputButton($this->table, 'Close');

        // On-Submit Script
        $onsubmit = $template->jsRequest(
            'EditGroup',
            $template->jsFormValues($name),
            $this->table,
            $this->row,
            $this->cell,
            $this->group);

        // Send Response
        $this->sendForm(
            'edit',
            'Edit Group Name',
            $message,
            $items,
            $note,
            $submit . $close,
            '#' . $name,
            $onsubmit);
    }
}

?>