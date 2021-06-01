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
require_once($CFG->dirroot . '/local/userbackupdelete/locallib.php');

/**
 * Scheduled task for plugin to notify users of backup files being deleted.
 *
 * @package   local_userbackupdelete
 * @author    Michelle Melton <meltonml@appstate.edu>
 * @copyright (c) 2021 Appalachian State Universtiy, Boone, NC
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class notify_users extends \core\task\scheduled_task {
    /**
     * Get name of scheduled task.
     * {@inheritDoc}
     * @see \core\task\scheduled_task::get_name()
     */
    public function get_name() {
        return get_string('notifyusers', 'local_userbackupdelete');
    }

    /**
     * Execute scheduled task.
     * {@inheritDoc}
     * @see \core\task\task_base::execute()
     */
    public function execute() {
        global $DB;

        $sql = "SELECT DISTINCT userid
                FROM {local_userbackupdelete}";

        $users = $DB->get_records_sql($sql);

        foreach ($users as $user) {
            $userfiles = $DB->get_records('local_userbackupdelete', array('userid' => $user->userid));
            notify_user($userfiles);
        }
    }
}