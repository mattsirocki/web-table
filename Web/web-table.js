/**
 * This file is part of Web_Table.
 *
 * @category   Web
 * @package    Web_Table
 * @author     Matt Sirocki <mattsirocki@gmail.com>
 * @copyright  2012 Matt Sirocki
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.html)
 * @version    SVN: $Id:$
 * @since      File available since Initial Release.
 * @filesource
 */

/*
 * $LastChangedBy: matthew.sirocki $
 * $LastChangedDate: 2012-05-31 19:37:34 -0400 (Thu, 31 May 2012) $
 */

// Initialize WebTable Object
var WebTable = {};

//------------------------------------------------------------------------------
// PUBLIC API
//------------------------------------------------------------------------------

/**
 * Call this function to load a table into the DOM.
 * 
 * @param string table
 *     Accepts the name of the Table.
 * @param string target
 *     jQuery selector; the Table HTML will be appended to every element matched
 *     by this identifier.
 * @param boolean cache
 *     If true, some server-side caching techniques will be employed.
 * @param string path
 *     Alternate path to look for and save the Table.
 *     
 * @returns boolean
 *     Returns true if the Table was loaded successfully.
 */
WebTable.load = function (table, target, cache, path)
{
    // Default Function Argument Values
    target = (target !== undefined) ? target : 'body';
    cache  = (cache  !== undefined) ? cache  : true;
    path   = (path   !== undefined) ? path   : null;
    
    // Load jQuery
    if (!jQuery)
    	return false;
    
    // Load Web Table
    $(document).ready(function()
    {
        WebTable._request('LoadTable', [cache, path, target, table])
    });
}

//------------------------------------------------------------------------------
// WEB TABLE INITIALIZATION
//------------------------------------------------------------------------------

/**
 * Perform Initialization Tasks
 * 
 * @returns void
 */
WebTable._initialize = function()
{
    // Check if jQuery is Loaded
    if (!jQuery)
        return;

    // Determine Script Root
    var tags = document.getElementsByTagName('script');
    var tag  = tags[tags.length - 1]
    var root = tag.src.split('?')[0].split('/').slice(0, -2).join('/');

    // Initialize Root Path
    WebTable.root = root;
    
    // Initialize System Variables
    WebTable._cache = {};
    
    // Reset the Session
    WebTable._request('Initialize', [root]);
}

//------------------------------------------------------------------------------
// WEB TABLE CACHE
//------------------------------------------------------------------------------

/**
 * Cache Elements for the Specified Table
 * 
 * @param string table
 *     Accepts the name of the Table.
 * @param string template
 *     Accepts the name of the Template.
 * 
 * @returns void
 */
WebTable._cacheElements = function (table, template)
{
    WebTable._cache[table] =
    {
        'table'           : $('#web-table-' + table),
        'table#children'  : $('#web-table-' + table + ' [id$="children"]'),
        'table#content'   : $('#web-table-' + table + ' [id$="content"]'),
        'table#menu'      : $('#web-table-' + table + ' [id$="menu"]'),
        'form'            : $('#web-table-' + table + '-form'),
        'form form'       : $('#web-table-' + table + '-form form'),
        'form-badge'      : $('#web-table-' + table + '-form-badge'),
        'form-title'      : $('#web-table-' + table + '-form-title'),
        'form-message'    : $('#web-table-' + table + '-form-message'),
        'form-items'      : $('#web-table-' + table + '-form-items'),
        'form-note'       : $('#web-table-' + table + '-form-note'),
        'form-buttons'    : $('#web-table-' + table + '-form-buttons'),
        'form-background' : $('#web-table-' + table + '-form-background'),
    };
    
    WebTable._templateBind(table, template);
}

//------------------------------------------------------------------------------
// WEB TABLE FORM
//------------------------------------------------------------------------------

/**
 * Web Table Form Show
 * 
 * Display (with animation) the Web Table form dialog.
 * 
 * @param string table
 *     Accepts the name of the Table.
 * @param string template
 *     Accepts the name of the Template.
 * @param string focus
 *     Accepts the selector of the element to focus.
 * 
 * @returns void
 */
WebTable._formShow = function (table, template, focus)
{
    if (WebTable._cache[table] && WebTable[template] && WebTable[template].formShow)
        WebTable[template].formShow(table, focus);
    else
    {
        WebTable._cache[table]['form-background'].show();
        WebTable._cache[table]['form'].show();
    }
}

/**
 * Web Table Form Hide
 * 
 * Hide the Web Table form dialog.
 * 
 * @param string table
 *     Accepts the name of the Table.
 * @param string template
 *     Accepts the name of the Template.
 *     
 * @returns void
 */
WebTable._formHide = function (table, template)
{
    if (WebTable._cache[table] && WebTable[template] && WebTable[template].formHide)
        WebTable[template].formHide(table);
    else
    {
        WebTable._cache[table]['form'].hide();
        WebTable._cache[table]['form-background'].hide();
    }
}

//------------------------------------------------------------------------------
// WEB TABLE TEMPLATE
//------------------------------------------------------------------------------

/**
 * Web Table Template Bind
 * 
 * Calls the template-specific bind function.
 * 
 * @param string table
 *     Accepts the name of the Table.
 * @param string template
 *     Accepts the name of the Template.
 * 
 * @returns void
 */
WebTable._templateBind = function (table, template)
{
    if (WebTable._cache[table] && WebTable[template] && WebTable[template].bind)
        WebTable[template].bind(table);        
}

//------------------------------------------------------------------------------
// WEB TABLE REQUEST (AJAX)
//------------------------------------------------------------------------------

/**
 * Web Table Request
 * 
 * Submit a request to the Web Table "service."
 */
WebTable._request = function (operation, arguments, table, row, cell, group, item)
{
    // Default Function Argument Values
    arguments = (arguments !== undefined) ? arguments : null;
    table     = (table     !== undefined) ? table     : null;
    row       = (row       !== undefined) ? row       : null;
    cell      = (cell      !== undefined) ? cell      : null;
    group     = (group     !== undefined) ? group     : null;
    item      = (item      !== undefined) ? item      : null;
    
    // Perform Request
    return $.ajax({
        url      : WebTable.root + '/Source/Web/Table/Ajax.php',
        type     : 'POST',
        dataType : 'json',
        data     : {
        	'web-table' : JSON.stringify({
	            'operation' : operation,
	            'arguments' : arguments,
	            'table'     : table,
	            'row'       : row,
	            'cell'      : cell,
	            'group'     : group,
	            'item'      : item,
        	})},
    })
    .done(WebTable._requestDone)
    .fail(WebTable._requestFail);
}

/**
 * Web Table Request Success
 * 
 * If the request was successful, we must either display information in the
 * #web-table-form or modify the DOM in some way.
 * 
 * @param jqXHR data
 *     Accepts the jQuery jqXHR object.
 * 
 * @returns void
 */
WebTable._requestDone = function (data)
{
    if (data.form)
    {
        // Check that the Web Table pop-up form was loaded.
        if (!WebTable._cache[data.table] || !WebTable._cache[data.table]['form'].length)
            return WebTable._alert(data.title, data.message);
        
        // Fill the Form
        WebTable._cache[data.table]['form form'].attr('onsubmit', data.submit);
        WebTable._cache[data.table]['form-badge'].attr('class', data.badge);
        WebTable._cache[data.table]['form-title'].html(data.title);
        WebTable._cache[data.table]['form-message'].html(data.message);
        WebTable._cache[data.table]['form-items'].html(data.items);
        WebTable._cache[data.table]['form-note'].html(data.note);
        WebTable._cache[data.table]['form-buttons'].html(data.buttons);
                
        // If the form isn't visible, show it.
        WebTable._formShow(data.table, data.template, data.focus);
    }
    else
    {
        var form = false;
        
        for (i = 0; i < data.actions.length; i++)
        {
            var action = data.actions[i].action;
            var target = data.actions[i].target;
            var html   = data.actions[i].html;
            
            switch(action)
            {
                // No Action
                case 'pass':
                    break;
                    
                // DOM Manipulation
                case 'append':
                    $(target).append(html);
                    break;
                case 'form':
                    form = true;
                case 'html':
                    $(target).html(html);
                    break;
                case 'insert-after':
                    $(target).after(html);
                    break;
                case 'insert-before':
                    $(target).before(html);
                    break;
                case 'prepend':
                    $(target).prepend(html);
                    break;
                case 'remove':
                    $(target).detach();
                    break;    
                case 'replace':
                    $(target).replaceWith(html);
                    break;
    
                // Special Actions
                case 'template-change':
                    WebTable._cache[data.table]['form'].detach();
                    WebTable._cache[data.table]['form-background'].detach();
                    $(target).replaceWith(html);
                    WebTable._request('LoadTemplate', [data.template], data.table);
                    break;
                case 'template-script':
                    $.getScript(target).done(function () {
                        WebTable._templateBind(data.table, data.template);
                    });
                    break;
                    
                // Invalid Action
                default:
                    return WebTable._alert('Invalid Action',
                        'Received an invalid action, "' + action + '".');
                    break;                
            }
        }

        WebTable._cacheElements(data.table, data.template);
        
        if (!form)
            WebTable._formHide(data.table, data.template);
    }
}

/**
 * Web Table Request Failure
 * 
 * If the request failed, display a native alert. We can't display an error
 * using the #web-table-form because this isn't a standard error.
 * 
 * @param jqXHR data
 *     Accepts the jQuery jqXHR object.
 * 
 * @returns void
 */
WebTable._requestFail = function (data)
{
    // If we got any response text, display it.
    if (data.status === 404)
        return WebTable._alert('Error',
            'Make sure you have specified the correct Web Table root.');
    if (data.responseText)
        return WebTable._alert('Raw Response', data.responseText);
    
    // Display Standardized Alert
    WebTable._alert('Invalid Response',
        'There was a problem talking to the server.');
}

//------------------------------------------------------------------------------
// GENERAL
//------------------------------------------------------------------------------

/**
 * Provides Standardized Project Alert
 * 
 * @param string title
 *     Accepts the title of the alert.
 * @param string message
 *     Accepts the message of the alert.
 * 
 * @returns void
 */
WebTable._alert = function (title, message)
{
    alert('[Web Table] - ' + title + '\n\n' + message);
}

//------------------------------------------------------------------------------
// EXECUTE INITIALIZATION
//------------------------------------------------------------------------------

WebTable._initialize();