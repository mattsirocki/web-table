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
 * @version    SVN: $Id: EditTable.php 118 2013-08-17 22:12:38Z matt $
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
 * Web Table Operation: EditTable
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    Release @release-version@
 * @since      Class available since Initial Release.
 */
class EditTable extends \Web\Table\Ajax
{
    /**
     * Handle EditTable (Data)
     *
     * @return void
     */
    public function processData()
    {
        // Error Checking
        if ($this->table === null)
            $this->sendFail('Edit Table', 'You must specify a Table in the request.');
        if (count($this->arguments) != 1)
            $this->sendFail('Edit Table', 'You must specify exactly one argument in the request.');
        if (!is_string($alias = $this->arguments[0]))
            $this->sendFail('Edit Table', 'The Table alias, the first argument, must be a string.');

        // Perform Modification
        $this->table->alias = htmlspecialchars_decode($alias);

        // Save Table
        $this->save();

        // Send Response
        $this->sendData(
            'html',
            '#' . $this->table->id('content'),
            $this->table->html('table-content'));
    }

    /**
     * Handle EditTable (Form)
     *
     * @return void
     */
    public function processForm()
    {
        // Error Checking
        if ($this->table === null)
            $this->sendFail('Edit Table', 'You must specify a Table in the request.');

        // Get Template
        $template = $this->table->template;

        // Construct Message
        $message  = 'Please edit the alias of the Table below:';


        // Construct Item Identifiers
        $alias = $template->htmlFormInputIdentifier($this->table, 'alias');

        // Construct Items
        if ($this->table->alias !== $this->table->name)
        {
            $note = <<<HTML
                <p>
                    Note that we make a distinction between the <b>name</b> of a
                    Table and its <b>alias</b>.
                </p>
                <p>
                    We find the syntax <b>Alias (<code>#name</code>)</b> a
                    convenient way to specify the name and alias of a Table. The
                    alias and name of this table are <b>{$this->table->name}</b>
                    and <b>{$this->table->alias}</b>, respectively. Thus, this Table
                    may be specified by <b>{$this->table->alias}
                    (<code>#{$this->table->name}</code>)</b>.
                </p>
                <p>
                    You should <b>use the name of a Table to load it</b>. For example, the
                    correct way to load this Table is given by:
                </p>
                <code>
                    // Correct way to load this Table.<br />
                    WebTable.load('{$this->table->name}');
                </code>
                <p>
                    Whereas using the alias is incorrect:
                </p>
                <code>
                    // Incorrect way to load this Table.<br />
                    WebTable.load('{$this->table->alias}');
                </code>
                <p>
                    An easy way to remember the difference is that an alias is for only
                    presentational purposes.
                </p>
HTML;
        }
        else
            $note = '';

        $items = $template->htmlFormItem(
            'Alias',
            $template->htmlFormInputText($alias, $this->table->alias),
            $note);

        // Construct Note
        $note = <<<HTML
            <p>
                Click <b>Submit</b> to <b>Change</b> the alias of the
                Table <b>{$this->table->alias}
                (<code>#{$this->table->name}</code>)</b>.
            </p>
HTML;

        // Construct Buttons
        $submit = $template->htmlFormInputSubmit('Submit');
        $close  = $template->htmlFormInputButton($this->table, 'Close');

        // On-Submit Script
        $onsubmit = $template->jsRequest(
            'EditTable',
            $template->jsFormValues($alias),
            $this->table);

        // Send Response
        $this->sendForm(
            'edit',
            'Edit Table',
            $message,
            $items,
            $note,
            $submit . $close,
            '#' . $alias,
            $onsubmit);
    }
}

?>