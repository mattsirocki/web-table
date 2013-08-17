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
 * @version    SVN: $Id: Template.php 117 2013-08-17 17:06:28Z ll77ll $
 * @since      File available since Initial Release.
 * @filesource
 */

/*
 * $LastChangedBy: ll77ll $
 * $LastChangedDate: 2013-08-17 13:06:28 -0400 (Sat, 17 Aug 2013) $
 */

/*
 * Specify Namespace
 */
namespace Web\Table;

/**
 * Web Table Template
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    Release @release-version@
 * @since      Class available since Initial Release.
 */
class Template
{
    /**#@+
     * @var string
     */

    /**
     * Template Description
     */
    public $description;

    /**
     * Template Name
     */
    public $name;

    /**
     * Template Element: Form
     */
    public $form;

    /**
     * Template Element: Form Item
     */
    public $formItem;

    /**
     * Template Element: Table Header
     */
    public $tableHeader;

    /**
     * Template Element: Table Content
     */
    public $tableContent;

    /**
     * Template Element: Table Footer
     */
    public $tableFooter;

    /**
     * Template Element: Row Header
     */
    public $rowHeader;

    /**
     * Template Element: Row Content
     */
    public $rowContent;

    /**
     * Template Element: Row Footer
     */
    public $rowFooter;

    /**
     * Template Element: Cell Header
     */
    public $cellHeader;

    /**
     * Template Element: Cell Content
     */
    public $cellContent;

    /**
     * Template Element: Cell Footer
     */
    public $cellFooter;

    /**
     * Template Element: Group Header
     *
     * @var string
     */
    public $groupHeader;

    /**
     * Template Element: Group Content
     */
    public $groupContent;

    /**
     * Template Element: Group Footer
     */
    public $groupFooter;

    /**
     * Template Element: Item Header
     */
    public $itemHeader;

    /**
     * Template Element: Itemm Checkable Text
     */
    public $itemCheckableText;

    /**
     * Template Element: Item Text
     */
    public $itemText;

    /**
     * Template Element: Item Footer
     */
    public $itemFooter;

    /**#@-*/

    /**
     * Public Constructor
     */
    public function __construct($name)
    {
        // Check $name
        if (!is_string($name))
            throw Exception::factory('OBJECT-CONSTRUCT-TYPE')->
                localize('Template', 'name', 'string');

        // Initialize Fields
        $this->name = $name;
    }

    /**
     * JavaScript to Hide Form
     *
     * @param \Web\Table $table
     *     Accepts the Table.
     *
     * @return void
     */
    public function jsFormHide($table)
    {
        return "WebTable._formHide('$table->name', '$this->name');";
    }

    /**
     * JavaScript Input Values Array
     *
     * Example:
     * <code>
     * var_dump(Template::jsFormValues('a', 'b'));
     * </code>
     *
     * Output:
     * <pre>
     * string(52) "$('#a').val(), $('#b').val()"
     * </pre>
     *
     * @param string $id [$id ...]
     *     Accepts the identifier of a form input.
     *
     * @return string
     *     Returns the JavaScript code.
     */
    public function jsFormValues($id)
    {
        // Value Template
        $value = '$(\'#{id}\').val()';

        // Build Array
        foreach (func_get_args() as $id)
            $js[] = str_replace(array('{id}'), $id, $value);

        return implode(', ', $js);
    }

    /**
     * Create JavaScript Function String
     *
     * @param string $operation
     *     Accepts the name of the operation.
     * @param array|mixed $arguments
     *     Accepts an array of arguments.
     * @param \Web\Table $table
     *     Accepts the Table.
     * @param \Web\Table\Row $row
     *     Accepts the Row.
     * @param \Web\Table\Cell $cell
     *     Accepts the Cell.
     * @param \Web\Table\Group $group
     *     Accepts the Group.
     * @param \Web\Table\Item $item
     *     Accepts the Item.
     *
     * @return string
     *     Returns the JavaScript web_table_request() function call.
     */
    public function jsRequest($operation, $arguments = null, $table = null,
        $row = null, $cell = null, $group = null, $item = null)
    {
        // Cast Arguments
        if ($arguments !== null)
            $arguments = (array) $arguments;

        // Define String Constants
        $q = '\'';
        $c = ', ';

        // Pseudo-Encode Function
        $e = function($v){return str_replace('"', '', json_encode($v));};

        // Build Request
        $request  = 'WebTable._request(';
        $request .= $q . $operation . $q;

        // Add Optional Request Parameters
        if ($arguments !== null || $table !== null || $row !== null || $cell !== null || $group !== null || $item !== null)
            $request .= $c . $e($arguments);
        if ($table !== null || $row !== null || $cell !== null || $group !== null || $item !== null)
            $request .= $c . $q . $table->name . $q;
        if ($row !== null || $cell !== null || $group !== null || $item !== null)
            $request .= $c . $row->index;
        if ($cell !== null || $group !== null || $item !== null)
            $request .= $c . $cell->index;
        if ($group !== null || $item !== null)
            $request .= $c . $group->index;
        if ($item !== null)
            $request .= $c . $item->index;
        $request .= ');';

        return $request;
    }

    /**
     * Create HTML Form Input Button
     *
     * @param \Web\Table $table
     *     Accepts the Table.
     * @param string $value
     *     Value of the button.
     * @param string $click
     *     String to place in the "onclick" attribute.
     *     (Default: '')
     *
     * @return string
     *     Returns the button HTML.
     */
    public function htmlFormInputButton($table, $value, $click = '')
    {
        // Button Template
        $html = '<input onclick="{click}" type="button" value="{value}" />';

        // Determine $onclick
        if ($value === 'Close')
            $click = $this->jsFormHide($table);

        // Perform Replacements
        $html = str_replace('{click}', $click, $html);
        $html = str_replace('{value}', $value, $html);

        return $html;
    }

    /**
     * Create HTML Form Input Checkbox
     *
     * @param string $id
     *     Accepts the identifier of the checkbox.
     * @param boolean $checked
     *     Accepts whether the checkbox is checked.
     *     (Default: false)
     * @param string $click
     *     Accepts the string to place in the "onclick" attribute.
     *     (Default: '')
     * @param string $label
     *     Accepts the string to place in the label.
     *     (Default: '')
     *
     * @return string
     *     Returns the checkbox HTML.
     */
    public function htmlFormInputCheckbox($id, $checked = false, $click = '')
    {
        // Checkbox Template
        $html = '<input id="{id}" type="checkbox" onclick="{click}" />';

        // Checked=Checked
        if ($checked)
            $id .= '" checked="checked';

        // Perform Replacements
        $html = str_replace('{click}', $click, $html);
        $html = str_replace('{id}',       $id, $html);

        return $html;
    }

    /**
     * Create Form Input Identifier
     *
     * @param \Web\Table $table
     *     Accepts the Table.
     * @param string $name
     *     Accepts the name of the input.
     *
     * @return string
     *     Returns the identifier of the input.
     */
    public function htmlFormInputIdentifier($table, $name)
    {
        return $table->id() . '-form-item-input-' . $name;
    }

    /**
     * Generate Form Input Select HTML
     *
     * @param string $id
     *     Accepts the identifier of the select element.
     * @param array $values
     *     Accepts an array of values to use as the select element options.
     * @param string $change
     *     Accepts the string to place in the "onchange" attribute.
     *
     * @return string
     *     Returns the select HTML.
     */
    public function htmlFormInputSelect($id, $values, $selected = null, $change = '')
    {
        // Select Template
        $html = '<select id="{id}" onchange="{change}">{options}</select>';
        $option = '<option value="{value}">{text}</option>';

        // Build Options
        $options = '';
        foreach ($values as $text)
        {
            // selected="selected"
            $value = $text;
            if ($value === $selected)
                $value .= '" selected="selected';

            // Perform Replacements
            $options .= str_replace('{text}',   $text, $option);
            $options  = str_replace('{value}', $value, $options);
        }

        // Perform Replacements
        $html = str_replace('{change}',   $change, $html);
        $html = str_replace('{id}',           $id, $html);
        $html = str_replace('{options}', $options, $html);

        return $html;
    }

    /**
     * Create HTML Form Input Submit
     *
     * @param string $value
     *     Accepts the value of the button.
     *
     * @return string
     *     Returns the submit button HTML.
     */
    public function htmlFormInputSubmit($value)
    {
        // Button Template
        $html = '<input type="submit" value="{value}" />';

        // Perform Replacements
        $html = str_replace('{value}', $value, $html);

        return $html;
    }

    /**
     * Create HTML Form Input Text
     *
     * @param string $id
     *     Accepts the identifier of the input.
     * @param string $value
     *     Accepts the value of the input.
     *     (Default: '')
     *
     * @return string
     *     Returns the input HTML.
     */
    public function htmlFormInputText($id, $value = '')
    {
        // Template
        $html = '<input id="{id}" type="text" value="{value}" />';

        // Perform Replacements
        $html = str_replace('{id}',                         $id, $html);
        $html = str_replace('{value}', htmlspecialchars($value), $html);

        return $html;
    }

    /**
     * Create HTML Form Input Text Area
     *
     * @param string $id
     *     Accepts the identifier of the input.
     * @param string $value
     *     Accepts the value of the input.
     *     (Default: '')
     *
     * @return string
     *     Returns the input HTML.
     */
    public function htmlFormInputArea($id, $value = '')
    {
        // Template
        $html = '<textarea id="{id}">{value}</textarea>';

        // Perform Replacements
        $html = str_replace('{id}',                         $id, $html);
        $html = str_replace('{value}', htmlspecialchars($value), $html);

        return $html;
    }

    /**
     * Create HTML Form Item
     *
     * @param string $name
     *     Accepts the name of the item.
     *     (Default: '')
     * @param string $input
     *     Accepts the input HTML.
     *     (Default: '')
     *
     * @return string
     *     Returns the item HTML.
     */
    public function htmlFormItem($name = '', $input = '', $note = '')
    {
        // Item Template
        $html = $this->formItem;

        // Perform Replacements
        $html = str_replace('{form-item-name}',   $name, $html);
        $html = str_replace('{form-item-input}', $input, $html);
        $html = str_replace('{form-item-note}',   $note, $html);

        return $html;
    }

    /**
     * Load Saved Template
     *
     * @param string $name
     *     Accepts the name of the Template.
     *
     * @return \Web\Table\Template
     */
    public static function load($name)
    {
        // Get Template Resource Path
        $path = self::path($name);

        // Check if Path Exists
        if (!file_exists($path))
            throw Exception::factory('LOAD-EXISTENCE')->
                localize('Template', $name, $path);

            // Check if Directory is Readable
        if (!is_readable(dirname($path)))
            throw Exception::factory('LOAD-DIRECTORY')->
            localize('Template', $name, dirname($path));

        // Check if File is Readable
        if (!is_readable($path))
            throw Exception::factory('LOAD-FILE')->
            localize('Template', $name, $path);

        // Attempt to Read File
        if (($contents = @file_get_contents($path)) === false)
            throw Exception::factory('LOAD-IO')->
            localize('Template', $name, $path);

        // Parse Template File
        $pattern = '#{% ([a-z-]+) %}\n(.*?)(?<=\n){% end %}#ms';
        preg_match_all($pattern, $contents, $matches);

        // Template Data Array
        $data = array_combine($matches[1], $matches[2]);

        // Template Elements
        $elements = array
        (
            'description'            => 'description',
            'form'                   => 'form',
            'form-item'              => 'formItem',
            'table-header'           => 'tableHeader',
            'table-content'          => 'tableContent',
            'table-footer'           => 'tableFooter',
            'row-header'             => 'rowHeader',
            'row-content'            => 'rowContent',
            'row-footer'             => 'rowFooter',
            'cell-header'            => 'cellHeader',
            'cell-content'           => 'cellContent',
            'cell-footer'            => 'cellFooter',
            'group-header'           => 'groupHeader',
            'group-content'          => 'groupContent',
            'group-footer'           => 'groupFooter',
            'item-header'            => 'itemHeader',
            'item-checkable-content' => 'itemCheckableContent',
            'item-content'           => 'itemContent',
            'item-footer'            => 'itemFooter',
        );

        // Check Elements
        $template = new Template($name);
        foreach ($elements as $index => $field)
        {
            if (!isset($data[$index]))
                throw Exception::factory('TEMPLATE-ELEMENT')->
                    localize($name, $path, $index);
            else
                $template->$field = $data[$index];
        }

        return $template;
    }

    /**
     * Get Template Resource Path
     *
     * @param string $name
     *     Accepts the name of the Template.
     *
     * @return string
     *     Returns the path to the Template resource.
     */
    public static function path($name)
    {
        // Define Resource Filepath
        return Autoloader::getDataDirectory('Templates', $name, $name.'.tpl');
    }
}

?>