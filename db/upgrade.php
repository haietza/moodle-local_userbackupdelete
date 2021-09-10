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
 * This file keeps track of upgrades to the userbackupdelete plugin.
 *
 * @package   local_userbackupdelete
 * @author    Michelle Melton <meltonml@appstate.edu>
 * @copyright (c) 2021 Appalachian State Universtiy, Boone, NC
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Execute upgrade from given old version.
 *
 * @param int $oldversion
 * @return boolean
 */
function xmldb_local_userbackupdelete_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2021090900) {
        // Start userbackupdelete table modifications.
        $table = new xmldb_table('local_userbackupdelete');

        // Get pathnamehash for existing records.
        $userbackups = $DB->get_records('local_userbackupdelete');
        foreach ($userbackups as $userbackup) {
            $pathnamehash = $DB->get_field('files', 'pathnamehash', array('id' => $userbackup->fileid));
            $userbackup->pathnamehash = $pathnamehash;
            unset($userbackup->fileid);
        }

        // Drop fileid index.
        $index = new xmldb_index('fileid', XMLDB_INDEX_UNIQUE, ['fileid']);
        if ($dbman->index_exists($table, $index)) {
            $dbman->drop_index($table, $index);
        }

        // Define field fileid to be dropped from userbackupdelete.
        $field = new xmldb_field('fileid');

        // Conditionally launch drop field fileid.
        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }

        // Define field pathnamehash to be added to zoom.
        $field = new xmldb_field('pathnamehash', XMLDB_TYPE_CHAR, '40', null, XMLDB_NOTNULL, null, null, 'id');

        // Conditionally launch add field pathnamehash.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define pathnamehash index.
        $index = new xmldb_index('pathnamehash', XMLDB_INDEX_UNIQUE, ['pathnamehash']);

        // Conditionally launch add index pathnamehash.
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        // Update existing records.
        foreach ($userbackups as $userbackup) {
            $DB->update_record('local_userbackupdelete', $userbackup);
        }

        upgrade_plugin_savepoint(true, 2021090900, 'local', 'userbackupdelete');
    }

    return true;
}