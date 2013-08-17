<?php

/**
 * This file is part of Console_Parser.
 *
 * PHP version 5
 *
 * @category   Console
 * @package    Console_Parser
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    SVN: $Id: Exception.php 113 2013-03-13 02:50:17Z ll77ll $
 * @since      File available since Initial Release.
 * @filesource
 */

/*
 * Specify Namespace
 */
namespace Web\Table;

/**
 * Console Parser Exception
 *
 * Note: Changes here should be coordinated with {@link Autoloader::_error()}
 *
 * @category   Console
 * @package    Console_Parser
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    Release @release-version@
 * @since      Class available since Initial Release.
 */
class Exception extends \Exception
{
    /**
     * Public Constructor
     *
     * @param string $key
     *     One of the message codes defined by {@link $_messages}.
     * @param \Web\Table\Context $context [optional]
     *     Context instance for contextual substitutions. If not
     *     specified (defaults to null) no replacements will be made.
     * @param \Web\Table\Exception $previous [optional]
     *     Previous exception instance.
     *
     * @return \Web\Table\Exception
     */
    public function __construct($key, $previous = null)
    {
        if (!isset($this->_messages[$key]))
            throw Exception::factory('UNKNOWN-EXCEPTION', $this)->localize($key);

        $message = $this->_messages[$key];
        $code    = array_search($key, array_keys($this->_messages));

        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the exception key.
     *
     * @return string
     *     Returns the exception key.
     */
    public function getKey()
    {
        return $this->__key;
    }

    /**
     * Exception Localization
     */
    public function localize($value)
    {
        foreach (func_get_args() as $key => $value)
            $this->message = str_replace('{'.$key.'}', $value, $this->message);

        return $this;
    }

    /**
     * Exception Factory
     *
     * Sample Usage:
     *
     * <pre>
     * throw \Web\Table\Exception::factory('EXCEPTION_KEY')->
     *     localize('key_0', 'value_0', 'key_1', 'value_1');
     * </pre>
     *
     * @param string $key
     *     One of the message keys defined by {@link $_messages}.
     * @param \Exception $previous [optional]
     *     Previous Exception instance.
     *
     * @return \Web\Table\Exception
     *     Returns the created Exception.
     */
    public static function factory($key, $previous = null)
    {
        return new \Web\Table\Exception($key, $previous);
    }

    /**
    * Exception Messages
    *
    * @var string[string]
    */
    protected $_messages = array(
        // AUTOLOADER EXCEPTIONS
        'AUTOLOADER-MISSING-FILE'     => 'We had some trouble loading "{0}". The file "{1}" does not exist in any of the registered paths.',
        'AUTOLOADER-MISSING-RESOURCE' => 'We had some trouble loading "{0}". Make sure it is properly defined in "{1}".',

        // AJAX EXCEPTIONS
        'AJAX-MAGIC-QUOTES'           => '"Magic Quotes" (a deprecated PHP "feature") must be disabled. Specifically, please check the value of "magic_quotes_gpc" in your "php.ini" file.',
        'AJAX-MISSING-HANDLER'        => 'The handler for the operation "{0}" does not exist.',

        // BOOTSTRAP EXCEPTIONS
        'BOOTSTRAP-CONSTANT'          => 'Bootstrap: The ‘{0}’ constant was not defined properly. (Actual: {1}, Expected: {2})',

        // FILE EXCEPTIONS
        'LOAD-DIRECTORY'              => 'We cannot load the {0} "{1}" because the directory "{2}" does not appear to be readable. This is a permissions issue.',
        'LOAD-EXISTENCE'              => 'We cannot load the {0} "{1}" because the file "{2}" does not exist. Make sure the {0} "{1}" actually exists.',
        'LOAD-FILE'                   => 'We cannot load the {0} "{1}" because the file "{2}" does not appear to be readable. This is a permissions issue.',
        'LOAD-FORMAT'                 => 'We cannot load the {0} "{1}" because the file "{2}" contained unexpected elements.',
        'LOAD-IO'                     => 'We cannot load the {0} "{1}" but we\'re not quite sure why. The file "{2}" appears to be readable. The file might be locked by another application.',
        'SAVE-DIRECTORY'              => 'We cannot save the {0} "{1}" because the directory "{2}" does not appear to be writeable. This is a permissions issue.',
        'SAVE-FILE'                   => 'We cannot save the {0} "{1}" because the file "{2}" does not appear to be writeable. This is a permissions issue.',
        'SAVE-IO'                     => 'We cannot save the {0} "{1}" though we\'re not quite sure why. The file "{2}" appears to be writeable. The file might be locked by another application.',

        // TABLE EXCEPTIONS
        'TABLE-NAME-INVALID'          => 'Cannot create Table with the name "{0}"; the name is invalid. Valid names must consist of only lowercase letters, the numbers, and, excluding the first character, dashes "-".',
        'TABLE-PATH-INVALID'          => 'We cannot use the path "{0}" as a repository for Tables; it is not a path to a directory.',

        // TEMPLATE EXCEPTIONS
        'TEMPLATE-ELEMENT'            => 'Cannot load the Template "{0}" because the Template definition file "{1}" does not define the element "{2}".',

        // OBJECT EXCEPTIONS
        'OBJECT-ACTION-INDEX'         => 'Cannot {0} the specified {1}; the index specified was not an integer.',
        'OBJECT-ACTION-CHILD-EXISTS'  => 'Cannot {0} the specified {1}; a {1} with an index of {2} already exists.',
        'OBJECT-ACTION-CHILD-MISSING' => 'Cannot {0} the specified {1}; no {1} with an index of {2} exists.',
        'OBJECT-CONSTRUCT-TYPE'       => 'Cannot create a new {0}; the ${1} argument must be a {2}.',
        'OBJECT-FREE-ELEMENT'         => 'We had some trouble generating the HTML for the {1} "{2}"; the $parent field was never set. {1}s must belong to {0}s.',

        // GENERAL API EXCEPTIONS
        'UNKNOWN-EXCEPTION'           => 'Cannot throw Exception with key "{0}"; the specified key is invalid.',
    );

    /**
     * Exception Key
     *
     * @var string
     */
    private $__key;
}

?>