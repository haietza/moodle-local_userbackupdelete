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
 * Scheduled task for plugin to delete scheduled user backup files.
 *
 * @package   local_userbackupdelete
 * @author    Michelle Melton <meltonml@appstate.edu>
 * @copyright (c) 2021 Appalachian State Universtiy, Boone, NC
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class delete_files extends \core\task\scheduled_task {
    /**
     * Get name of scheduled task.
     * {@inheritDoc}
     * @see \core\task\scheduled_task::get_name()
     */
    public function get_name() {
        return get_string('deletefiles', 'local_userbackupdelete');
    }

    /**
     * Execute scheduled task.
     * {@inheritDoc}
     * @see \core\task\task_base::execute()
     */
    public function execute() {
        global $DB;

        $files = $DB->get_records('local_userbackupdelete');

        $fs = get_file_storage();

        foreach ($files as $file) {
            $filerecord = $fs->get_file_by_hash($file->pathnamehash);
            if ($filerecord) {
                mtrace('Deleting  filename ' . $filerecord->get_filename() . ' for userid ' . $filerecord->get_userid());
                $filerecord->delete();
            } else {
                mtrace('File ' . $file->pathnamehash . ' for userid ' . $file->get_userid()
                    . ' does not exist; deleting userbackupdelete record.');
            }
            $DB->delete_records('local_userbackupdelete', array('pathnamehash' => $file->pathnamehash));
        }
    }
}