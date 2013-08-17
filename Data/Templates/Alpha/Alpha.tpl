//DESCRIPTION///////////////////////////////////////////////////////////////////
{% description %}
<p>This is an improved version of the default template.</p>
{% end %}

//FORM//////////////////////////////////////////////////////////////////////////

{% form %}
<div class="web-table-alpha-form" id="{table-id}-form">
  <form action="#" id="{table-id}-form-container">
    <div class="success" id="{table-id}-form-title-badge"></div>
    <div class="web-table-alpha-form-title" id="{table-id}-form-title"></div>
    <div class="web-table-alpha-form-divider"></div>
    <div class="web-table-alpha-form-message" id="{table-id}-form-message"></div>
    <div class="web-table-alpha-form-items" id="{table-id}-form-items"></div>
    <div class="web-table-alpha-form-note" id="{table-id}-form-note"></div>
    <div class="web-table-alpha-form-divider"></div>
    <div class="web-table-alpha-form-buttons" id="{table-id}-form-buttons"></div>
  </form>
</div>
<div class="web-table-alpha-form-background" id="{table-id}-form-background"></div>
{% end %}

{% form-item %}
<div class="web-table-alpha-form-item">
  <div class="web-table-alpha-form-item-name">{form-item-name}</div>
  <div class="web-table-alpha-form-item-input">{form-item-input}</div>
  <div class="web-table-alpha-form-item-note">{form-item-note}</div>
</div>
{% end %}

//TABLE/////////////////////////////////////////////////////////////////////////

{% table-header %}
<!-- Alpha-Table -->
<div class="web-table-alpha-table" id="{table-id}">
  <div class="web-table-alpha-display-row">
    <div class="web-table-alpha-table-separator"></div>
    <div class="web-table-alpha-display-cell">

      <!-- Alpha-Table-Name -->
      <div class="web-table-alpha-line"></div>
      <div class="web-table-alpha-table-title" id="{table-id}-title">
        <span class="web-table-alpha-button" id="{table-id}-button"></span>
        <span class="web-table-alpha-name" id="{table-id}-name">{table-name}</span>
      </div>
  
      <!-- Alpha-Table-Menu -->
      <div class="web-table-alpha-menu" id="{table-id}-menu">
        <div class="web-table-alpha-divider"></div>
        <span class="web-table-alpha-menu-button" onclick="{menu-append-row}">
          <span class="web-table-alpha-menu-button-icon new"></span>
          Add Row
        </span>
        <span class="web-table-alpha-menu-button-separator"></span>
        <span class="web-table-alpha-menu-button" onclick="{menu-edit-table}">
          <span class="web-table-alpha-menu-button-icon edit"></span>
          Edit Table Alias
        </span>
        <span class="web-table-alpha-menu-button-separator"></span>
        <span class="web-table-alpha-menu-button" onclick="{menu-clear-rows}">
          <span class="web-table-alpha-menu-button-icon clear"></span>
          Clear All Rows
        </span>
        <span class="web-table-alpha-menu-button-separator"></span>
        <span class="web-table-alpha-menu-button" onclick="{menu-edit-template}">
          <span class="web-table-alpha-menu-button-icon collapse"></span>
          Change Table Template
        </span>
        <span class="web-table-alpha-menu-button-separator"></span>
        <div class="web-table-alpha-divider"></div>
      </div>
    </div>
    <div class="web-table-alpha-table-separator"></div>
  </div>
  <div class="web-table-alpha-display-row">
    <div class="web-table-alpha-table-separator"></div>
    <div class="web-table-alpha-display-cell">

      <!-- Alpha-Table-Children -->
      <div class="web-table-alpha-table-children" id="{table-id}-children">

{% end %}

{% table-content %}
{table-alias} (<code>#{table-name}</code>)
{% end %}

{% table-footer %}
      </div>
      <div class="web-table-alpha-line"></div>
    </div>
    <div class="web-table-alpha-table-separator"></div>
  </div>
</div>
{% end %}

//ROW///////////////////////////////////////////////////////////////////////////

{% row-header %}
        <!-- Alpha-Row -->
        <div class="web-table-alpha-row" id="{row-id}">
  
          <!-- Alpha-Row-Name -->
          <div class="web-table-alpha-divider"></div>
          <div class="web-table-alpha-row-title" id="{row-id}-title">
            <span class="web-table-alpha-button" id="{row-id}-button"></span>
            <span class="web-table-alpha-name" id="{row-id}-name">{row-name}</span>
          </div>
  
          <!-- Alpha-Row-Menu -->
          <div class="web-table-alpha-menu" id="{row-id}-menu">
            <div class="web-table-alpha-divider"></div>
            <span class="web-table-alpha-menu-button" onclick="{row-menu-new}">
              <span class="web-table-alpha-menu-button-icon new"></span>
              Add Cell
            </span>
            <span class="web-table-alpha-menu-button-separator"></span>
            <span class="web-table-alpha-menu-button" onclick="{row-menu-edit}">
              <span class="web-table-alpha-menu-button-icon edit"></span>
              Edit Row Name
            </span>
            <span class="web-table-alpha-menu-button-separator"></span>
            <span class="web-table-alpha-menu-button" onclick="{row-menu-clear}">
              <span class="web-table-alpha-menu-button-icon clear"></span>
              Clear All Cells
            </span>
            <span class="web-table-alpha-menu-button-separator"></span>
            <span class="web-table-alpha-menu-button" onclick="{row-menu-delete}">
              <span class="web-table-alpha-menu-button-icon delete"></span>
              Delete Row
            </span>
            <span class="web-table-alpha-menu-button-separator"></span>
            <div class="web-table-alpha-divider"></div>
          </div>
          <div class="web-table-alpha-divider"></div>

          <!-- Alpha-Row-Children -->
          <div class="web-table-alpha-row-children" id="{row-id}-children">
  
{% end %}

{% row-content %}
{row-name}
{% end %}

{% row-footer %}
          </div>
        </div>
        <div class="web-table-alpha-row-follower"></div>
{% end %}

//CELL//////////////////////////////////////////////////////////////////////////

{% cell-header %}
                <!-- Alpha-Cell -->
                <div class="web-table-alpha-cell" id="{cell-id}">

                  <!-- Alpha-Cell-Name -->
                  <div class="web-table-alpha-cell-title" id="{cell-id}-title">
                    <span class="web-table-alpha-button" id="{cell-id}-button"></span>
                    <span class="web-table-alpha-name" id="{cell-id}-name">{cell-name}</span>
                  </div>

                  <!-- Alpha-Cell-Menu -->
                  <div class="web-table-alpha-menu" id="{cell-id}-menu">
                  <div class="web-table-alpha-divider"></div>
                    <span class="web-table-alpha-menu-button" onclick="{cell-menu-new}">
                      <span class="web-table-alpha-menu-button-icon new"></span>
                      Add Group
                    </span>
                    <span class="web-table-alpha-menu-button-separator"></span>
                    <span class="web-table-alpha-menu-button" onclick="{cell-menu-edit}">
                      <span class="web-table-alpha-menu-button-icon edit"></span>
                      Edit Cell Name
                    </span>
                    <span class="web-table-alpha-menu-button-separator"></span>
                    <span class="web-table-alpha-menu-button" onclick="{cell-menu-clear}">
                      <span class="web-table-alpha-menu-button-icon clear"></span>
                      Clear All Groups
                    </span>
                    <span class="web-table-alpha-menu-button-separator"></span>
                    <span class="web-table-alpha-menu-button" onclick="{cell-menu-delete}">
                      <span class="web-table-alpha-menu-button-icon delete"></span>
                      Delete Cell
                    </span>
                    <span class="web-table-alpha-menu-button-separator"></span>
                    <div class="web-table-alpha-divider"></div>
                  </div>

                  <!-- Alpha-Cell-Children -->
                  <div class="web-table-alpha-cell-children" id="{cell-id}-children">

{% end %}

{% cell-content %}
{cell-name}
{% end %}

{% cell-footer %}
                  </div>
                </div>
                <div class="web-table-alpha-cell-separator"></div>
{% end %}

//GROUP/////////////////////////////////////////////////////////////////////////

{% group-header %}
                    <!-- Alpha-Group -->
                    <div class="web-table-alpha-group" id="{group-id}">

                      <!-- Alpha-Group-Name -->
                      <div class="web-table-alpha-divider"></div>
                      <div class="web-table-alpha-group-title" id="{group-id}-title">
                        <span class="web-table-alpha-button" id="{group-id}-button"></span>
                        <span class="web-table-alpha-name" id="{group-id}-name">{group-name}</span>
                      </div>

                      <!-- Alpha-Group-Menu -->
                      <div class="web-table-alpha-menu" id="{group-id}-menu">
                        <div class="web-table-alpha-divider"></div>
                        <span class="web-table-alpha-menu-button" onclick="{group-menu-new}">
                          <span class="web-table-alpha-menu-button-icon new"></span>
                          Add Item
                        </span>
                        <span class="web-table-alpha-menu-button-separator"></span>
                        <span class="web-table-alpha-menu-button" onclick="{group-menu-edit}">
                          <span class="web-table-alpha-menu-button-icon edit"></span>
                          Edit Group Name
                        </span>
                        <span class="web-table-alpha-menu-button-separator"></span>
                        <span class="web-table-alpha-menu-button" onclick="{group-menu-clear}">
                          <span class="web-table-alpha-menu-button-icon clear"></span>
                          Clear All Items
                        </span>
                        <span class="web-table-alpha-menu-button-separator"></span>
                        <span class="web-table-alpha-menu-button" onclick="{group-menu-delete}">
                          <span class="web-table-alpha-menu-button-icon delete"></span>
                          Delete Group
                        </span>
                        <span class="web-table-alpha-menu-button-separator"></span>
                        <div class="web-table-alpha-divider"></div>
                      </div>

                      <!-- Alpha-Group-Children -->
                      <div class="web-table-alpha-group-children" id="{group-id}-children">

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
                        <!-- Alpha-Item -->
                        <div class="web-table-alpha-item" id="{item-id}">

                          <!-- Alpha-Item-Name -->
                          <div class="web-table-alpha-divider"></div>
                          <div class="web-table-alpha-item-content" id="{item-id}-content">
                            <span class="web-table-alpha-button" id="{item-id}-button"></span>
                            <span class="web-table-alpha-item-text" id="{item-id}-text">{item-text}</span>
                          </div>

                          <!-- Alpha-Item-Menu -->
                          <div class="web-table-alpha-menu" id="{item-id}-menu">
                            <div class="web-table-alpha-divider"></div>
                            <span class="web-table-alpha-menu-button" onclick="{item-menu-edit}">
                              <span class="web-table-alpha-menu-button-icon edit"></span>
                              Edit Item
                            </span>
                            <span class="web-table-alpha-menu-button-separator"></span>
                            <span class="web-table-alpha-menu-button" onclick="{item-menu-delete}">
                              <span class="web-table-alpha-menu-button-icon delete"></span>
                              Delete Item
                            </span>
                            <span class="web-table-alpha-menu-button-separator"></span>
                            <div class="web-table-alpha-divider"></div>
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