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
 * @version    SVN: $Id: Ajax.php 118 2013-08-17 22:12:38Z matt $
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
namespace Web\Table;

/**
 * Ajax
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    Release @release-version@
 * @since      Class available since Initial Release.
 */
abstract class Ajax
{
    /**
     * If true, the Table is saved and loaded from a $_SESSION variable. If
     * false, the Table is loaded from disk on each call.
     *
     * @var boolean
     */
    public $cache;

    /**
     * An alternate save-location for the Table database file.
     *
     * @var string
     */
    public $path;

    /**
     * Target Selector for Table Location
     *
     * @var string
     */
    public $target;

    /**
     * The actual Table object.
     *
     * @var Table
     */
    public $table;

    /**
     * Operation to be performed.
     *
     * @var string
     */
    public $operation;

    /**
     * Array of arguments for use with the operation. If null, we assume the
     * user is requesting the 'form' for the operation. If an operation doesn't
     * require any arguments, an empty array should be used.
     *
     * @var array
     */
    public $arguments;

    /**
     * The Current Row
     *
     * @var Row
     */
    public $row;

    /**
     * The Current Cell
     *
     * @var Cell
     */
    public $cell;

    /**
     * The Current Group
     *
     * @var Group
     */
    public $group;

    /**
     * The Current Item
     *
     * @var Item
     */
    public $item;

    /**
     * Public Constructor
     *
     * @param array $data
     *     Accepts request data array.
     *
     * @return void
     */
    public function __construct($data)
    {
        // Extract Request Data
        $this->operation = $data['operation'];
        $this->arguments = $data['arguments'];

        // Handle System Table
        if ($data['table'] === null && $this->operation !== 'LoadTable')
            return;

        // Load Data from "Cache"
        if (isset($_SESSION['WebTable'][$data['table']]))
        {
            $this->cache  = $_SESSION['WebTable'][$data['table']]['cache'];
            $this->path   = $_SESSION['WebTable'][$data['table']]['path'];
            $this->target = $_SESSION['WebTable'][$data['table']]['target'];
            $this->table  = $_SESSION['WebTable'][$data['table']]['table'];

            // Check "Cache" Flag
            if (!$this->cache)
                $this->table = Table::load($data['table'], $this->path);
        }

        // Get Elements
        if (is_integer($data['row'])){
            $this->row = $this->table->getRow($data['row']);
            if (is_integer($data['cell'])){
                $this->cell = $this->row->getCell($data['cell']);
                if (is_integer($data['group'])){
                    $this->group = $this->cell->getGroup($data['group']);
                    if (is_integer($data['item'])){
                        $this->item = $this->group->getItem($data['item']);}}}}
    }

    /**
     * Handle <Operation>:Data
     *
     * @return void
     */
    public function processData()
    {
        $this->sendFail('Missing Handler',
            'Data Process method not implemented for operation ' .
            $this->operation);
    }

    /**
     * Handle <Operation>:Form
     *
     * @return void
     */
    public function processForm()
    {
        $this->sendFail('Missing Handler',
            'Form Process method not implemented for operation ' .
            $this->operation);
    }

    /**
     * Save the Table
     *
     * @return void
     */
    public function save()
    {
        // Save the Session
        if ($this->cache)
            $_SESSION['WebTable'][$this->table->name]['table'] = $this->table;

        // Save the Table
        $this->table->save($this->path);
    }

    /**
     * Send Data Response
     *
     * Usage:
     *   sendData($action[, $target[, $html]]);
     *   sendData($action, $target, $html[, $action, $target, $html[, ...]]);
     *
     * @param string $action
     *     Response Action
     * @param string $target
     *     Response Target
     *     (Default: null)
     * @param string $html
     *     Response HTML
     *     (Default: null)
     *
     * @return void
     */
    public function sendData($action, $target = null, $html = null)
    {
        // Build Actions
        $actions = array();
        foreach (array_chunk(func_get_args(), 3) as $chunk)
        {
            $actions[] = array
            (
                'action' => isset($chunk[0]) ? $chunk[0] : null,
                'target' => isset($chunk[1]) ? $chunk[1] : null,
                'html'   => isset($chunk[2]) ? $chunk[2] : null,
            );
        }

        // Successful output array.
        $output = array
        (
            'table'    => $this->table ? $this->table->name : null,
            'template' => $this->table ? $this->table->template->name : null,
            'form'     => false,
            'actions'  => $actions,
        );

        // Encode and echo the content.
        echo json_encode($output);

        // Terminate Normally
        exit(0);
    }

    /**
     * Send Form Response
     *
     * @param string $badge
     *     Class string for badge element. Should be one of 'new', 'edit',
     *     'clear', 'collapse', 'expand', 'delete', 'warning', or 'success'.
     * @param string $title
     *     Accepts the title of the form.
     * @param string $message
     *     Accepts the message of the form.
     * @param string $items
     *     Accepts the items HTML of the form.
     * @param string $note
     *     Accepts the note of the form.
     * @param string $buttons
     *     Accepts the buttons HTML of the form.
     * @param string $focus
     *     Identifier of DOM element to focus on.
     * @param string $submit
     *     Accepts the "onsubmit" script of the form.
     *
     * @return void
     */
    public function sendForm($badge, $title, $message, $items, $note, $buttons,
        $focus = null, $submit = null)
    {
        // Create Response
        $response = array
        (
            'table'    => $this->table ? $this->table->name : null,
            'template' => $this->table ? $this->table->template->name : null,
            'form'     => true,
            'badge'    => $badge,
            'title'    => $title,
            'message'  => $message,
            'items'    => $items,
            'note'     => $note,
            'buttons'  => $buttons,
            'focus'    => $focus,
            'submit'   => $submit . 'return false;',
        );

        // Encode and send (echo) the response.
        echo json_encode($response);

        // Terminate Normally
        exit(0);
    }

    /**
     * Send (Bad) Form Response
     *
     * @param string $title
     *     Accepts the title of the form.
     * @param string $message
     *     Accepts the message of the form.
     *
     * @return void
     */
    public function sendFail($title, $message)
    {
        $buttons = ($this->table === null) ? '' :
            $this->table->template->htmlFormInputButton($this->table, 'Close');

        $this->sendForm('error', $title, $message, null, null, $buttons);

    }

    /**
     * Static Error Response
     *
     * If the correct Ajax subclass has not or cannot be loaded, we create an
     * instance of the Error class and send a failure.
     *
     * @param array $data
     *     Array of POST data.
     * @param string $title
     *     Accepts the title of the form.
     * @param string $message
     *     Accepts the message of the form.
     *
     * @return void
     */
    public static function error($data, $title, $message)
    {
        // After trying the Error operation...
        if ($data['operation'] === 'Error')
        {
            // Echo Message
            echo $title . ' - ' . $message;
            // Terminate Normally
            exit(0);
        }

        // Change the current request operation to "Error". Encode the data and
        // re-react to the response.
        $data['operation'] = 'Error';
        $data['arguments'] = array($title, $message);
        $_POST['web-table'] = json_encode($data);
        self::react();
    }

    /**
     * React to AJAX
     *
     * @return void
     */
    public static function react()
    {
        try
        {
            // Load the Autoloader
            require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Autoloader.php';

            // Extract Request Data
            $data = json_decode($_POST['web-table'], true);

            // Start/Refresh the Session
            @session_start();

            // Build Class Name
            $class = '\\Web\\Table\\Ajax\\' . $data['operation'];

            // Check if Handler Exists
            if (!class_exists($class, true))
                throw Exception::factory('AJAX-MISSING-HANDLER')->localize($data['operation']);

            // Instantiate Ajax Handler
            $ajax = new $class($data);

            // Process Request
            if ($ajax->arguments !== null)
                $ajax->processData();
            else
                $ajax->processForm();
        }
        // Catch all Exceptions
        catch (\Exception $e)
        {
            self::error($data, 'Web Table Exception', $e->getMessage());
        }
    }
}

// If loaded while 'web-table' data is specified, react.
if ($_POST['web-table'] !== null)
    Ajax::react();
?>