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
 * @version    SVN: $Id: RemoveItem.php 112 2013-03-10 21:06:02Z ll77ll $
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
 * Web Table Operation: RemoveItem
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    Release @release-version@
 * @since      Class available since Initial Release.
 */
class RemoveItem extends \Web\Table\Ajax
{
    /**
     * Handle RemoveItem (Data)
     *
     * @return void
     */
    public function processData()
    {
        // Error Checking
        if ($this->table === null)
            $this->sendFail('Remove Item', 'You must specify a Table in the request.');
        if (count($this->arguments) != 0)
            $this->sendFail('Remove Item', 'You must specify exactly zero arguments in the request.');

        // Perform Modification
        $this->group->removeItem($this->item->index);

        // Save Table
        $this->save();

        // Send Response
        $this->sendData(
            'remove',
            '#' . $this->item->id());
    }

    /**
     * Handle RemoveItem (Form)
     *
     * @return void
     */
    public function processForm()
    {
        // Error Checking
        if ($this->table === null)
            $this->sendFail('Remove Item', 'You must specify a Table in the request.');

        // Get Template
        $template = $this->table->template;

        // Construct Message
        $message = <<<HTML
            Please confirm that you wish to remove the Item
            <b>{$this->item->name} (<code>#{$this->item->index}</code>)</b>.
HTML;

        // Construct Items
        $items = null;

        // Construct Note
        $note = <<<HTML
            <p>
                Click <b>Confirm</b> to <b>Remove</b> the
                Item <b>{$this->item->name}
                (<code>#{$this->item->index}</code>)</b> from the
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
        $confirm = $template->htmlFormInputSubmit('Confirm');
        $close   = $template->htmlFormInputButton($this->table, 'Close');

        // On-Submit Script
        $onsubmit = $template->jsRequest(
            'RemoveItem',
            array(),
            $this->table,
            $this->row,
            $this->cell,
            $this->group,
            $this->item);

        // Send Response
        $this->sendForm(
            'remove',
            'Remove Item',
            $message,
            $items,
            $note,
            $confirm . $close,
            null,
            $onsubmit);
    }
}

?>