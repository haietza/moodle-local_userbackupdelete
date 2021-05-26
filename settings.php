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

defined('MOODLE_INTERNAL') || die;

// Ensure the configurations for this site are set.
if ($hassiteconfig) {
    //$settingscategory = new admin_category('covidcohort', get_string('pluginname', 'local_covidcohort'));
    //$ADMIN->add('localplugins', $settingscategory);

    $settings = new admin_settingpage('local_userbackupdelete_settings', get_string('pluginname', 'local_userbackupdelete'));
    $settings->add(new admin_setting_configduration('local_userbackupdelete/keepfiles', get_string('keepfiles', 'local_userbackupdelete'), get_string('keepfiles_desc', 'local_userbackupdelete'), 30 * DAYSECS));
    $settings->add(new admin_setting_configduration('local_userbackupdelete/notify', get_string('notify', 'local_userbackupdelete'), get_string('notify_desc', 'local_userbackupdelete'), 7 * DAYSECS));
    
    $ADMIN->add('localplugins', $settings);
}