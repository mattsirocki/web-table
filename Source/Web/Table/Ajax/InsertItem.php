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
 * @version    SVN: $Id: InsertItem.php 112 2013-03-10 21:06:02Z ll77ll $
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
 * Web Table Operation: InsertItem
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    Release @release-version@
 * @since      Class available since Initial Release.
 */
class InsertItem extends \Web\Table\Ajax
{
    /**
     * Handle InsertItem (Data)
     *
     * @return void
     */
    public function processData()
    {
        // Error Checking
        if ($this->table === null)
            $this->sendFail('Insert Item', 'You must specify a Table in the request.');
        if (count($this->arguments) != 3)
            $this->sendFail('Insert Item', 'You must specify exactly three arguments in the request.');
        if (!is_string($name = $this->arguments[0]))
            $this->sendFail('Insert Item,', 'The new Item name, the first argument, must be a string.');
        if (!is_string($text = $this->arguments[1]))
            $this->sendFail('Insert Item', 'The new Item text, the second argument, must be a string.');

        // Extract Arguments
        $checkable = $this->arguments[2] === 'on' ? true : false;

        // Perform Modification
        $item = $this->group->insertItem($this->item->index, $name, $text, $checkable);

        // Save Table
        $this->save();

        // Send Response
        $this->sendData(
            'insert-after',
            '#' . $this->item->id(),
            $item->html());
    }

    /**
     * Handle InsertItem (Form)
     *
     * @return void
     */
    public function processForm()
    {
        // Error Checking
        if ($this->table === null)
            $this->sendFail('Insert Item', 'You must specify a Table in the request.');

        // Get Template
        $template = $this->table->template;

        // Construct Message
        $message = 'Please specify the properties of the new Item below:';

        // Construct Item Identifiers
        $name      = $template->htmlFormInputIdentifier($this->table, 'name');
        $text      = $template->htmlFormInputIdentifier($this->table, 'text');
        $checkable = $template->htmlFormInputIdentifier($this->table, 'checkable');

        // Construct Items
        $items = $template->htmlFormItem(
            'Name',
            $template->htmlFormInputText($name));
        $items .= $template->htmlFormItem(
            'Text',
            $template->htmlFormInputText($text));
        $items .= $template->htmlFormItem(
            'Checkable',
            $template->htmlFormInputCheckbox($checkable));

        // Construct Note
        $note = <<<HTML
            <p>
                Click <b>Submit</b> to <b>Insert</b> a new Item after the
                Item <b>{$this->item->name}
                (<code>#{$this->item->index}</code>)</b> in the
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
            'InsertItem',
            $template->jsFormValues($name, $text, $checkable . ':checked'),
            $this->table,
            $this->row,
            $this->cell,
            $this->group,
            $this->item);

        // Send Response
        $this->sendForm(
            'Insert',
            'Insert Item',
            $message,
            $items,
            $note,
            $submit . $close,
            '#' . $name,
            $onsubmit);
    }
}

?>