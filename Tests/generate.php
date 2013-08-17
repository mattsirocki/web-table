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
 * @version    SVN: $Id: generate.php 112 2013-03-10 21:06:02Z ll77ll $
 * @since      File available since Initial Release.
 * @filesource
 */

/*
 * $LastChangedBy: ll77ll $
 * $LastChangedDate: 2013-03-10 17:06:02 -0400 (Sun, 10 Mar 2013) $
 */

/*
 * Specify Namespace
 */
namespace Tests;

/*
 * Specify Usages
 */
use Web\Table;
use Web\Table\Template;

/*
 * Required Files
 */
require_once '../Web/Table/Autoloader.php';

/**
 * Make a Test Table
 */
function make($name, $template, $rows, $cells, $groups, $items, $checkable = false)
{
    $table = new Table($name, $template);

    for ($i = 0; $i < $rows; $i++)
    {
        $row = $table->appendRow("Row #$i");
        for ($j = 0; $j < $cells; $j++)
        {
            $cell = $row->appendCell("Cell #$i-$j");
            for ($k = 0; $k < $groups; $k++)
            {
                $group = $cell->appendGroup("Group #$i-$j-$k");
                for ($l = 0; $l < $items; $l++)
                {
                    $item = $group->appendItem("Item #$i-$j-$k-$l", '', $checkable);
                }
            }
        }
    }

    $table->save();

    return $table;
}

try
{
    /*
     * Print Diagnostics
     */
    echo 'Currently running as: ';
    passthru("whoami");

    // Generate Empty
    $table = make('empty', 'Default', 0, 0, 0, 0);
    // Generate One Row
    $table = make('one-row', 'Default', 1, 0, 0, 0);
    // Generate One Cell
    $table = make('one-cell', 'Default', 1, 1, 0, 0);
    // Generate One Group
    $table = make('one-group', 'Default', 1, 1, 1, 0);
    // Generate One Item
    $table = make('one-item', 'Default', 1, 1, 1, 1);
    // Generate One Checkable Item
    $table = make('one-checkable-item', 'Default', 1, 1, 1, 1, true);
    // Generate Two Rows
    $table = make('two-rows', 'Default', 2, 0, 0, 0);
    // Generate Four Cells
    $table = make('four-cells', 'Default', 2, 2, 0, 0);
    // Generate Eight Groups
    $table = make('eight-groups', 'Default', 2, 2, 2, 0);
    // Generate Sixteen Items
    $table = make('sixteen-items', 'Default', 2, 2, 2, 2);
    // Generate Seven by Seven
    $table = make('7x7', 'Default', 7, 7, 0, 0);
    // Generate Seven by Seven by Seven by Seven
    $table = make('7x7x7x7', 'Default', 7, 7, 7, 7);
}
catch (\Exception $e)
{
    echo $e->getMessage();
}
?>