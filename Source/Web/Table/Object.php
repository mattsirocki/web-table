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
 * @version    SVN: $Id: Object.php 113 2013-03-13 02:50:17Z ll77ll $
 * @since      File available since Initial Release.
 * @filesource
 */

/*
 * $LastChangedBy: ll77ll $
 * $LastChangedDate: 2013-03-12 22:50:17 -0400 (Tue, 12 Mar 2013) $
 */

/*
 * Specify Namespace
 */
namespace Web\Table;

/**
 * \Web\Table\Object
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    Release @release-version@
 * @since      Class available since Initial Release.
 */
abstract class Object
{
    /**
     * Index of this Object
     *
     * @var integer
     */
    public $index;

    /**
     * Name of this Object
     *
     * @var string
     */
    public $name;

    /**
     * Parent of this Object
     *
     * @var \Web\Table\Object
     */
    public $parent;

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
            array($this->parent->id(), $this->index),
            func_get_args()));
    }

    /**
     * Children of this Object
     *
     * @var array
     */
    protected $_children;

    /**
     * Export
     *
     * Wrapper for the var_export($value, true) function.
     *
     * @param mixed $value
     *     Accepts a mixed value.
     *
     * @return string
     *     Returns a string parsable representation of the input value.
     */
    static protected function _e($value)
    {
        // We replace all whitespace characters which have explicit escape
        // sequences with their corresponding escape sequences. The list of
        // these sequences is located at:
        //
        //     http://www.php.net/manual/en/language.types.string.php
        //
        $needles = array("\n", "\r", "\t", "\v", "\e", "\f");
        $replace = array('\n', '\r', '\t', '\v', '\e', '\f');

        return str_replace($needles, $replace, var_export($value, true));
    }

    /**
     * Append Child
     *
     * @param Object $child
     *     Accepts the child to be inserted.
     * @param null|integer $index
     *     Accepts the index of child.
     * @param string $type
     *     Accepts the type of the child.
     *
     * @return Object
     *     Returns the appended child.
     */
    protected function _appendChild($child, $index, $type)
    {
        // Check Index Type
        if ($index !== null && !is_integer($index))
            throw Exception::factory('OBJECT-ACTION-INDEX')->
                localize('append', $type);

        // Check Child Existence
        if (is_integer($index) && isset($this->_children[$index]))
            throw Exception::factory('OBJECT-ACTION-CHILD-EXISTS')->
                localize('append', $type, $index);
        // Set Public Fields
        $child->index  = $index ?: $this->__next();
        $child->parent = $this;

        // Append Child
        return $this->_children[$child->index] = $child;
    }

    /**
     * Clear Children
     *
     * @return void
     */
    protected function _clearChildren()
    {
        // Remove All Children
        unset($this->_children);

        // New Array
        $this->_children = array();
    }

    /**
     * Remove Child
     *
     * @param integer $index
     *     Accepts the index of the child to remove.
     * @param string $type
     *     Accepts the type of the child.
     *
     * @return void
     */
    protected function _removeChild($index, $type)
    {
        // Check Index Type
        if (!is_integer($index))
            throw Exception::factory('OBJECT-ACTION-INDEX')->
                localize('remove', $type);

        // Check Child Existence
        if (!isset($this->_children[$index]))
            throw Exception::factory('OBJECT-ACTION-CHILD-MISSING')->
                localize('remove', $type, $index);

        // Remove Child
        unset($this->_children[$index]);
    }

    /**
     * Get Child
     *
     * @param integer $index
     *     Accepts the index of the child to get.
     * @param string $type
     *     Accepts the type of the child.
     *
     * @return Object
     *     Returns the specified child.
     */
    protected function _getChild($index, $type)
    {
        // Check Index Type
        if (!is_integer($index))
            throw Exception::factory('OBJECT-ACTION-INDEX')->
                localize('get', $type);

        // Check Child Existence
        if (!isset($this->_children[$index]))
            throw Exception::factory('OBJECT-ACTION-CHILD-MISSING')->
                localize('get', $type, $index);

        // Get Child
        return $this->_children[$index];
    }

    /**
     * Insert Child
     *
     * @param integer $index
     *     Accepts the index of an existing child. The new child will be
     *     inserted after the child specified by this index.
     * @param Object $child
     *     Accepts the child to be inserted.
     * @param string $type
     *     Accepts the type of the child.
     *
     * @return Object
     *     Returns the inserted child.
     */
    protected function _insertChild($index, $child, $type)
    {
        // Check Index Type
        if (!is_integer($index))
            throw Exception::factory('OBJECT-ACTION-INDEX')->
                localize('insert', $type);

        // Check Child Existence
        if (!isset($this->_children[$index]))
            throw Exception::factory('OBJECT-ACTION-CHILD-MISSING')->
                localize('insert', $type, $index);

        // Set Public Fields
        $child->index  = $this->__next();
        $child->parent = $this;

        // Insert Child
        foreach ($this->_children as $i => $c)
        {
            $children[$i] = $c;

            if ($i == $index)
                $children[$child->index] = $child;
        }
        $this->_children = $children;

        return $child;
    }

    /**
     * Prepend Child
     *
     * @param Object $child
     *     Accepts the child to be prepended.
     * @param null|integer $index
     *     Accepts the index of the child.
     * @param string $type
     *     Accepts the type of the child.
     *
     * @return Object
     *     Returns the prepended child.
     */
    protected function _prependChild($child, $index, $type)
    {
        // Check Index Type
        if ($index !== null && !is_integer($index))
            throw Exception::factory('OBJECT-ACTION-INDEX')->
                localize('prepend', $type);

        // Check Child Existence
        if (is_integer($index) && isset($this->_children[$index]))
            throw Exception::factory('OBJECT-ACTION-CHILD-EXISTS')->
                localize('prepend', $type, $index);

        // Set Public Fields
        $child->index  = $index ?: $this->__next();
        $child->parent = $this;

        // Prepend Child
        array_splice($this->_children, 0, 0,
            array($child->index => $child));

        return $child;
    }

    /**
     * Get Next Available Child Index
     *
     * @return integer
     *     Returns the next available child index.
     */
    private function __next()
    {
        return count($this->_children) > 0 ?
            max(array_keys($this->_children)) + 1 : 0;
    }
}

?>