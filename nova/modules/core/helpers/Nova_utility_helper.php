<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter Utility Helpers
 *
 * @package		Nova
 * @category	Helper
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

// ------------------------------------------------------------------------

/**
 * File Size
 *
 * Determine the file size of a number (in bytes) passed in and returns it
 * as the number of megabytes
 *
 * @access	public
 * @param	integer
 * @return	string
 */
if (! function_exists('file_size')) {
    function file_size($data = '')
    {
        if (empty($data)) {
            return false;
        } else {
            return round(($data / 1024000), 3);
        }
    }
}

// ------------------------------------------------------------------------

/**
 * Check Memory vs. Database
 *
 * Check the memory consumption of the system vs the server memory limit
 * for running the database backup
 *
 * @access	public
 * @param	integer
 * @param	integer
 * @return	string
 */
if (! function_exists('check_memory')) {
    function check_memory($data = '', $usage = 4)
    {
        /* get the memory limit and pop the M off the end */
        $mem = ini_get('memory_limit');
        $mem = str_replace('M', '', $mem);

        /* add what nova uses to the database size */
        $sys = $data + $usage;

        if ($sys >= $mem) { /* if the potential memory consumption is greater than the limit, fail */
            return false;
        } else {
            return true;
        }
    }
}

// ------------------------------------------------------------------------

/**
 * Who's Online
 *
 * Displays a list of who is currently online
 *
 * @access	public
 * @return	string
 */
if (! function_exists('whos_online')) {
    function whos_online()
    {
        $ci =& get_instance();

        if ($ci->config->item('sess_driver') !== 'database') {
            return sprintf('<span class="red">This feature requires using the database session driver. You are currently using the %s driver. Please follow the directions in the Nova 2.7 update guide to update your configuration and see users who are online now.</span>', $ci->config->item('sess_driver'));
        }

        $ci->load->model('users_model', 'user');
        $ci->load->model('characters_model', 'char');

        $timespan = $ci->settings->get_setting('online_timespan');

        $online = $ci->user->get_online_users($timespan);

        if (count($online) > 0) {
            foreach ($online as $value) {
                $char = $ci->user->get_main_character($value);
                $array[$value] = $ci->char->get_character_name($char, false, false, true);
            }

            $string = implode(', ', $array);

            return $string;
        }

        return 'No users online';
    }
}

// ------------------------------------------------------------------------

/**
 * Parse Name
 *
 * Takes a list of arguments and parses them to make sure there are no blanks
 *
 * @access	public
 * @param	array
 * @return	string
 */
if (! function_exists('parse_name')) {
    function parse_name($segments = array())
    {
        foreach ($segments as $key => $value) {
            if (empty($value)) {
                unset($segments[$key]);
            }
        }

        $string = implode(' ', $segments);

        return $string;
    }
}

// ------------------------------------------------------------------------

/**
 * Parse Dynamic Message
 *
 * Parse a message with variables in it
 *
 * @access	public
 * @param	string
 * @param	array
 * @return	string
 */
if (! function_exists('parse_dynamic_message')) {
    function parse_dynamic_message($message = '', $args = array())
    {
        $result = $message;

        foreach ($args as $key => $value) {
            if (strpos($result, '#'. $key .'#') !== false) {
                $result = str_replace('#'. $key .'#', $value, $result);
            }
        }

        return $result;
    }
}

// ------------------------------------------------------------------------

/**
 * Backup Database
 *
 * Back up the SQL database (only works with MySQL)
 *
 * @access	public
 * @param	string
 * @param	string (download/save)
 * @param	string
 * @return	boolean (true/false)
 */
if (! function_exists('backup_database')) {
    function backup_database($prefix = '', $action = 'download', $name = 'sms_backup')
    {
        /* create an instance */
        $ci =& get_instance();

        /* load the utility class */
        $ci->load->dbutil();

        /* get an array of the tables */
        $fields = $ci->db->list_tables();

        /* get the length of the prefix */
        $length = strlen($prefix);

        /* go through all the tables to find out if its part of the system or not */
        foreach ($fields as $key => $value) {
            if (substr($value, 0, $length) != $prefix) {
                unset($fields[$key]);
            }
        }

        if (count($fields) > 0) {
            /* preferences for the backup */
            $prefs = array(
                'tables'		=> $fields,
                'format'		=> 'zip',
                'filename'		=> $name .'.sql'
            );

            /* backup the database and assign it to a variable */
            $backup =& $ci->dbutil->backup($prefs);

            if ($action == 'download') {
                /* load the download helper and send the file to the desktop */
                $ci->load->helper('download');
                force_download($name .'.zip', $backup);
            } elseif ($action == 'save') {
                /* load the file helper and write the file to the server */
                $ci->load->helper('file');
                write_file(APPPATH .'assets/backups/'. $name .'.zip', $backup);
            }

            return true;
        }

        return false;
    }
}

// ------------------------------------------------------------------------

/**
 * SMS Position Dictionary
 */
if (! function_exists('sms_position_translation')) {
    function sms_position_translation($id = '')
    {
        $positions = array(
            1	=> 1,
            2	=> 2,
            3	=> 3,
            4	=> 4,
            5	=> 5,
            6	=> 7,
            7	=> 8,
            8	=> 9,
            9	=> 12,
            10	=> 13,
            11	=> 14,
            12	=> 15,
            13	=> 16,
            14	=> 17,
            15	=> 18,
            16	=> 19,
            17	=> 20,
            18	=> 21,
            19	=> 22,
            20	=> 23,
            21	=> 24,
            22	=> 25,
            23	=> 26,
            24	=> 27,
            25	=> 29,
            26	=> 30,
            27	=> 31,
            28	=> 32,
            29	=> 33,
            30	=> 34,
            31	=> 35,
            32	=> 36,
            33	=> 37,
            34	=> 28,
            35	=> 38,
            36	=> 39,
            37	=> 40,
            38	=> 42,
            39	=> 43,
            40	=> 44,
            41	=> 45,
            42	=> 46,
            43	=> 47,
            44	=> 48,
            45	=> 49,
            46	=> 51,
            47	=> 54,
            48	=> 55,
            49	=> 56,
            50	=> 57,
            51	=> 58,
            52	=> 59,
            53	=> 60,
            54	=> 61,
            55	=> 62,
            56	=> 63,
            57	=> 64,
            58	=> 65,
            59	=> 68,
            60	=> 69,
            61	=> 70,
            62	=> 71,
            63	=> 72,
            64	=> 73,
            65	=> 74,
            66	=> 76,
            67	=> 78
        );

        if (!array_key_exists($id, $positions)) {
            return 0;
        }

        return $positions[$id];
    }
}

// ------------------------------------------------------------------------

/**
 * Server Verification
 *
 * Verify the server can run Nova
 *
 * @access	public
 * @return	array
 */
if (! function_exists('verify_server')) {
    function verify_server()
    {
        $ci =& get_instance();
        $ci->load->module('core', 'nova', MODPATH);
        $ci->nova->lang('install');

        $verify = [
            'failures' => 0,
            'warnings' => 0,
        ];

        /**
         * PHP
         */
        $php['required'] = '7.4';
        $php['actual'] = phpversion();
        $php['passes'] = version_compare($php['actual'], $php['required'], '>=');
        $php['message'] = $php['passes'] ? lang('verify_success_icon') : lang('verify_failure_icon');
        $verify['failures'] += $php['passes'] ? 0 : 1;

        /**
         * Database driver
         */
        $dbDriver['required'] = 'mysqli';
        $dbDriver['actual'] = $ci->db->platform();
        $dbDriver['passes'] = $dbDriver['actual'] == $dbDriver['required'];
        $dbDriver['message'] = $dbDriver['passes'] ? lang('verify_success_icon') : lang('verify_failure_icon');
        $verify['failures'] += $dbDriver['passes'] ? 0 : 1;

        /**
         * Database platform
         */
        $dbPlatform['required'] = ['MySQL', 'MariaDB'];
        $dbPlatform['actual'] = strpos(strtolower($ci->db->version()), 'mariadb') ? 'MariaDB' : 'MySQL';
        $dbPlatform['passes'] = in_array($dbPlatform['actual'], $dbPlatform['required']);
        $dbPlatform['message'] = $dbPlatform['passes'] ? lang('verify_success_icon') : lang('verify_failure_icon');
        $verify['failures'] += $dbPlatform['passes'] ? 0 : 1;

        /**
         * Database version
         */
        if ($dbPlatform['actual'] === 'MySQL') {
            $dbVersion['required'] = '5.0';
            $dbVersion['actual'] = $ci->db->version();
        } else {
            $dbVersion['required'] = '5.0';
            $dbVersion['actual'] = strstr($ci->db->version(), '-', true);
        }

        $dbVersion['passes'] = version_compare($dbVersion['actual'], $dbVersion['required'], '>=');
        $dbVersion['message'] = $dbVersion['passes'] ? lang('verify_success_icon') : lang('verify_failure_icon');
        $verify['failures'] += $dbVersion['passes'] ? 0 : 1;

        /**
         * Register globals
         */
        $registerGlobals['required'] = lang('global_off');
        $registerGlobals['actual'] = (ini_get('register_globals') == 1) ? lang('global_on') : lang('global_off');
        $registerGlobals['passes'] = $registerGlobals['required'] == $registerGlobals['actual'];
        $registerGlobals['message'] = $registerGlobals['passes'] ? lang('verify_success_icon') : lang('verify_warning_icon');
        $verify['warnings'] += $registerGlobals['passes'] ? 0 : 1;

        /**
         * Memory limit
         */
        $memoryLimit['required'] = 8;
        $memoryLimit['actual'] = substr(ini_get('memory_limit'), 0, -1);
        $memoryLimit['passes'] = $memoryLimit['actual'] >= $memoryLimit['required'];
        $memoryLimit['message'] = $memoryLimit['passes'] ? lang('verify_success_icon') : lang('verify_warning_icon');
        $verify['warnings'] += $memoryLimit['passes'] ? 0 : 1;

        /**
         * File handling
         */
        $fileHandling['required'] = lang('global_on');
        $fileHandling['actual'] = (ini_get('allow_url_fopen') == 1) ? lang('global_on') : lang('global_off');
        $fileHandling['passes'] = $fileHandling['required'] == $fileHandling['actual'];
        $fileHandling['message'] = $fileHandling['passes'] ? lang('verify_success_icon') : lang('verify_warning_icon');
        $verify['warnings'] += $fileHandling['passes'] ? 0 : 1;

        return [
            'php' => $php,
            'dbDriver' => $dbDriver,
            'dbPlatform' => $dbPlatform,
            'dbVersion' => $dbVersion,
            'registerGlobals' => $registerGlobals,
            'memoryLimit' => $memoryLimit,
            'fileHandling' => $fileHandling,
            'verify' => $verify,
        ];
    }
}

if (! function_exists('show_server_verification_table')) {
    function show_server_verification_table($verify = null)
    {
        $ci =& get_instance();
        $ci->load->module('core', 'nova', MODPATH);
        $ci->nova->lang('install');

        [
            'php' => $php,
            'dbDriver' => $dbDriver,
            'dbPlatform' => $dbPlatform,
            'dbVersion' => $dbVersion,
            'registerGlobals' => $registerGlobals,
            'memoryLimit' => $memoryLimit,
            'fileHandling' => $fileHandling,
        ] = $verify ?? verify_server();

        $output = '<table class="table100 fontMedium zebra">';
        $output.= '<thead>';
        $output.= '<tr>';
        $output.= '<th>'.lang('verify_component').'</th>';
        $output.= '<th>'.lang('verify_required').'</th>';
        $output.= '<th>'.lang('verify_actual').'</th>';
        $output.= '<th>'.lang('verify_result').'</th>';
        $output.= '</tr>';
        $output.= '</thead>';

        $output.= '<tbody>';

        $output.= '<tr class="even:bg-gray-50">';
        $output.= '<td class="title">'.lang('verify_php').'</td>';
        $output.= '<td>'.$php['required'].'</td>';
        $output.= '<td>'.$php['actual'].'</td>';
        $output.= '<td align="center">'.$php['message'].'</td>';
        $output.= '</tr>';

        $output.= '<tr class="even:bg-gray-50">';
        $output.= '<td class="title">'.lang('verify_db_driver').'</td>';
        $output.= '<td>'.$dbDriver['required'].'</td>';
        $output.= '<td>'.$dbDriver['actual'].'</td>';
        $output.= '<td align="center">'.$dbDriver['message'].'</td>';
        $output.= '</tr>';

        $output.= '<tr class="even:bg-gray-50">';
        $output.= '<td class="title">'.lang('verify_db').'</td>';
        $output.= '<td>'.implode(' / ', $dbPlatform['required']).'</td>';
        $output.= '<td>'.$dbPlatform['actual'].'</td>';
        $output.= '<td align="center">'.$dbPlatform['message'].'</td>';
        $output.= '</tr>';

        $output.= '<tr class="even:bg-gray-50">';
        $output.= '<td class="title">'.lang('verify_db_ver').'</td>';
        $output.= '<td>'.$dbVersion['required'].'</td>';
        $output.= '<td>'.$dbVersion['actual'].'</td>';
        $output.= '<td align="center">'.$dbVersion['message'].'</td>';
        $output.= '</tr>';

        $output.= '<tr class="even:bg-gray-50">';
        $output.= '<td class="title">'.lang('verify_regglobals').'</td>';
        $output.= '<td>'.$registerGlobals['required'].'</td>';
        $output.= '<td>'.$registerGlobals['actual'].'</td>';
        $output.= '<td align="center">'.$registerGlobals['message'].'</td>';
        $output.= '</tr>';

        $output.= '<tr class="even:bg-gray-50">';
        $output.= '<td class="title">'.lang('verify_mem').'</td>';
        $output.= '<td>'.$memoryLimit['required'].'</td>';
        $output.= '<td>'.$memoryLimit['actual'].'</td>';
        $output.= '<td align="center">'.$memoryLimit['message'].'</td>';
        $output.= '</tr>';

        $output.= '<tr class="even:bg-gray-50">';
        $output.= '<td class="title">'.lang('verify_file').'</td>';
        $output.= '<td>'.$fileHandling['required'].'</td>';
        $output.= '<td>'.$fileHandling['actual'].'</td>';
        $output.= '<td align="center">'.$fileHandling['message'].'</td>';
        $output.= '</tr>';
        $output.= '</tbody>';
        $output.= '</table>';

        return $output;
    }
}

// ------------------------------------------------------------------------

/**
 * Database Forge Data Type Translation
 *
 * Translate data from a set of base items to either MySQL, MySQLi or PostgreSQL
 *
 * @access	public
 * @param	string
 * @param	string
 * @return	string
 */
if (! function_exists('dbforge_type_translation')) {
    function dbforge_type_translation($data = '', $db = '')
    {
        $types = array(
            'integer' => array(
                'mysql' 	=> 'integer',
                'mysqli'	=> 'integer',
                'postgre'	=> 'int'),
            'integer(1)' => array(
                'mysql' 	=> 'tinyint',
                'mysqli'	=> 'tinyint',
                'postgre'	=> 'smallint'),
            'integer(2)' => array(
                'mysql' 	=> 'smallint',
                'mysqli'	=> 'smallint',
                'postgre'	=> 'smallint'),
            'integer(3)' => array(
                'mysql' 	=> 'mediumint',
                'mysqli'	=> 'mediumint',
                'postgre'	=> 'int'),
            'integer(4)' => array(
                'mysql' 	=> 'int',
                'mysqli'	=> 'int',
                'postgre'	=> 'int'),
            'integer(5)' => array(
                'mysql' 	=> 'bigint',
                'mysqli'	=> 'bigint',
                'postgre'	=> 'bigint'),
            'float' => array(
                'mysql' 	=> 'double',
                'mysqli'	=> 'double',
                'postgre'	=> 'float'),
            'double' => array(
                'mysql' 	=> 'double',
                'mysqli'	=> 'double',
                'postgre'	=> 'float'),
            'decimal' => array(
                'mysql' 	=> 'decimal',
                'mysqli'	=> 'decimal',
                'postgre'	=> 'numeric'),
            'char' => array(
                'mysql' 	=> 'char',
                'mysqli'	=> 'char',
                'postgre'	=> 'char'),
            'varchar' => array(
                'mysql' 	=> 'varchar',
                'mysqli'	=> 'varchar',
                'postgre'	=> 'varchar'),
            'string' => array(
                'mysql' 	=> 'varchar',
                'mysqli'	=> 'varchar',
                'postgre'	=> 'varchar'),
            'array' => array(
                'mysql' 	=> 'text',
                'mysqli'	=> 'text',
                'postgre'	=> 'text'),
            'object' => array(
                'mysql' 	=> 'text',
                'mysqli'	=> 'text',
                'postgre'	=> 'text'),
            'blob' => array(
                'mysql' 	=> 'longblob',
                'mysqli'	=> 'longblob',
                'postgre'	=> 'bytea'),
            'blob(255)' => array(
                'mysql' 	=> 'tinyblob',
                'mysqli'	=> 'tinyblob',
                'postgre'	=> 'bytea'),
            'blob(65532)' => array(
                'mysql' 	=> 'blob',
                'mysqli'	=> 'blob',
                'postgre'	=> 'bytea'),
            'blob(16777215)' => array(
                'mysql' 	=> 'mediumblob',
                'mysqli'	=> 'mediumblob',
                'postgre'	=> 'bytea'),
            'clob' => array(
                'mysql' 	=> 'longtext',
                'mysqli'	=> 'longtext',
                'postgre'	=> 'text'),
            'clob(255)' => array(
                'mysql' 	=> 'tinytext',
                'mysqli'	=> 'tinytext',
                'postgre'	=> 'text'),
            'clob(65532)' => array(
                'mysql' 	=> 'text',
                'mysqli'	=> 'text',
                'postgre'	=> 'text'),
            'clob(16777215)' => array(
                'mysql' 	=> 'mediumtext',
                'mysqli'	=> 'mediumtext',
                'postgre'	=> 'text'),
            'timestamp' => array(
                'mysql' 	=> 'datetime',
                'mysqli'	=> 'datetime',
                'postgre'	=> 'timestamp'),
            'time' => array(
                'mysql' 	=> 'time',
                'mysqli'	=> 'time',
                'postgre'	=> 'time'),
            'date' => array(
                'mysql' 	=> 'date',
                'mysqli'	=> 'date',
                'postgre'	=> 'date'),
            'gzip' => array(
                'mysql' 	=> 'text',
                'mysqli'	=> 'text',
                'postgre'	=> 'text'),
            'boolean' => array(
                'mysql' 	=> 'tinyint',
                'mysqli'	=> 'tinyint',
                'postgre'	=> 'boolean'),
            'bit' => array(
                'mysql' 	=> 'bit',
                'mysqli'	=> 'bit',
                'postgre'	=> 'varbit'),
            'varbit' => array(
                'mysql' 	=> '',
                'mysqli'	=> '',
                'postgre'	=> 'varbit'),
            'inet' => array(
                'mysql' 	=> '',
                'mysqli'	=> '',
                'postgre'	=> 'inet'),
            'enum' => array(
                'mysql' 	=> 'longtext',
                'mysqli'	=> 'longtext',
                'postgre'	=> 'text'),
        );

        return $types[$data][$db];
    }
}

// ------------------------------------------------------------------------
