<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Update Nova from 2.6.3 to 2.7.0
 */
$system_info = null;
$add_tables = null;
$drop_tables = null;
$rename_tables = null;
$add_column = null;
$modify_column = null;
$drop_column = null;

/**
 * Version info for the database
 */
$system_info = [
    'sys_last_update' => now(),
    'sys_version_major' => 2,
    'sys_version_minor' => 7,
    'sys_version_update' => 0,
];

/*
|---------------------------------------------------------------
| TABLES TO DROP
|
| $drop_tables = array('table_name');
|---------------------------------------------------------------
*/

if ($drop_tables !== null) {
    foreach ($drop_tables as $tableToDrop) {
        if ($this->db->table_exists($tableToDrop)) {
            $this->dbforge->drop_table($tableToDrop);
        }
    }
}

/*
|---------------------------------------------------------------
| TABLES TO RENAME
|
| $rename_tables = array('old_table_name' => 'new_table_name');
|---------------------------------------------------------------
*/

$rename_tables = [
    'departments_'.GENRE => 'departments',
    'positions_'.GENRE => 'positions',
    'ranks_'.GENRE => 'ranks',
    'sessions' => 'sessions_ci2',
];

if ($rename_tables !== null) {
    foreach ($rename_tables as $oldTableName => $newTableName) {
        if ($this->db->table_exists($oldTableName)) {
            $this->dbforge->rename_table($oldTableName, $newTableName);
        }
    }
}

/*
|---------------------------------------------------------------
| TABLES TO ADD
|
| $add_tables = array(
|	'table_name' => array(
|		'id' => 'table_id',
|		'fields' => 'fields_table_name')
| );
|
| $fields_table_name = array(
|	'table_id' => array(
|		'type' => 'INT',
|		'constraint' => 6,
|		'auto_increment' => TRUE),
|	'table_field_1' => array(
|		'type' => 'VARCHAR',
|		'constraint' => 255,
|		'default' => ''),
|	'table_field_2' => array(
|		'type' => 'INT',
|		'constraint' => 4,
|		'default' => '99')
| );
|---------------------------------------------------------------
*/


$add_tables = [
    'sessions' => [
        'id' => 'id',
        'fields' => 'fields_sessions',
    ],
];

$fields_sessions = [
    'id' => [
        'type' => 'VARCHAR',
        'constraint' => 128
    ],
    'ip_address' => [
        'type' => 'VARCHAR',
        'constraint' => 45
    ],
    'timestamp' => [
        'type' => 'INT',
        'constraint' => 10,
        'unsigned' => true,
        'default' => 0
    ],
    'data' => [
        'type' => 'BLOB'
    ],
];

if ($add_tables !== null) {
    foreach ($add_tables as $tableName => $tableData) {
        if (! $this->db->table_exists($tableName)) {
            $this->dbforge->add_field(${$tableData['fields']});
            $this->dbforge->add_key($tableData['id'], true);
            $this->dbforge->create_table($tableName, true);
        }
    }
}


/*
|---------------------------------------------------------------
| COLUMNS TO ADD
|
| $add_column = array(
|	'table_name' => array(
|		'field_name_1' => array('type' => 'TEXT'),
|		'field_name_2' => array(
|			'type' => 'VARCHAR',
|			'constraint' => 100)
|	)
| );
|---------------------------------------------------------------
*/

$wordsColumn = [
    'type' => 'BIGINT',
    'constraint' => 8,
    'default' => 0,
];

$add_column = [
    'personallogs' => [
        'log_words' => $wordsColumn,
    ],
    'posts' => [
        'post_words' => $wordsColumn,
    ],
];

if ($add_column !== null) {
    foreach ($add_column as $tableName => $columns) {
        foreach ($columns as $columnName => $columnData) {
            if (! $this->db->field_exists($columnName, $tableName)) {
                $this->dbforge->add_column($tableName, $columns);
            }
        }
    }
}

/*
|---------------------------------------------------------------
| COLUMNS TO MODIFY
|
| $modify_column = array(
|	'table_name' => array(
|		'old_field_name' => array(
|			'name' => 'new_field_name',
|			'type' => 'TEXT')
|	)
| );
|---------------------------------------------------------------
*/

if ($modify_column !== null) {
    foreach ($modify_column as $key => $value) {
        $this->dbforge->modify_column($key, $value);
    }
}

/*
|---------------------------------------------------------------
| COLUMNS TO DROP
|
| $drop_column = array(
|	'table_name' => array('field_name')
| );
|---------------------------------------------------------------
*/

if ($drop_column !== null) {
    foreach ($drop_column as $tableName => $columns) {
        $this->dbforge->drop_column($tableName, $columns[0]);
    }
}

$posts = $this->db->get('posts');

if ($posts->num_rows() > 0) {
    $postsData = [];

    foreach ($posts->result() as $post) {
        if ((int) $post->post_words === 0) {
            $postsData[] = [
                'post_id' => $post->post_id,
                'post_words' => str_word_count($post->post_content),
            ];
        }
    }

    if (count($postsData) > 0) {
        $this->db->update_batch('posts', $postsData, 'post_id');
    }
}

$logs = $this->db->get('personallogs');

if ($logs->num_rows() > 0) {
    $logsData = [];

    foreach ($logs->result() as $log) {
        if ((int) $log->log_words === 0) {
            $logsData[] = [
                'log_id' => $log->log_id,
                'log_words' => str_word_count($log->log_content),
            ];
        }
    }

    if (count($logsData) > 0) {
        $this->db->update_batch('personallogs', $logsData, 'log_id');
    }
}
