/**
 * Template Object
 */
WebTable.Dark = {};

/**
 * Animation Duration
 */
WebTable.Dark._duration = 200;

/**
 * Template Specific Bindings
 * 
 * @returns void
 */
WebTable.Dark.bind = function (table)
{
    // Bind Form
    WebTable.Dark._formBind(table);
    
    // Remove Handlers
    WebTable._cache[table]['table#content'].off('click.Dark');

    // On Name Click
    WebTable._cache[table]['table#content'].on(
        'click.WebTable.Dark', null, table,
        function (e)
        {
            // Single Action
            if (!e.shiftKey)
            {            
                // Target Name
                var element = $(e.currentTarget);

                // Element ID
                id = element.attr('id');
                id = (id.slice(-4) == 'name') ? id.slice(0, -4) : id.slice(0, -7);

                // Toggle Menu
                if (e.altKey)
                {
                    $('#' + id + 'menu')
                        .animate({opacity: 'toggle', height: 'toggle'}, WebTable.Dark._duration);
                        //.toggle();
                }
                
                // Toggle Children
                else
                {
                    children = $('#' + id + 'children');
                    
                    if (children.length && children.children().length)
                    {
                        children
                            .animate({opacity: 'toggle', height: 'toggle'}, WebTable.Dark._duration);
                            //.toggle();                    
                    }
                }
            }
            
            e.stopPropagation();
        }
    );
    
    WebTable._cache[table]['table#content'].on(
        'click.WebTable.Dark', null, table,
        function (e)
        {
            // Massive Action
            if (e.shiftKey)
            {
                var f = function(){return $(this).css('display') == 'none'};
                var s = e.altKey ? 'table#menu' : 'table#children';
                var d = WebTable._cache[e.data][s].filter(f).length > 0 ?
                    'block' : 'none';
                WebTable._cache[e.data][s].css('display', d);
                $.fn.unselectText();
            }
            
            e.stopPropagation();
        }
    );
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
 * @param string focus
 *     Accepts the selector of the element to focus.
 * 
 * @return void
 */
WebTable.Dark.formShow = function (table, focus)
{
    WebTable.Dark._formLayout(table);

    WebTable._cache[table]['form-background'].fadeIn(WebTable.Dark._duration, function(){
        WebTable._cache[table]['form'].fadeIn(WebTable.Dark._duration, function(){
            $(focus).focus();
        })
    });
}

/**
* Web Table Form Hide
* 
* Hide (with animation) the Web Table form dialog.
* 
* @param string table
*     Accepts the name of the Table.
*     
* @return void
*/
WebTable.Dark.formHide = function (table)
{
    if (WebTable._cache[table]['form'].is(':visible') && WebTable._cache[table]['form-background'].is(':visible'))
         WebTable._cache[table]['form'].fadeOut(WebTable.Dark._duration, function(){
             WebTable._cache[table]['form-background'].fadeOut(WebTable.Dark._duration)
         });
}

/**
 * Web Table Form Bind
 * 
 * Bind various actions to hide/layout the Web Table form dialog.
 * 
 * @param string table
 *     Accepts the name of the Table.
 * 
 * @return void
 */
WebTable.Dark._formBind = function (table)
{
    // Remove Old Bindings
    WebTable._cache[table]['form-background'].off('click.Dark');
    $(document).off('keydown.Dark');
    $(window).off('resize.Dark');
    
    // Hide the Form when the background is clicked.
    WebTable._cache[table]['form-background'].on(
            'click.WebTable.Dark', null, table,
            function (e) {WebTable.Dark.formHide(e.data)}
    );
    
    // Hide the form when the escape key is pressed.
    $(document).on(
            'keydown.WebTable.Dark', null, table,
            function (e) { if(e.which == 27) WebTable.Dark.formHide(e.data) }
    );
    
    // Recalculate Form position when the window is resized.
    $(window).on(
            'resize.WebTable.Dark', null, table,
            function (e) { WebTable.Dark._formLayout(e.data) }
    );
}

/**
 * Web Table Form Layout
 * 
 * Correctly position the form elements on the page.
 * 
 * @param string table
 *     Accepts the name of the Table.
 * 
 * @return void
 */
WebTable.Dark._formLayout = function (table)
{
    // Retrieve Element Heights / Widths
    var w_height   = $(window).height();
    var w_width    = $(window).width();
    var s_left     = $(window).scrollLeft();
    var s_top      = $(window).scrollTop();
    var f_height   = WebTable._cache[table]['form'].height();
    var f_width    = WebTable._cache[table]['form'].width();
    
    // Center Form Elements
    WebTable._cache[table]['form'].css({
        'left'    : (w_width / 2)  - (f_width / 2)  + s_left,
        'top'     : (w_height / 2) - (f_height / 2) + s_top,
    });    
    WebTable._cache[table]['form-background'].css({
        'height'  : $(document).height(),
        'width'   : $(document).width(),
    });
}

//------------------------------------------------------------------------------
// Simply jQuery Text Selection Plug-In
//------------------------------------------------------------------------------

jQuery.fn.selectText = function ()
{
    var doc = document;
    var element = this[0];
    console.log(this, element);
    
    if (doc.body.createTextRange)
    {
        var range = document.body.createTextRange();
        range.moveToElementText(element);
        range.select();
    }
    else if (window.getSelection)
    {
        var selection = window.getSelection();        
        var range = document.createRange();
        range.selectNodeContents(element);
        selection.removeAllRanges();
        selection.addRange(range);
    }
}

jQuery.fn.unselectText = function ()
{
    if (window.getSelection)
    {
        if (window.getSelection().empty)                     // Chrome
            window.getSelection().empty();
        else if (window.getSelection().removeAllRanges)      // Firefox
            window.getSelection().removeAllRanges();
    }
    else if (document.selection && document.selection.empty) // IE?
        document.selection.empty();
}
