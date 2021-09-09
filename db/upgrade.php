<?php

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
