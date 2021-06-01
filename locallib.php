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
 * Local functions for plugin.
 *
 * @package   local_userbackupdelete
 * @author    Michelle Melton <meltonml@appstate.edu>
 * @copyright (c) 2021 Appalachian State Universtiy, Boone, NC
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function notify_user($userfiles) {
    global $DB;

    $filelist = '<ul>';
    foreach ($userfiles as $userfile) {
        $filelist .= '<li>' . $userfile->filename . '</li>';
    }
    $filelist .= '</ul>';

    $nextruntime = $DB->get_field('task_scheduled', 'nextruntime', array('classname' => '\local_userbackupdelete\task\delete_files'));
    $deletedate = date('m-d-Y H:i', $nextruntime);

    $a = new \stdClass();
    $a->deletedate = $deletedate;
    $a->filelist = $filelist;

    $messagesubject = get_string('messagesubject', 'local_userbackupdelete');
    $messagebody = get_string('messagebody', 'local_userbackupdelete', $a);

    $message = new \core\message\message();
    $message->component = 'local_userbackupdelete';
    $message->name = 'userbackupdeletemessage';
    $message->userfrom = core_user::get_noreply_user();
    $firstkey = array_key_first($userfiles);
    $message->userto = $userfiles[$firstkey]->userid;
    $message->subject = $messagesubject;
    $message->fullmessage = html_to_text($messagebody);
    $message->fullmessageformat = FORMAT_HTML;
    $message->fullmessagehtml = $messagebody;
    $message->notification = 1;

    $messageid = message_send($message);
}