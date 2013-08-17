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
 * @version    SVN: $Id: Item.php 112 2013-03-10 21:06:02Z ll77ll $
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
 * Web Table Item
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    Release @release-version@
 * @since      Class available since Initial Release.
 */
class Item extends Object
{
    /**
     * Item Checkable Flag
     *
     * @var boolean
     */
    public $checkable;

    /**
     * Item Completed Flag
     *
     * @var boolean
     */
    public $completed;

    /**
     * Parent of this Item
     *
     * @var Group
     */
    public $parent;

    /**
     * Item Text
     *
     * @var string
     */
    public $text;

    /**
     * Public Constructor
     *
     * @param string $name
     *     Accepts the name of the new Item.
     * @param string $text
     *     Accepts the text of the new Item.
     * @param boolean $checkable
     *     Accepts whether the new Item is checkable.
     *
     * @return void
     */
    public function __construct($name, $text, $checkable)
    {
        // Check $name
        if (!is_string($name))
            throw Exception::factory('OBJECT-CONSTRUCT-TYPE')->
                localize('Item', 'name', 'string');

        // Check $text
        if (!is_string($text))
            throw Exception::factory('OBJECT-CONSTRUCT-TYPE')->
                localize('Item', 'text', 'string');

        // Check $checkable
        if (!is_bool($checkable))
            throw Exception::factory('OBJECT-CONSTRUCT-TYPE')->
                localize('Item', 'checkable', 'boolean');

        // Initialize Fields
        $this->checkable = $checkable;
        $this->completed = false;
        $this->index     = 0;
        $this->name      = $name;
        $this->parent    = null;
        $this->text      = $text;
        $this->_children = null;
    }

    /**
     * Create HTML Output
     *
     * @param boolean|string $select
     *     Accepts flag indicating what should be returned. The following values
     *     are valid:
     *     <ul>
     *       <li> false        - Return everything.
     *       <li> true         - Only return content.
     *       <li> item-header  - Only return header.
     *       <li> item-content - Only return content.
     *       <li> item-footer  - Only return footer.
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
                localize('Group', 'Item', $this->name);

        // Get Parent Elements
        $group = $this->parent;
        $cell  = $group->parent;
        $row   = $cell->parent;
        $table = $row->parent;

        // Grab Template Elements
        $header  = $table->template->itemHeader;
        $content = $this->checkable ? $table->template->itemCheckableContent :
                       $table->template->itemContent;
        $footer  = $table->template->itemFooter;

        // Text with/without Checkbox
        $checkbox = !$this->checkable ? '' :
            $table->template->htmlFormInputCheckbox(
                $this->id('checkbox'),
                $this->completed,
                $table->template->jsRequest(
                    'CheckItem',
                    $table->template->jsFormValues($this->id('checkbox') . ':checked'),
                    $table,
                    $row,
                    $cell,
                    $group,
                    $this));

        // Menu Request Strings
        $menu_insert_item = $table->template->jsRequest('InsertItem', null, $table, $row, $cell, $group, $this);
        $menu_edit_item   = $table->template->jsRequest('EditItem',   null, $table, $row, $cell, $group, $this);
        $menu_remove_item = $table->template->jsRequest('RemoveItem', null, $table, $row, $cell, $group, $this);

        // Perform Replacements
        $replacements = array
        (
            '{template:item-header}'  => $header,
            '{template:item-content}' => $content,
            '{template:item-footer}'  => $footer,
            '{item-checkbox}'         => $checkbox,
            '{item-id}'               => $this->id(),
            '{item-index}'            => $this->index,
            '{item-name}'             => $this->name,
            '{item-text}'             => $this->text,
            '{menu-insert-item}'      => $menu_insert_item,
            '{menu-edit-item}'        => $menu_edit_item,
            '{menu-remove-item}'      => $menu_remove_item,
        );
        list($header, $content, $footer) =
            str_replace(array_keys($replacements), array_values($replacements),
                array($header, $content, $footer));

        // Return Select HTML
        if ($select === false)
            return $header . $footer;
        if ($select === 'item-header')
            return $header;
        if ($select === 'item-content')
            return $content;
        if ($select === 'item-footer')
            return $footer;

        // Return Content
        return $content;
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

        // Store Item Fields
        $json['checkable'] = $this->checkable;
        $json['completed'] = $this->completed;
        $json['index']     = $this->index;
        $json['name']      = $this->name;
        $json['text']      = $this->text;

        // Return Array
        return $json;
    }
}

?>