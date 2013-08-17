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
 * $LastChangedBy:$
 * $LastChangedDate:$
 */

/**
 * Initialize Template Object
 */
WebTable.Alpha = {};

/**
 * Animation Duration
 */
WebTable.Alpha._duration = 200;

/**
 * Template Specific Bindings
 * 
 * @return void
 */
WebTable.Alpha.bind = function(table)
{
    // Bind Form
    WebTable.Alpha._formBind(table);

    // Select All Buttons
    var buttons = $('.web-table-alpha-button');
    // Remove Old Handlers
    buttons.off('click.web-table-alpha');
    // Define Click Handlers
    buttons.on('click.web-table-alpha', function(event)
    {
        var button = $(event.currentTarget).toggleClass('clicked');
        $('#' + button.attr('id').slice(0, -6) + 'menu').slideToggle(200);
        event.stopPropagation();
    });

    //
    // Names
    //

    // Select All Names
    var names = $('.web-table-alpha-table-title, .web-table-alpha-row-title, .web-table-alpha-cell-title, .web-table-alpha-group-title');
    // Remove Old Handlers
    names.off('click.web-table-alpha');
    // Define Click Handlers
    names.on('click.web-table-alpha', function(event)
    {
        var title = $(event.currentTarget).toggleClass('clicked');
        $('#' + title.attr('id').slice(0, -5) + 'children').slideToggle(200);
    });
}

//------------------------------------------------------------------------------
//WEB TABLE FORM
//------------------------------------------------------------------------------

/**
 * Web Table Form Show
 * 
 * Display (with animation) the Web Table form dialog.
 * 
 * @param string
 *            table Accepts the name of the Table.
 * @param string
 *            focus Accepts the selector of the element to focus.
 * 
 * @return void
 */
WebTable.Alpha.formShow = function(table, focus)
{
    WebTable.Alpha._formLayout(table);

    WebTable._cache[table]['form-background']
            .fadeIn(WebTable.Alpha._duration, function()
            {
                WebTable._cache[table]['form']
                        .fadeIn(WebTable.Alpha._duration, function()
                        {
                            $(focus).focus();
                        })
            });
}

/**
 * Web Table Form Hide
 * 
 * Hide (with animation) the Web Table form dialog.
 * 
 * @param string
 *            table Accepts the name of the Table.
 * 
 * @return void
 */
WebTable.Alpha.formHide = function(table)
{
    WebTable._cache[table]['form'].fadeOut(WebTable.Alpha._duration, function()
    {
        WebTable._cache[table]['form-background']
                .fadeOut(WebTable.Alpha._duration)
    });
}

/**
 * Web Table Form Bind
 * 
 * Bind various actions to hide/layout the Web Table form dialog.
 * 
 * @param string
 *            table Accepts the name of the Table.
 * 
 * @return void
 */
WebTable.Alpha._formBind = function(table)
{
    // Remove Old Bindings
    WebTable._cache[table]['form-background'].off('click.Alpha');
    $(document).off('keydown.Alpha');
    $(window).off('resize.Alpha');

    // Hide the Form when the background is clicked.
    WebTable._cache[table]['form-background'].on(
        'click.WebTable.Alpha', null, table, function(e)
        {WebTable.Alpha.formHide(e.data)});

    // Hide the form when the escape key is pressed.
    $(document).on('keydown.WebTable.Alpha', null, table, function(e)
    {
        if (e.which == 27)
            WebTable.Alpha.formHide(e.data)
    });

    // Recalculate Form position when the window is resized.
    $(window).on('resize.WebTable.Alpha', null, table, function(e)
    {
        WebTable.Alpha._formLayout(e.data)
    });
}

/**
 * Web Table Form Layout
 * 
 * Correctly position the form elements on the page.
 * 
 * @param string
 *            table Accepts the name of the Table.
 * 
 * @return void
 */
WebTable.Alpha._formLayout = function(table)
{
    // Retrieve Element Heights / Widths
    var w_height = $(window).height();
    var w_width = $(window).width();
    var s_left = $(window).scrollLeft();
    var s_top = $(window).scrollTop();
    var f_height = WebTable._cache[table]['form'].height();
    var f_width = WebTable._cache[table]['form'].width();

    // Center Form Elements
    WebTable._cache[table]['form'].css({
    'left' : (w_width / 2) - (f_width / 2) + s_left,
    'top' : (w_height / 2) - (f_height / 2) + s_top,
    });
    WebTable._cache[table]['form-background'].css({
    'height' : $(document).height(),
    'width' : $(document).width(),
    });
}
