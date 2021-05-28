The User backup delete plugin provides for the automated notification and deletion of user backup files.

# Installation instructions
Install the plugin according to the [MoodleDocs](https://docs.moodle.org/en/Installing_plugins) as a directory named covidcohort in the local directory.

# Usage instructions
The scheduled tasks (scheduled to run once a month by default) will handle marking user backup files older than 30 days, sending a notification to users, and then deleting marked backup files 7 days after marking and notification.

Note that if you change the run configuration for the scheduled tasks, it will impact the time between notification of users and file deletion.