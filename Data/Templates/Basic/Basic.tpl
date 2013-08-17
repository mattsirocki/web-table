//DESCRIPTION///////////////////////////////////////////////////////////////////
{% description %}
<p>This is a bare bones template. For debugging purposes mostly.</p>
{% end %}

<!--
  
  FORM
  
  All Table modifications interact with the user via the form.

  Required Elements:
    #{table-id}-form
    #{table-id}-form form
    #{table-id}-form-title
    #{table-id}-form-message
    #{table-id}-form-items
    #{table-id}-form-note
    #{table-id}-form-buttons
    #{table-id}-form-background

-->
{% form %}
<div id="{table-id}-form" style=" background-color: white; position: fixed; left: 0px; top: 0px;">
  <form action="#">
    <div id="{table-id}-form-title"></div>
    <div id="{table-id}-form-message"></div>
    <div id="{table-id}-form-items"></div>
    <div id="{table-id}-form-note"></div>
    <div id="{table-id}-form-buttons"></div>
  </form>
</div>
<div id="{table-id}-form-background"></div>
{% end %}

{% form-item %}
{form-item-name}{form-item-input}{form-item-note}
{% end %}

<!--

  TABLE

  Required Elements
    div#{table-id}
    #{table-id}-name

-->

{% table-header %}
<div id="{table-id}">
  <span id="{table-id}-content">{template:table-content}</span>
  <a href="#" onclick="{menu-append-row}">Append</a>
  <a href="#" onclick="{menu-prepend-row}">Prepend</a>
  <a href="#" onclick="{menu-clear-rows}">Clear</a>
  <a href="#" onclick="{menu-edit-table}">Edit</a>
  <a href="#" onclick="{menu-edit-template}">Template</a>
  <div id="{table-id}-children">
{% end %}

{% table-content %}
<code>Table:</code>{table-alias} (<code>#{table-name}</code>)
{% end %}

{% table-footer %}
  </div>
</div>
{% end %}

//ROW///////////////////////////////////////////////////////////////////////////

{% row-header %}
<div id={row-id}>
  <span id="{row-id}-content">{template:row-content}</span>
  <a href="#" onclick="{menu-append-cell}">Append</a>
  <a href="#" onclick="{menu-prepend-cell}">Prepend</a>
  <a href="#" onclick="{menu-clear-cells}">Clear</a>
  <a href="#" onclick="{menu-insert-row}">Insert</a>  
  <a href="#" onclick="{menu-edit-row}">Edit</a>
  <a href="#" onclick="{menu-remove-row}">Remove</a>
  <div id="{row-id}-children">
{% end %}

{% row-content %}
<code>Row:</code>{row-name}
{% end %}

{% row-footer %}
  </div>
</div>
{% end %}

//CELL//////////////////////////////////////////////////////////////////////////

{% cell-header %}
<div id="{cell-id}">
  <span id="{cell-id}-content">{template:cell-content}</span>
  <a href="#" onclick="{menu-append-group}">Append</a>
  <a href="#" onclick="{menu-prepend-group}">Prepend</a>
  <a href="#" onclick="{menu-clear-groups}">Clear</a>
  <a href="#" onclick="{menu-insert-cell}">Insert</a>
  <a href="#" onclick="{menu-edit-cell}">Edit</a>
  <a href="#" onclick="{menu-remove-cell}">Remove</a>
  <div id="{cell-id}-children">
{% end %}

{% cell-content %}
<code>Cell:</code>{cell-name}
{% end %}

{% cell-footer %}
  </div>
</div>
{% end %}

//GROUP/////////////////////////////////////////////////////////////////////////

{% group-header %}
<div id="{group-id}">
  <span id="{group-id}-content">{template:group-content}</span>
  <a href="#" onclick="{menu-append-item}">Append</a>
  <a href="#" onclick="{menu-prepend-item}">Prepend</a>
  <a href="#" onclick="{menu-clear-items}">Clear</a>
  <a href="#" onclick="{menu-insert-group}">Insert</a>
  <a href="#" onclick="{menu-edit-group}">Edit</a>
  <a href="#" onclick="{menu-remove-group}">Remove</a>
  <div id="{group-id}-children">
{% end %}

{% group-content %}
<code>Group:</code>{group-name}
{% end %}

{% group-footer %}
  </div>
</div>
{% end %}

//ITEM//////////////////////////////////////////////////////////////////////////

{% item-header %}
<div id="{item-id}">
  <span id="{item-id}-content">{template:item-content}</span>
  <a href="#" onclick="{menu-insert-item}">Insert</a>
  <a href="#" onclick="{menu-edit-item}">Edit</a>
  <a href="#" onclick="{menu-remove-item}">Remove</a>
</div>
{% end %}

{% item-content %}
<code>Item:</code>{item-name}{item-text}
{% end %}

{% item-checkable-content %}
<code>Item:</code>{item-checkbox}{item-name}{item-text}
{% end %}

{% item-footer %}
{% end %}
