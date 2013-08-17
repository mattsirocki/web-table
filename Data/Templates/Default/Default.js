/**
 * Initialize Template Object
 */
WebTable.Default = {};

/**
 * Animation Duration
 */
WebTable.Default._duration = 200;

/**
 * Template Specific Bindings
 * 
 * @return void
 */
WebTable.Default.bind = function(table)
{
    // Bind Form
    WebTable.Default._formBind(table);
}

// ------------------------------------------------------------------------------
// WEB TABLE FORM
// ------------------------------------------------------------------------------

/**
 * Web Table Form Show
 * 
 * Display (with animation) the Web Table form dialog.
 * 
 * @param string
 *     table Accepts the name of the Table.
 * @param string
 *     focus Accepts the selector of the element to focus.
 * 
 * @return void
 */
WebTable.Default.formShow = function(table, focus)
{
    WebTable.Default._formLayout(table);

    WebTable._cache[table]['form-background'].fadeIn(
        WebTable.Default._duration, function() {
            WebTable._cache[table]['form'].fadeIn(
                WebTable.Default._duration, function() {
                    $(focus).focus()})});
}

/**
 * Web Table Form Hide
 * 
 * Hide (with animation) the Web Table form dialog.
 * 
 * @param string
 *     table Accepts the name of the Table.
 * 
 * @return void
 */
WebTable.Default.formHide = function(table)
{
    WebTable._cache[table]['form'].fadeOut(
        WebTable.Default._duration, function() {
            WebTable._cache[table]['form-background'].fadeOut(
                WebTable.Default._duration)});
}

/**
 * Web Table Form Bind
 * 
 * Bind various actions to hide/layout the Web Table form dialog.
 * 
 * @param string
 *     table Accepts the name of the Table.
 * 
 * @return void
 */
WebTable.Default._formBind = function(table)
{
    // Hide the Form when the background is clicked.
    WebTable._cache[table]['form-background'].off('click.Default');
    WebTable._cache[table]['form-background'].on(
        'click.WebTable.Default', null, table, function(e) {
            WebTable.Default.formHide(e.data)});

    // Hide the form when the escape key is pressed.
    $(document).off('keydown.Default');
    $(document).on(
        'keydown.WebTable.Default', null, table, function(e) {
            if (e.which == 27)
                WebTable.Default.formHide(e.data)});

    // Recalculate Form position when the window is resized.
    $(window).off('resize.Default');
    $(window).on(
        'resize.WebTable.Default', null, table, function(e) {
            WebTable.Default._formLayout(e.data)});
}

/**
 * Web Table Form Layout
 * 
 * Correctly position the form elements on the page.
 * 
 * @param string
 *     table Accepts the name of the Table.
 * 
 * @return void
 */
WebTable.Default._formLayout = function(table)
{
    // Retrieve Element Heights / Widths
    var w_height = $(window).height();
    var w_width  = $(window).width();
    var s_left   = $(window).scrollLeft();
    var s_top    = $(window).scrollTop();
    var f_height = WebTable._cache[table]['form'].height();
    var f_width  = WebTable._cache[table]['form'].width();

    // Center Form Elements
    WebTable._cache[table]['form'].css({
        'left' :  (w_width / 2) -  (f_width / 2) + s_left,
        'top'  : (w_height / 2) - (f_height / 2) + s_top,
    });
    WebTable._cache[table]['form-background'].css({
        'height' : $(document).height(),
        'width'  : $(document).width(),
    });
}
