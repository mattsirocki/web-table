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
 * @version    SVN: $Id: Table.php 112 2013-03-10 21:06:02Z ll77ll $
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
namespace Web\Table;

/**
 * Web Table
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    Release @release-version@
 * @since      Class available since Initial Release.
 */
class Table extends Object
{
    /**
     * Table Name Alias
     *
     * If the name of the Table is to be changed after creation, it should be
     * changed here.
     *
     * @var string
     */
    public $alias;

    /**
     * Parent of this Table
     *
     * @var Table
     */
    public $parent;

    /**
     * Table Template
     *
     * @var Template
     */
    public $template;

    /**
     * Public Constructor
     *
     * @param string $name
     *     Accepts the name of the new Table.
     * @param string $template
     *     Accepts either the name of the Template to load or an actual Template
     *     object.
     *     (Default: 'Default')
     *
     * @return void
     */
    public function __construct($name, $template = 'Default')
    {
        // Check $name
        if (!is_string($name))
            throw Exception::factory('OBJECT-CONSTRUCT-TYPE')->
                localize('Table', 'name', 'string');
        if (!preg_match('(^[a-z0-9][a-z0-9-]*$)', $name))
            throw Exception::factory('TABLE-NAME-INVALID')->localize($name);

        // Check $template
        if ($template instanceof Template)
            $this->template = $template;
        else
            $this->template = Template::load($template);

        // Initialize Fields
        $this->alias     = $name;
        $this->index     = null;
        $this->name      = $name;
        $this->parent    = $this;
        $this->_children = array();
    }

    /**
     * Append Row
     *
     * @param string|Row $row
     *     Accepts either the name of the Row or an actual Row object.
     * @param null|integer $index
     *     Accepts the index of Row.
     *     (Default: null)
     *
     * @return Row
     *     Returns the appended Row.
     */
    public function appendRow($row, $index = null)
    {
        if ($row instanceof Row)
            $child = $row;
        else
            $child = new Row($row);

        return $this->_appendChild($child, $index, 'Row');
    }

    /**
     * Clear Rows
     *
     * @return void
     */
    public function clearRows()
    {
        $this->_clearChildren();
    }

    /**
     * Remove Row
     *
     * @param integer $index
     *     Accepts the index of the Row to remove.
     *
     * @return void
     */
    public function removeRow($index)
    {
        $this->_removeChild($index, 'Row');
    }

    /**
     * Get Row
     *
     * @param integer $index
     *     Accepts the index of the Row to get.
     *
     * @return Row
     *     Returns the specified Row.
     */
    public function getRow($index)
    {
        return $this->_getChild($index, 'Row');
    }

    /**
     * Insert Row
     *
     * @param integer $index
     *     Accepts the index of an existing Row. The new Row will be inserted
     *     after the Row specified by this index.
     * @param string|Row $row
     *     Accepts either the name of the Row or an actual Row object.
     *
     * @return Row
     *     Returns the inserted Row.
     */
    public function insertRow($index, $row)
    {
        if ($row instanceof Row)
            $child = $row;
        else
            $child = new Row($row);

        return $this->_insertChild($index, $child, 'Row');
    }

    /**
     * Prepend Row
     *
     * @param string|Row $row
     *     Accepts either the name of the Row or an actual Row object.
     * @param null|integer $index
     *     Accepts the index of the Row.
     *     (Default: null)
     *
     * @return Row
     *     Returns the prepended Row.
     */
    public function prependRow($row, $index = null)
    {
        if ($row instanceof Row)
            $child = $row;
        else
            $child = new Row($row);

        return $this->_prependChild($child, $index, 'Row');
    }

    /**
     * Create HTML Output
     *
     * @param boolean|string $select
     *     Accepts flag indicating what should be returned. The following values
     *     are valid:
     *     <ul>
     *       <li> false         - Return everything.
     *       <li> true          - Only return children.
     *       <li> table-header  - Only return header.
     *       <li> table-content - Only return content.
     *       <li> table-footer  - Only return footer.
     *       <li> form          - Only return form.
     *     </ul>
     *     (Default: false)
     *
     * @return string
     *     Returns the HTML.
     */
    public function html($select = false)
    {
        // Grab Template Elements
        $header  = $this->template->tableHeader;
        $content = $this->template->tableContent;
        $footer  = $this->template->tableFooter;
        $form    = $this->template->form;

        // Menu Request Strings
        $menu_append_row    = $this->template->jsRequest('AppendRow',    null, $this);
        $menu_prepend_row   = $this->template->jsRequest('PrependRow',   null, $this);
        $menu_clear_rows    = $this->template->jsRequest('ClearRows',    null, $this);
        $menu_edit_table    = $this->template->jsRequest('EditTable',    null, $this);
        $menu_edit_template = $this->template->jsRequest('EditTemplate', null, $this);

        // Get Children HTML
        $children = '';
        foreach ($this->_children as $child)
            $children .= $child->html($select);

        // Perform Replacements
        $replacements = array
        (
            '{template:table-header}'  => $this->template->tableHeader,
            '{template:table-content}' => $this->template->tableContent,
            '{template:table-footer}'  => $this->template->tableFooter,
            '{template:form}'          => $this->template->form,
            'template-description}'    => $this->template->description,
            '{template-name}'          => $this->template->name,
            '{table-alias}'            => $this->alias,
            '{table-id}'               => $this->id(),
            '{table-name}'             => $this->name,
            '{menu-append-row}'        => $menu_append_row,
            '{menu-prepend-row}'       => $menu_prepend_row,
            '{menu-clear-rows}'        => $menu_clear_rows,
            '{menu-edit-table}'        => $menu_edit_table,
            '{menu-edit-template}'     => $menu_edit_template,
        );
        list($header, $content, $children, $footer, $form) =
            str_replace(array_keys($replacements), array_values($replacements),
                array($header, $content, $children, $footer, $form));

        // Return Select HTML
        if ($select === false)
            return $header . $children . $footer . $form;
        if ($select === 'table-header')
            return $header;
        if ($select === 'table-content')
            return $content;
        if ($select === 'table-footer')
            return $footer;
        if ($select === 'form')
            return $form;

        // Return Children
        return $children;
    }

    /**
     * HTML Identifier
     *
     * @param string $modifier [$modifier ...]
     *     Accepts one or more modifiers to append to the identifier. Each
     *     modifier will be automatically prefixed by '-'.
     *
     * @return string
     *     Returns the identifier.
     */
    public function id($modifier = '')
    {
        // Build Pieces
        return implode('-', array_merge(
            array('web-table', $this->name),
            func_get_args()));
    }

    /**
     * Create JSON Array
     *
     * @return array
     *     Returns the array which can be converted to a JSON representation of
     *     the object via the json_encode() function.
     */
    public function json()
    {
        // Initialize Array
        $json = array();

        // Store Table Fields
        $json['alias']    = $this->alias;
        $json['name']     = $this->name;
        $json['template'] = $this->template->name;

        // Add Child Arrays
        foreach ($this->_children as $child)
            $json['rows'][] = $child->json();

        // Return Array
        return $json;
    }

    /**
     * Save the Table to a Flat-File (Serialization)
     *
     * Warning, if an optional $path is specified, it should be a path to a
     * directory. Furthermore, if the file does exist, note that upon a
     * successful save, it will be overwritten.
     *
     * @param string $path
         *     Accepts an alternate save location. This should be a path to a
         *     directory and not a file.
     *
     * @return string
     *     Returns the path to the file where the table was saved.
     */
    public function save($path = null)
    {
        // Define the Filepath
        $path = self::path($this->name, $path);

        // Check if Directory is Writeable
        if (!is_writeable(dirname($path)))
            throw Exception::factory('SAVE-DIRECTORY')->
                localize('Table', $this->name, dirname($path));

        // Check if File is Writeable
        if (file_exists($path) && !is_writable($path))
            throw Exception::factory('SAVE-FILE')->
                localize('Table', $this->name, $path);

        // Attempt to Write File
        if (@file_put_contents($path, json_encode($this->json())) === false)
            throw Exception::factory('SAVE-IO')->
                localize('Table', $this->name, $path);

        return $path;
    }

    /**
     * Load Saved Table from a Flat-File (Serialization)
     *
     * @param string $name
     *     Accepts the name of the Table.
     * @param string $path
     *     Accepts an alternative save location. This should be a path to a
     *     directory and not a file.
     *     (Default: null)
     * @param boolean $create
     *     If true, the Table will be created and saved if it does not exist.
     *     (Default: false)
     *
     * @return Table
     */
    public static function load($name, $path = null, $create = false)
    {
        // Define the Filepath
        $path = self::path($name, $path);

        // Check if Path Exists
        if (!file_exists($path))
        {
            if (!$create)
                throw Exception::factory('LOAD-EXISTENCE')->
                    localize('Table', $name, $path);
            else
            {
                $table = new Table($name);
                $table->save(dirname($path));
            }
        }

        // Check if Directory is Readable
        if (!is_readable(dirname($path)))
            throw Exception::factory('LOAD-DIRECTORY')->
                localize('Table', $name, dirname($path));

        // Check if File is Readable
        if (!is_readable($path))
            throw Exception::factory('LOAD-FILE')->
                localize('Table', $name, $path);

        // Attempt to Read File
        if (($contents = @file_get_contents($path)) === false)
            throw Exception::factory('LOAD-IO')->
                localize('Table', $name, $path);

        // Attempt to decode the data as a JSON string.
        $table_data = json_decode($contents, true);

        // Check Loaded Table Name
        if (!isset($table_data['name']) || $table_data['name'] != $name)
            throw Exception::factory('LOAD-FORMAT')->
                localize('Table', $name, $path);

        // Create the Table
        $table = new Table($table_data['name'], $table_data['template']);
        $table->alias = $table_data['alias'];

        // Add Table Content
        $rows = isset($table_data['rows']) ?
            $table_data['rows'] : array();

        foreach ($rows as $row_data)
        {
            $row = $table->appendRow(
                $row_data['name'],
                $row_data['index']);

            $cells = isset($row_data['cells']) ?
                $row_data['cells'] : array();

            foreach ($cells as $cell_data)
            {
                $cell = $row->appendCell(
                    $cell_data['name'],
                    $cell_data['index']);

                $groups = isset($cell_data['groups']) ?
                    $cell_data['groups'] : array();

                foreach ($groups as $group_data)
                {
                    $group = $cell->appendGroup(
                        $group_data['name'],
                        $group_data['index']);

                    $items = isset($group_data['items']) ?
                        $group_data['items'] : array();

                    foreach ($items as $item_data)
                    {
                        $item = $group->appendItem(
                            $item_data['name'],
                            $item_data['text'],
                            $item_data['checkable'],
                            $item_data['index']);
                        $item->completed = $item_data['completed'];
                    }
                }
            }
        }

        return $table;
    }

    /**
     * Get Table Resource Path
     *
     * @param string $name
     *     Accepts the name of the Table.
     *
     * @return string
     *     Returns the path to the Table resource.
     */
    public static function path($name, $path = null)
    {
        // Check $path
        if ($path === null)
            $path = Autoloader::getDataDirectory('Tables');
        elseif (!is_dir($path))
            throw Exception::factory('TABLE-PATH-INVALID')->localize($path);

        // Define Resource Filepath
        return $path . DS . $name . '.tbl';
    }
}

?>