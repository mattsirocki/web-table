web-table
=========

Web Table is a simple PHP application which allows you to create dynamic tables of information. These tables are templatable and can be edited via on-the-fly AJAX calls. They are saved to disk as `*.tbl` files using JSON. These data files can easily be read into arrays via `json_decode()` in PHP. They also can be read into complex Table objects via the `Table::load()` method.

Getting Started
---------------

Putting a web table on any page is easy. To do so, you must include one JavaScript file and write two lines of JavaScript code. Put the following code in your `<head>` tag:

	<head>
	    <script src="path-to-web-table/Web/web-table.js" type="text/javascript"></script>
	</head>

Version 1.7.2 of jQuery is bundled with web-table for your convenience. You can, however, use any later version, provided the jQuery team doesn't break backwards compatibility. If you don't already have jQuery sourced on your page, you should include it before `web-table.js` is included.

	<head>
	    <script src="path-to-web-table/Web/jquery-1.7.2.js" type="text/javascript"></script>
	    <script src="path-to-web-table/Web/web-table.js" type="text/javascript"></script>
	</head>

Finally, you just need to initialize the web table system and load the table.

	<script>
        WebTable.initialize('path-to-web-table);
		WebTable.load('my-table');
	</script>

By default, the table is loaded into the `<body>` tag. You can change this by specifying a second argument to the `load()` function.

	<script>
        WebTable.initialize('path-to-web-table);
		WebTable.load('my-table', '#my-table-container');
	</script>

The second argument accepts _any_ jQuery selector string. Here, we've selected an element with an `id` equal to `'my-table-container'`. It is also possible to load more than one table on a single page. Each table, however, must be placed into a different element. When a table is loaded, it removes all children elements in the target.


	<!-- Example of Loading Multiple Tables -->
	<script>
        WebTable.initialize('path-to-web-table);
		WebTable.load('my-table-0', '#my-table-container-0');
		WebTable.load('my-table-1', '#my-table-container-1');
	</script>

The load function also can take two additional, optional arguments: `cache` and `path`. The first, `cache`, is a boolean flag which caches Tables in the current SESSION data. This feature can be enabled if disk accesses on every reload have too much latency. By default, `cache` is false.

	<!-- Examples of `cache Option -->
	<script>
        WebTable.initialize('path-to-web-table);
		WebTable.load('my-table-0', '#my-table-container-0', true);  // Enable Caching
		WebTable.load('my-table-1', '#my-table-container-1', false); // Disable Caching
	</script>


The final option, `path`, allows for an alternate storage path to be specified for the *.tbl file. This file is a serialized--it's actually just JSON--version of the Table which acts as the database for the table. By default, `*.tbl` files are stored in `web-table/Data/Tables`. `path` should be a path to the directory, not the `*.tbl` file.

	<!-- Examples of `path` Option -->
	<script>
        WebTable.initialize('path-to-web-table);
		WebTable.load('my-alternate-table', '#my-table', false, '/path/to/alternate/data/directory');
	</script>

**TODO** Ideally, I should be able to do away with the `initialize()` function by doing some self-inspection in the `web-table.js` file, since this file should live in the web-table directory.

Examples
--------

Several example tables and a sample page are provided. Simply save the project in a directory on your web server and then go to:

	http://your-web-server/path-to-web-table/Documentation/Examples/table.php

This example page loads the sample tables which are packaged with the base web-table project. These tables are stored in the `web-table/Data/Tables` directory.

**NOTE** You may need to adjust the permissions of the `Tables` directory so that it can be written by the PHP executable.