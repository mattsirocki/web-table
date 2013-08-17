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
 * @version    SVN: $Id: Group.php 112 2013-03-10 21:06:02Z ll77ll $
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
 * Web Table Group
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    Release @release-version@
 * @since      Class available since Initial Release.
 */
class Group extends Object
{
    /**
     * Parent of this Group
     *
     * @var Cell
     */
    public $parent;

    /**
     * Public Constructor
     *
     * @param string $name
     *     Accepts the name of the new Group.
     *
     * @return void
     */
    public function __construct($name)
    {
        // Check $name
        if (!is_string($name))
            throw Exception::factory('OBJECT-CONSTRUCT-TYPE')->
                localize('Group', 'name', 'string');

        // Initialize Fields
        $this->index     = 0;
        $this->name      = $name;
        $this->parent    = null;
        $this->_children = array();
    }

    /**
     * Append Item
     *
     * @param string|Item $item
     *     Accepts either the name of the Item or an actual Item object.
     * @param string $text
     *     Accepts the text of the new Item.
     *     (Default: null)
     * @param boolean $checkable
     *     Accepts whether the new Item is checkable.
     *     (Default: null)
     * @param null|integer $index
     *     Accepts the index of Item.
     *     (Default: null)
     *
     * @return Item
     *     Returns the appended Item.
     */
    public function appendItem($item, $text = null, $checkable = null, $index = null)
    {
        if ($item instanceof Item)
            $child = $item;
        else
            $child = new Item($item, $text, $checkable);

        return $this->_appendChild($child, $index, 'Item');
    }

    /**
     * Clear Items
     *
     * @return void
     */
    public function clearItems()
    {
        $this->_clearChildren();
    }

    /**
     * Remove Item
     *
     * @param integer $index
     *     Accepts the index of the Item to remove.
     *
     * @return void
     */
    public function removeItem($index)
    {
        $this->_removeChild($index, 'Item');
    }

    /**
     * Get Item
     *
     * @param integer $index
     *     Accepts the index of the Item to get.
     *
     * @return Item
     *     Returns the specified Item.
     */
    public function getItem($index)
    {
        return $this->_getChild($index, 'Item');
    }

    /**
     * Insert Item
     *
     * @param integer $index
     *     Accepts the index of an existing Item. The new Item will be inserted
     *     after the Group specified by this index.
     * @param string|Item $item
     *     Accepts either the name of the Item or an actual Item object.
     * @param string $text
     *     Accepts the text of the new Item.
     *     (Default: null)
     * @param boolean $checkable
     *     Accepts whether the new Item is checkable.
     *     (Default: null)
     *
     * @return Item
     *     Returns the inserted Item.
     */
    public function insertItem($index, $item, $text = null, $checkable = null)
    {
        if ($item instanceof Item)
            $child = $item;
        else
            $child = new Item($item, $text, $checkable);

        return $this->_insertChild($index, $child, 'Item');
    }

    /**
     * Prepend Item
     *
     * @param string|Item $item
     *     Accepts either the name of the Item or an actual Item object.
     * @param string $text
     *     Accepts the text of the new Item.
     *     (Default: null)
     * @param boolean $checkable
     *     Accepts whether the new Item is checkable.
     *     (Default: null)
     * @param null|integer $index
     *     Accepts the index of the Item.
     *     (Default: null)
     *
     * @return Item
     *     Returns the prepended Item.
     */
    public function prependItem($item, $text = null, $checkable = null, $index = null)
    {
        if ($item instanceof Item)
            $child = $item;
        else
            $child = new Item($item, $text, $checkable);

        return $this->_prependChild($child, $index, 'Item');
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
     *       <li> group-header  - Only return header.
     *       <li> group-content - Only return content.
     *       <li> group-footer  - Only return footer.
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
                localize('Cell', 'Group', $this->name);

        // Get Parent Elements
        $cell  = $this->parent;
        $row   = $cell->parent;
        $table = $row->parent;

        // Grab Template Elements
        $header  = $table->template->groupHeader;
        $content = $table->template->groupContent;
        $footer  = $table->template->groupFooter;

        // Menu Request Strings
        $menu_append_item  = $table->template->jsRequest('AppendItem',  null, $table, $row, $cell, $this);
        $menu_prepend_item = $table->template->jsRequest('PrependItem', null, $table, $row, $cell, $this);
        $menu_clear_items  = $table->template->jsRequest('ClearItems',  null, $table, $row, $cell, $this);
        $menu_insert_group = $table->template->jsRequest('InsertGroup', null, $table, $row, $cell, $this);
        $menu_edit_group   = $table->template->jsRequest('EditGroup',   null, $table, $row, $cell, $this);
        $menu_remove_group = $table->template->jsRequest('RemoveGroup', null, $table, $row, $cell, $this);

        // Get Children HTML
        $children = '';
        foreach ($this->_children as $child)
            $children .= $child->html($select);

        // Perform Replacements
        $replacements = array
        (
            '{template:group-header}'  => $table->template->groupHeader,
            '{template:group-content}' => $table->template->groupContent,
            '{template:group-footer}'  => $table->template->groupFooter,
            '{group-id}'               => $this->id(),
            '{group-index}'            => $this->index,
            '{group-name}'             => $this->name,
            '{menu-append-item}'       => $menu_append_item,
            '{menu-prepend-item}'      => $menu_prepend_item,
            '{menu-clear-items}'       => $menu_clear_items,
            '{menu-insert-group}'      => $menu_insert_group,
            '{menu-edit-group}'        => $menu_edit_group,
            '{menu-remove-group}'      => $menu_remove_group,
        );
        list($header, $content, $children, $footer) =
            str_replace(array_keys($replacements), array_values($replacements),
                array($header, $content, $children, $footer));

        // Return Select HTML
        if ($select === false)
            return $header . $children . $footer;
        if ($select === 'group-header')
            return $header;
        if ($select === 'group-content')
            return $content;
        if ($select === 'group-footer')
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

        // Store Group Fields
        $json['index'] = $this->index;
        $json['name']  = $this->name;

        // Add Child Arrays
        foreach ($this->_children as $child)
            $json['items'][] = $child->json();

        // Return Array
        return $json;
    }
}

?>