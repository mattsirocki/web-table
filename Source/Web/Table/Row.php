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
 * @version    SVN: $Id: Row.php 112 2013-03-10 21:06:02Z ll77ll $
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
 * Web Table Row
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    Release @release-version@
 * @since      Class available since Initial Release.
 */
class Row extends Object
{
    /**
     * Parent of this Row
     *
     * @var Table
     */
    public $parent;

    /**
     * Public Constructor
     *
     * @param string $name
     *     Accepts the name of the new Row.
     *
     * @return void
     */
    public function __construct($name)
    {
        // Check $name
        if (!is_string($name))
            throw Exception::factory('OBJECT-CONSTRUCT-TYPE')->
                localize('Row', 'name', 'string');

        // Initialize Fields
        $this->index     = 0;
        $this->name      = $name;
        $this->parent    = null;
        $this->_children = array();
    }

    /**
     * Append Cell
     *
     * @param string|Cell $cell
     *     Accepts either the name of the Cell or an actual Cell object.
     * @param null|integer $index
     *     Accepts the index of Cell.
     *     (Default: null)
     *
     * @return Cell
     *     Returns the appended Cell.
     */
    public function appendCell($cell, $index = null)
    {
        if ($cell instanceof Cell)
            $child = $cell;
        else
            $child = new Cell($cell);

        return $this->_appendChild($child, $index, 'Cell');
    }

    /**
     * Clear Cells
     *
     * @return void
     */
    public function clearCells()
    {
        $this->_clearChildren();
    }

    /**
     * Remove Cell
     *
     * @param integer $index
     *     Accepts the index of the Cell to remove.
     *
     * @return void
     */
    public function removeCell($index)
    {
        $this->_removeChild($index, 'Cell');
    }

    /**
     * Get Cell
     *
     * @param integer $index
     *     Accepts the index of the Cell to get.
     *
     * @return Cell
     *     Returns the specified Cell.
     */
    public function getCell($index)
    {
        return $this->_getChild($index, 'Cell');
    }

    /**
     * Insert Cell
     *
     * @param integer $index
     *     Accepts the index of an existing Cell. The new Cell will be inserted
     *     after the Cell specified by this index.
     * @param string|Cell $cell
     *     Accepts either the name of the Cell or an actual Cell object.
     *
     * @return Cell
     *     Returns the inserted Cell.
     */
    public function insertCell($index, $cell)
    {
        if ($cell instanceof Cell)
            $child = $cell;
        else
            $child = new Cell($cell);

        return $this->_insertChild($index, $child, 'Cell');
    }

    /**
     * Prepend Cell
     *
     * @param string|Cell $cell
     *     Accepts either the name of the Cell or an actual Cell object.
     * @param null|integer $index
     *     Accepts the index of the Cell.
     *     (Default: null)
     *
     * @return Cell
     *     Returns the prepended Cell.
     */
    public function prependCell($cell, $index = null)
    {
        if ($cell instanceof Cell)
            $child = $cell;
        else
            $child = new Cell($cell);

        return $this->_prependChild($child, $index, 'Cell');
    }

    /**
     * Create HTML Output
     *
     * @param boolean|string $select
     *     Accepts flag indicating what should be returned. The following values
     *     are valid:
     *     <ul>
     *       <li> false       - Return everything.
     *       <li> true        - Only return children.
     *       <li> row-header  - Only return header.
     *       <li> row-content - Only return content.
     *       <li> row-footer  - Only return footer.
     *     </ul>
     *     (Default: false)
     *
     * @return string
     *     Returns the HTML.
     */
    public function html($select = false)
    {
        // Check Parent
        if ($this->parent === null)
            throw Exception::factory('OBJECT-FREE-ELEMENT')->
                localize('Table', 'Row', $this->name);

        // Get Parent Elements
        $table = $this->parent;

        // Grab Template Elements
        $header  = $table->template->rowHeader;
        $content = $table->template->rowContent;
        $footer  = $table->template->rowFooter;

        // Menu Request Strings
        $menu_append_cell  = $table->template->jsRequest('AppendCell',  null, $table, $this);
        $menu_prepend_cell = $table->template->jsRequest('PrependCell', null, $table, $this);
        $menu_clear_cells  = $table->template->jsRequest('ClearCells',  null, $table, $this);
        $menu_insert_row   = $table->template->jsRequest('InsertRow',   null, $table, $this);
        $menu_edit_row     = $table->template->jsRequest('EditRow',     null, $table, $this);
        $menu_remove_row   = $table->template->jsRequest('RemoveRow',   null, $table, $this);

        // Get Children HTML
        $children = '';
        foreach ($this->_children as $child)
            $children .= $child->html($select);

        // Perform Replacements
        $replacements = array
        (
            '{template:row-header}'  => $table->template->rowHeader,
            '{template:row-content}' => $table->template->rowContent,
            '{template:row-footer}'  => $table->template->rowFooter,
            '{row-id}'               => $this->id(),
            '{row-index}'            => $this->index,
            '{row-name}'             => $this->name,
            '{menu-append-cell}'     => $menu_append_cell,
            '{menu-prepend-cell}'    => $menu_prepend_cell,
            '{menu-clear-cells}'     => $menu_clear_cells,
            '{menu-insert-row}'      => $menu_insert_row,
            '{menu-edit-row}'        => $menu_edit_row,
            '{menu-remove-row}'      => $menu_remove_row,
        );
        list($header, $content, $children, $footer) =
            str_replace(array_keys($replacements), array_values($replacements),
                array($header, $content, $children, $footer));

        // Return Select HTML
        if ($select === false)
            return $header . $children . $footer;
        if ($select === 'row-header')
            return $header;
        if ($select === 'row-content')
            return $content;
        if ($select === 'row-footer')
            return $footer;

        // Return Children
        return $children;
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

        // Store Row Fields
        $json['index'] = $this->index;
        $json['name']  = $this->name;

        // Add Child Arrays
        foreach ($this->_children as $child)
            $json['cells'][] = $child->json();

        // Return Array
        return $json;
    }
}

?>