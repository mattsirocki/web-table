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
 * @version    SVN: $Id: EditTemplate.php 112 2013-03-10 21:06:02Z ll77ll $
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
use \Web\Table\Template;

/**
 * Web Table Operation: EditTemplate
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    Release @release-version@
 * @since      Class available since Initial Release.
 */
class EditTemplate extends \Web\Table\Ajax
{
    /**
     * Handle EditTemplate (Data)
     *
     * @return void
     */
    public function processData()
    {
        // Error Checking
        if ($this->table === null)
            $this->sendFail('Edit Template', 'You must specify a Table in the request.');
        if (count($this->arguments) != 2)
            $this->sendFail('Edit Template', 'You must specify exactly two arguments in the request.');
        if (!is_bool($change = $this->arguments[0]))
            $this->sendFail('Edit Template', 'The change flag, the first argument, must be a boolean.');
        if (!is_string($name = $this->arguments[1]))
            $this->sendFail('Edit Template', 'The Template name, the second argument, must be a string.');

        // Change to Same Template?
        if ($change)
        {
            if ($name === $this->table->template->name)
                $this->sendData('pass');
        }

        // Load Template
        $template = Template::load($name);

        // Update Form Description
        if (!$change)
            $this->sendData(
                'form',
                '#' . $this->table->template->htmlFormInputIdentifier($this->table, 'select-note'),
                $template->description);


        // Perform Modification
        $this->table->template = $template;

        // Save Table
        $this->save();

        // Send Response
        $this->sendData(
            'template-change',
            '#' . $this->table->id(),
            $this->table->html());
    }

    /**
     * Handle EditTemplate (Form)
     *
     * @return void
     */
    public function processForm()
    {
        // Error Checking
        if ($this->table === null)
            $this->sendFail('Edit Template', 'You must specify a Table in the request.');

        // Get Array of Templates
        $root      = Autoloader::getDataDirectory('Templates');
        $templates = array();
        foreach (scandir($root) as $name)
        {
            try
            {
                if (is_dir($root . DS . $name) && $name[0] !== '.')
                    $templates[$name] = Template::load($name);
            }
            catch (Exception $e)
            {
                // Invalid Template...
                trigger_error($e->getMessage(), E_USER_NOTICE);
            }
        }

        // Get Template
        $template = $this->table->template;

        // Construct Message
        $message  = 'Please select the desired Template below:';

        // Construct Item Identifiers
        $select      = $template->htmlFormInputIdentifier($this->table, 'select');
        $select_note = $template->htmlFormInputIdentifier($this->table, 'select-note');

        // Construct Items
        $note  = "<div id=\"$select_note\">$template->description</div>";
        $items = $template->htmlFormItem(
            'Template',
            $template->htmlFormInputSelect(
                $select,
                array_keys($templates),
                $template->name,
                $template->jsRequest(
                    'EditTemplate',
                    array(false, $template->jsFormValues($select)),
                    $this->table)),
            $note);

        // Construct Note
        $note = <<<HTML
            <p>
                The current Template is <b>{$template->name}</b>.
            </p>
            <p>
                Click <b>Submit</b> to <b>Change</b> the Template of the
                Table <b>{$this->table->alias}
                (<code>#{$this->table->name}</code>)</b>.
            </p>
HTML;

        // Construct Buttons
        $submit = $template->htmlFormInputSubmit('Submit');
        $close  = $template->htmlFormInputButton($this->table, 'Close');

        // On-Submit Script
        $onsubmit = $template->jsRequest(
            'EditTemplate',
            array(true, $template->jsFormValues($select)),
            $this->table);

        // Send Response
        $this->sendForm(
            'edit',
            'Edit Template',
            $message,
            $items,
            $note,
            $submit . $close,
            '#' . $select,
            $onsubmit);
    }
}

?>