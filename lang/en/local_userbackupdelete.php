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
 * Plugin settings.
 *
 * @package   local_userbackupdelete
 * @author    Michelle Melton <meltonml@appstate.edu>
 * @copyright (c) 2021 Appalachian State Universtiy, Boone, NC
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'User backup delete';
$string['getfiles'] = 'Get user backup files to delete';
$string['deletefiles'] = 'Delete user backup files';
$string['notifyusers'] = 'Notify users of backup files to be deleted';
$string['messagesubject'] = 'Files in {$a->sitename} user private backup area to be deleted';
$string['messagebody'] = '<p>The following files in your {$a->sitename} user private backup area are over 30 days old. They will be permanently deleted {$a->deletedate}.</p> {$a->filelist} <p>To learn more about user private backup files and how to access and download them, view <a href="https://confluence.appstate.edu/x/aIYxBw">Accessing User Backups</a> in the ATKB.</p>';
$string['messageprovider:userbackupdeletemessage'] = 'User backup delete notifications';