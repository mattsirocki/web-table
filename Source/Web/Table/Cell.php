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
 * @version    SVN: $Id: Cell.php 112 2013-03-10 21:06:02Z ll77ll $
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
 * Web Table Cell
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    Release @release-version@
 * @since      Class available since Initial Release.
 */
class Cell extends Object
{
    /**
     * Parent of this Cell
     *
     * @var Row
     */
    public $parent;

    /**
     * Public Constructor
     *
     * @param string $name
     *     Accepts the name of the new Cell.
     *
     * @return void
     */
    public function __construct($name)
    {
        // Check $name
        if (!is_string($name))
            throw Exception::factory('OBJECT-CONSTRUCT-TYPE')->
                localize('Cell', 'name', 'string');

        // Initialize Fields
        $this->index     = 0;
        $this->name      = $name;
        $this->parent    = null;
        $this->_children = array();
    }

    /**
     * Append Group
     *
     * @param string|Group $group
     *     Accepts either the name of the Group or an actual Group object.
     * @param null|integer $index
     *     Accepts the index of Group.
     *     (Default: null)
     *
     * @return Group
     *     Returns the appended Group.
     */
    public function appendGroup($group, $index = null)
    {
        if ($group instanceof Group)
            $child = $group;
        else
            $child = new Group($group);

        return $this->_appendChild($child, $index, 'Group');
    }

    /**
     * Clear Groups
     *
     * @return void
     */
    public function clearGroups()
    {
        $this->_clearChildren();
    }

    /**
     * Remove Group
     *
     * @param integer $index
     *     Accepts the index of the Group to remove.
     *
     * @return void
     */
    public function removeGroup($index)
    {
        $this->_removeChild($index, 'Group');
    }

    /**
     * Get Group
     *
     * @param integer $index
     *     Accepts the index of the Group to get.
     *
     * @return Group
     *     Returns the specified Group.
     */
    public function getGroup($index)
    {
        return $this->_getChild($index, 'Group');
    }

    /**
     * Insert Group
     *
     * @param integer $index
     *     Accepts the index of an existing Group. The new Group will be inserted
     *     after the Group specified by this index.
     * @param string|Group $group
     *     Accepts either the name of the Group or an actual Group object.
     *
     * @return Group
     *     Returns the inserted Group.
     */
    public function insertGroup($index, $group)
    {
        if ($group instanceof Group)
            $child = $group;
        else
            $child = new Group($group);

        return $this->_insertChild($index, $child, 'Group');
    }

    /**
     * Prepend Group
     *
     * @param string|Group $group
     *     Accepts either the name of the Group or an actual Group object.
     * @param null|integer $index
     *     Accepts the index of the Group.
     *     (Default: null)
     *
     * @return Group
     *     Returns the prepended Group.
     */
    public function prependGroup($group, $index = null)
    {
        if ($group instanceof Group)
            $child = $group;
        else
            $child = new Group($group);

        return $this->_prependChild($child, $index, 'Group');
    }

    /**
     * Create HTML Output
     *
     * @param boolean|string $select
     *     Accepts flag indicating what should be returned. The following values
     *     are valid:
     *     <ul>
     *       <li> false        - Return everything.
     *       <li> true         - Only return children.
     *       <li> cell-header  - Only return header.
     *       <li> cell-content - Only return content.
     *       <li> cell-footer  - Only return footer.
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
                localize('Row', 'Cell', $this->name);

        // Get Parent Elements
        $row   = $this->parent;
        $table = $row->parent;

        // Grab Template Elements
        $header  = $table->template->cellHeader;
        $content = $table->template->cellContent;
        $footer  = $table->template->cellFooter;

        // Menu Request Strings
        $menu_append_group  = $table->template->jsRequest('AppendGroup',  null, $table, $row, $this);
        $menu_prepend_group = $table->template->jsRequest('PrependGroup', null, $table, $row, $this);
        $menu_clear_groups  = $table->template->jsRequest('ClearGroups',  null, $table, $row, $this);
        $menu_insert_cell   = $table->template->jsRequest('InsertCell',   null, $table, $row, $this);
        $menu_edit_cell     = $table->template->jsRequest('EditCell',     null, $table, $row, $this);
        $menu_remove_cell   = $table->template->jsRequest('RemoveCell',   null, $table, $row, $this);

        // Get Children HTML
        $children = '';
        foreach ($this->_children as $child)
            $children .= $child->html($select);

        // Perform Replacements
        $replacements = array
        (
            '{template:cell-header}'  => $table->template->cellHeader,
            '{template:cell-content}' => $table->template->cellContent,
            '{template:cell-footer}'  => $table->template->cellFooter,
            '{cell-id}'               => $this->id(),
            '{cell-index}'            => $this->index,
            '{cell-name}'             => $this->name,
            '{menu-append-group}'     => $menu_append_group,
            '{menu-prepend-group}'    => $menu_prepend_group,
            '{menu-clear-groups}'     => $menu_clear_groups,
            '{menu-insert-cell}'      => $menu_insert_cell,
            '{menu-edit-cell}'        => $menu_edit_cell,
            '{menu-remove-cell}'      => $menu_remove_cell,
        );
        list($header, $content, $children, $footer) =
            str_replace(array_keys($replacements), array_values($replacements),
                array($header, $content, $children, $footer));

        // Return Select HTML
        if ($select === false)
            return $header . $children . $footer;
        if ($select === 'cell-header')
            return $header;
        if ($select === 'cell-content')
            return $content;
        if ($select === 'cell-footer')
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

        // Store Cell Fields
        $json['index'] = $this->index;
        $json['name']  = $this->name;

        // Add Child Arrays
        foreach ($this->_children as $child)
            $json['groups'][] = $child->json();

        // Return Array
        return $json;
    }
}

?>