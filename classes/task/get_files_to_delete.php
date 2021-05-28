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

namespace local_userbackupdelete\task;

defined('MOODLE_INTERNAL') || die();

/**
 * Scheduled task for plugin to get user backup files to delete.
 *
 * @package   local_userbackupdelete
 * @author    Michelle Melton <meltonml@appstate.edu>
 * @copyright (c) 2021 Appalachian State Universtiy, Boone, NC
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class get_files_to_delete extends \core\task\scheduled_task {
    /**
     * Get name of scheduled task.
     * {@inheritDoc}
     * @see \core\task\scheduled_task::get_name()
     */
    public function get_name() {
        return get_string('getfiles', 'local_userbackupdelete');
    }
    
    /**
     * Execute scheduled task.
     * {@inheritDoc}
     * @see \core\task\task_base::execute()
     */
    public function execute() {
        global $DB;
        
        $deletetime = time() - (30 * DAYSECS);
        
        $sql = "SELECT f.id as fileid, u.id as userid, f.filename as filename
                FROM {files} f
                JOIN {user} u
                ON f.userid = u.id
                WHERE f.component = 'user' 
                AND f.filearea = 'backup' 
                AND f.filename != '.' 
                AND u.username LIKE '%@appstate.edu' 
                AND f.filename LIKE 'backup-moodle2-%'
                AND f.timemodified < {$deletetime}";
        
        // fileid not coming in?
        // don't duplicate if already in there
        $filestodelete = $DB->get_records_sql($sql);
        
        foreach ($filestodelete as $file) {
            $dataobject = new \stdClass();
            $dataobject->fileid = $file->fileid;
            $dataobject->userid = $file->userid;
            $dataobject->filename = $file->filename;
            $DB->insert_record('local_userbackupdelete', $dataobject);
        }
    }
}