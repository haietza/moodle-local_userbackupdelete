<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Scheduled tasks for plugin.
 *
 * @package   local_userbackupdelete
 * @author    Michelle Melton <meltonml@appstate.edu>
 * @copyright (c) 2021 Appalachian State Universtiy, Boone, NC
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$tasks = array(
    array(
        'classname' => 'local_userbackupdelete\task\get_files_to_delete',
        'blocking' => 0,
        'minute' => '5',
        'hour' => '3',
        'day' => '1',
        'dayofweek' => '*',
        'month' => '*'
    ),
    array(
        'classname' => 'local_userbackupdelete\task\notify_users',
        'blocking' => 0,
        'minute' => '5',
        'hour' => '4',
        'day' => '1',
        'dayofweek' => '*',
        'month' => '*'
    ),
    array(
        'classname' => 'local_userbackupdelete\task\delete_files',
        'blocking' => 0,
        'minute' => '5',
        'hour' => '3',
        'day' => '8',
        'dayofweek' => '*',
        'month' => '*'
    )
);