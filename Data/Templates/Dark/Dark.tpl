//DESCRIPTION///////////////////////////////////////////////////////////////////
{% description %}
<p>This is a darker, cooler, better written template.</p>
{% end %}

//FORM//////////////////////////////////////////////////////////////////////////

{% form %}
<div class="web-table-dark-form" id="{table-id}-form">
  <form action="#">
    <div id="{table-id}-form-title"></div>
    <div class="web-table-dark-form-divider"></div>
    <div id="{table-id}-form-message"></div>
    <div id="{table-id}-form-items"></div>
    <div id="{table-id}-form-note"></div>
    <div class="web-table-dark-form-divider"></div>
    <div id="{table-id}-form-buttons"></div>
  </form>
</div>
<div class="web-table-dark-form-background" id="{table-id}-form-background"></div>
{% end %}

{% form-item %}
<div class="web-table-dark-form-item">
  <div class="web-table-dark-form-item-name">{form-item-name}</div>
  <div class="web-table-dark-form-item-input">
    {form-item-input}
    <div class="web-table-dark-form-item-note">{form-item-note}</div>
  </div>
</div>
{% end %}

//TABLE/////////////////////////////////////////////////////////////////////////

{% table-header %}
<div class="web-table-dark" id="{table-id}">
  <div class="web-table-dark-button" id="{table-id}-content">{template:table-content}</div>
  <div class="web-table-dark-menu" id="{table-id}-menu">
    <span class="web-table-dark-button" onclick="{menu-append-row}">Append</span>
    <span class="web-table-dark-button" onclick="{menu-prepend-row}">Prepend</span>
    <span class="web-table-dark-button" onclick="{menu-clear-rows}">Clear</span>
    <span class="web-table-dark-button" onclick="{menu-edit-table}">Edit</span>
    <span class="web-table-dark-button" onclick="{menu-edit-template}">Template</span>
  </div>
  <div id="{table-id}-children">
{% end %}

{% table-content %}
{table-alias} (<code>#{table-name}</code>)
{% end %}

{% table-footer %}
  </div>
</div>
{% end %}

//ROW///////////////////////////////////////////////////////////////////////////

{% row-header %}
<div class="web-table-dark-row" id="{row-id}">
  <div class="web-table-dark-button" id="{row-id}-content">{template:row-content}</div>
  <div class="web-table-dark-menu" id="{row-id}-menu">
    <span class="web-table-dark-button" onclick="{menu-append-cell}">Append</span>
    <span class="web-table-dark-button" onclick="{menu-prepend-cell}">Prepend</span>
    <span class="web-table-dark-button" onclick="{menu-clear-cells}">Clear</span>
    <span class="web-table-dark-button" onclick="{menu-insert-row}">Insert</span>
    <span class="web-table-dark-button" onclick="{menu-edit-row}">Edit</span>
    <span class="web-table-dark-button" onclick="{menu-remove-row}">Remove</span>
  </div>
  <div id="{row-id}-children">
{% end %}

{% row-content %}
{row-name}
{% end %}

{% row-footer %}
  </div>
</div>
{% end %}

//CELL//////////////////////////////////////////////////////////////////////////

{% cell-header %}
<div class="web-table-dark-cell" id="{cell-id}">
  <div class="web-table-dark-button" id="{cell-id}-content">{template:cell-content}</div>
  <div class="web-table-dark-menu" id="{cell-id}-menu">
    <span class="web-table-dark-button" onclick="{menu-append-group}">Append</span>
    <span class="web-table-dark-button" onclick="{menu-prepend-group}">Prepend</span>
    <span class="web-table-dark-button" onclick="{menu-clear-groups}">Clear</span>
    <span class="web-table-dark-button" onclick="{menu-insert-cell}">Insert</span>
    <span class="web-table-dark-button" onclick="{menu-edit-cell}">Edit</span>
    <span class="web-table-dark-button" onclick="{menu-remove-cell}">Remove</span>
  </div>
  <div id="{cell-id}-children">
{% end %}

{% cell-content %}
{cell-name}
{% end %}

{% cell-footer %}
  </div>
</div>
{% end %}

//GROUP/////////////////////////////////////////////////////////////////////////

{% group-header %}
<div class="web-table-dark-group" id="{group-id}">
  <div class="web-table-dark-button" id="{group-id}-content">{template:group-content}</div>
  <div class="web-table-dark-menu" id="{group-id}-menu">
    <span class="web-table-dark-button" onclick="{menu-append-item}">Append</span>
    <span class="web-table-dark-button" onclick="{menu-prepend-item}">Prepend</span>
    <span class="web-table-dark-button" onclick="{menu-clear-items}">Clear</span>
    <span class="web-table-dark-button" onclick="{menu-insert-group}">Insert</span>
    <span class="web-table-dark-button" onclick="{menu-edit-group}">Edit</span>
    <span class="web-table-dark-button" onclick="{menu-remove-group}">Remove</span>
  </div>
  <div id="{group-id}-children">
{% end %}

{% group-content %}
{group-name}
{% end %}

{% group-footer %}
  </div>
</div>
{% end %}

//ITEM//////////////////////////////////////////////////////////////////////////

{% item-header %}
<div class="web-table-dark-item" id="{item-id}">
  <div id="{item-id}-content">{template:item-content}</div>
  <div class="web-table-dark-menu" id="{item-id}-menu">
    <span class="web-table-dark-button" onclick="{menu-insert-item}">Insert</span>
    <span class="web-table-dark-button" onclick="{menu-edit-item}">Edit</span>
    <span class="web-table-dark-button" onclick="{menu-remove-item}">Remove</span>
  </div>
{% end %}

{% item-content %}
{item-name}{item-text}
{% end %}

{% item-checkable-content %}
{item-checkbox}<label for="{item-id}-checkbox">{item-name}</label><span id="{item-id}-text">{item-text}</span>
{% end %}

{% item-footer %}
</div>
{% end %}