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
 * @version    SVN: $Id: table.php 114 2013-04-04 23:53:18Z ll77ll $
 * @since      File available since Initial Release.
 * @filesource
 */

/*
 * $LastChangedBy: ll77ll $
 * $LastChangedDate: 2013-04-04 19:53:18 -0400 (Thu, 04 Apr 2013) $
 */

$table = isset($_GET['name']) ? $_GET['name'] : 'empty';

echo <<<HTML
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <!-- Document Title -->
    <title>Web Table</title>
    <!-- Meta Headers -->
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <!-- JavaScript Functions/Frameworks -->
    <script src="../../Web/jquery-1.7.2.js" type="text/javascript"></script>
    <script src="../../Web/web-table.js" type="text/javascript"></script>
    <!-- Load Web Table -->
    <script type="text/javascript">
      WebTable.initialize('../..');
      WebTable.load('$table', '#table', false);
    </script>
  </head>
  <body style="border: 0; margin: 0; padding: 0;">
      <div id="table" style="height: 100%;" />
  </body>
</html>
HTML;

?>