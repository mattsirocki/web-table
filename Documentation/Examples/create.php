<?php

require_once '../../Source/Web/Table/Autoloader.php';

use Web\Table\Table;

$name     = isset($_GET['name'])     ? $_GET['name']     : null;
$template = isset($_GET['template']) ? $_GET['template'] : 'Default';

if ($name === null)
    header('Location: table.php');

$table = new Table($name, $template);
$table->save();

header(sprintf('Location: table.php?name=%s', $name));