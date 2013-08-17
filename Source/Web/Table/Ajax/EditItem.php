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
 * @version    SVN: $Id: EditItem.php 118 2013-08-17 22:12:38Z matt $
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
 * Web Table Operation: EditItem
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    Release @release-version@
 * @since      Class available since Initial Release.
 */
class EditItem extends \Web\Table\Ajax
{
    /**
     * Handle EditItem (Data)
     *
     * @return void
     */
    public function processData()
    {
        // Error Checking
        if ($this->table === null)
            $this->sendFail('Edit Item', 'You must specify a Table in the request.');
        if (count($this->arguments) != 3)
            $this->sendFail('Edit Item', 'You must specify exactly three arguments in the request.');
        if (!is_string($name = $this->arguments[0]))
            $this->sendFail('Edit Item', 'The Item name, the first argument, must be a string.');
        if (!is_string($text = $this->arguments[1]))
            $this->sendFail('Edit Item', 'The Item text, the second argument, must be a string.');

        // Extract Arguments
        $checkable = $this->arguments[2] === 'on' ? true : false;

        // Perform Modification
        $this->item->name      = htmlspecialchars_decode($name);
        $this->item->text      = htmlspecialchars_decode($text);
        $this->item->checkable = $checkable;

        // Save Table
        $this->save();

        // Send Response
        $this->sendData(
            'html',
            '#' . $this->item->id('content'),
            $this->item->html('item-content'));
    }

    /**
     * Handle EditItem (Form)
     *
     * @return void
     */
    public function processForm()
    {
        // Error Checking
        if ($this->table === null)
            $this->sendFail('Edit Item', 'You must specify a Table in the request.');

        // Get Template
        $template = $this->table->template;

        // Construct Message
        $message  = 'Please edit the properties of the Item below:';

        // Construct Item Identifiers
        $name      = $template->htmlFormInputIdentifier($this->table, 'name');
        $text      = $template->htmlFormInputIdentifier($this->table, 'text');
        $checkable = $template->htmlFormInputIdentifier($this->table, 'checkable');

        // Construct Items
        $items = $template->htmlFormItem(
            'Name',
            $template->htmlFormInputText($name, $this->item->name));
        $items .= $template->htmlFormItem(
            'Text',
            $template->htmlFormInputArea($text, $this->item->text));
        $items .= $template->htmlFormItem(
            'Checkable',
            $template->htmlFormInputCheckbox($checkable, $this->item->checkable));

        // Construct Note
        $note = <<<HTML
            <p>
                Click <b>Submit</b> to <b>Change</b> the properties of the
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
            'EditItem',
            $template->jsFormValues($name, $text, $checkable . ':checked'),
            $this->table,
            $this->row,
            $this->cell,
            $this->group,
            $this->item);

        // Send Response
        $this->sendForm(
            'edit',
            'Edit Item',
            $message,
            $items,
            $note,
            $submit . $close,
            '#' . $name,
            $onsubmit);
    }
}

?>