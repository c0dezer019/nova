<?php

use Carbon\Carbon;

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Utility library
 *
 * @package		Nova
 * @category	Library
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_util
{
    /**
     * Sets up a more valid email sender for Nova's emails to avoid some hosts
     * marking Nova emails as spam. If there's a value in the default_email_address
     * field in Site Settings, it'll use that, otherwise it'll use nova@{domain}.
     *
     * @access	public
     * @return 	string	the email address to use
     */
    public static function email_sender()
    {
        // get an instance of the CI object
        $ci =& get_instance();

        // load the settings model
        $ci->load->model('settings_model', 'settings');

        // grab the default email address
        $default = $ci->settings->get_setting('default_email_address');

        // if there's something in the default email address, use that
        if (! empty($default)) {
            return $default;
        }

        return 'nova@'.preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
    }

    /**
     * Uses the rank.yml file to quickly install a rank set. If no value is
     * passed to the method then the method will attempt to find all uninstalled
     * ranks and install them.
     *
     *     Utility::install_rank();
     *     Utility::install_rank('location');
     *
     * @access	public
     * @param	string	the location of a specific rank set to install
     * @return	void
     */
    public static function install_rank($location = null)
    {
        $ci =& get_instance();

        $ci->load->helper('yayparser');
        $ci->load->model('ranks_model', 'ranks');

        if ($location === null) {
            $ci->load->helper('directory');

            // get the directory listing for the genre
            $dir = directory_map(APPPATH.'assets/common/'.GENRE.'/ranks/', true);

            if (is_array($dir)) {
                // get all the rank sets locations
                $ranks = $ci->ranks->get_all_rank_sets();

                if ($ranks->num_rows() > 0) {
                    // start by removing anything that's already installed
                    foreach ($ranks->result() as $rank) {
                        // find the location in the directory listing
                        $key = array_search($rank->rankcat_location, $dir);

                        if ($key !== false) {
                            unset($dir[$key]);
                        }
                    }

                    // loop through the directories now
                    foreach ($dir as $key => $value) {
                        // assign our path to a variable
                        $file = APPPATH.'assets/common/'.GENRE.'/ranks/'.$value.'/rank.yml';

                        // make sure the file exists first
                        if (file_exists($file)) {
                            $content = file_get_contents($file);
                            $data = yayparser($content);

                            $addValues = array(
                                'rankcat_name' 		=> $data['rank'],
                                'rankcat_location' 	=> $data['location'],
                                'rankcat_credits' 	=> $data['credits'],
                                'rankcat_preview' 	=> $data['preview'],
                                'rankcat_blank' 	=> $data['blank'],
                                'rankcat_extension'	=> $data['extension'],
                                'rankcat_genre'		=> $data['genre']
                            );
                            $ci->ranks->add_rank_set($addValues);
                        }
                    }
                }
            }
        } else {
            // assign our path to a variable
            $file = APPPATH.'assets/common/'.GENRE.'/ranks/'.$location.'/rank.yml';

            // make sure the file exists first
            if (file_exists($file)) {
                // get the contents and decode the YAML
                $content = file_get_contents($file);
                $data = yayparser($content);

                $addValues = array(
                    'rankcat_name' 		=> $data['rank'],
                    'rankcat_location' 	=> $data['location'],
                    'rankcat_credits' 	=> $data['credits'],
                    'rankcat_preview' 	=> $data['preview'],
                    'rankcat_blank' 	=> $data['blank'],
                    'rankcat_extension'	=> $data['extension'],
                    'rankcat_genre'		=> $data['genre']
                );
                $ci->ranks->add_rank_set($addValues);
            }
        }
    }

    /**
     * Uses the skin.yml file to quickly install a skin. If no value is passed
     * to the method then the method will attempt to find all uninstalled skins
     * and install them.
     *
     *     Utility::install_skin();
     *     Utility::install_skin('location');
     *
     * @access	public
     * @param	string	the location of a skin to install
     * @return	void
     */
    public static function install_skin($location = null)
    {
        $ci =& get_instance();

        $ci->load->helper('yayparser');
        $ci->load->model('system_model', 'sys');

        if ($location === null) {
            $ci->load->helper('directory');

            // get the listing of the directory
            $dir = directory_map(APPPATH.'views/', true);

            if (is_array($dir)) {
                // get all the skin catalogue items
                $skins = $ci->sys->get_all_skins();

                if ($skins->num_rows() > 0) {
                    // start by removing anything that's already installed
                    foreach ($skins->result() as $skin) {
                        // find the location in the directory listing
                        $key = array_search($skin->skin_location, $dir);

                        if ($key !== false) {
                            unset($dir[$key]);
                        }
                    }

                    // create an array of items to remove
                    $pop = array('template.php');

                    // remove the items
                    foreach ($pop as $p) {
                        // find the location in the directory listing
                        $key = array_search($p, $dir);

                        if ($key !== false) {
                            unset($dir[$key]);
                        }
                    }

                    // now loop through the directories and install the skins
                    foreach ($dir as $key => $value) {
                        // assign our path to a variable
                        $file = APPPATH.'views/'.$value.'/skin.yml';

                        // make sure the file exists first
                        if (file_exists($file)) {
                            $content = file_get_contents($file);
                            $data = yayparser($content);

                            $mainAdd = array(
                                'skin_name' 	=> $data['skin'],
                                'skin_location' => $data['location'],
                                'skin_credits' 	=> $data['credits'],
                                'skin_version' 	=> $data['version']
                            );
                            $ci->sys->add_skin($mainAdd);

                            // go through and add the sections
                            foreach ($data['sections'] as $v) {
                                $secAdd = array(
                                    'skinsec_section' 	=> $v['type'],
                                    'skinsec_skin' 		=> $data['location'],
                                    'skinsec_preview' 	=> $v['preview'],
                                    'status' => 		'active',
                                    'default' => 		'n'
                                );
                                $ci->sys->add_skin_section($secAdd);
                            }
                        }
                    }
                }
            }
        } else {
            // assign our path to a variable
            $file = APPPATH.'views/'.$location.'/skin.yml';

            // make sure the file exists first
            if (file_exists($file)) {
                // get the contents and decode the JSON
                $content = file_get_contents($file);
                $data = yayparser($content);

                $mainAdd = array(
                    'skin_name' 	=> $data['skin'],
                    'skin_location' => $data['location'],
                    'skin_credits' 	=> $data['credits'],
                    'skin_version' 	=> $data['version']
                );
                $ci->sys->add_skin($mainAdd);

                // go through and add the sections
                foreach ($data->sections as $v) {
                    $secAdd = array(
                        'skinsec_section' 	=> $v['type'],
                        'skinsec_skin' 		=> $data['location'],
                        'skinsec_preview' 	=> $v['preview'],
                        'status' => 		'active',
                        'default' => 		'n'
                    );
                    $ci->sys->add_skin_section($secAdd);
                }
            }
        }
    }

    public static function unserializeSessionData($sessionData)
    {
        $method = ini_get('session.serialize_handler');

        switch ($method) {
            case 'php':
                return self::unserialize_php($sessionData);
                break;

            case 'php_binary':
                return self::unserialize_phpbinary($sessionData);
                break;

            default:
                throw new Exception("Unsupported session.serialize_handler: {$method}. Supported: php, php_binary");
                break;
        }
    }

    public static function fullHeartbeat()
    {
        $ci =& get_instance();

        $ci->load->model('system_model', 'sys');
        $ci->load->database();

        $info = $ci->sys->get_system_info();

        return array_merge(static::simpleHeartbeat(), [
            'url' => base_url(),
            'genre' => GENRE,
            'php_version' => phpversion(),
            'db_driver' => $ci->db->platform(),
            'db_version' => $ci->db->version(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'install_date' => $info ? $info->sys_install_date : null,
        ]);
    }

    public static function simpleHeartbeat($dataset = null)
    {
        switch ($dataset) {
            case 'last-month':
                $data = [
                    'start' => Carbon::now()->subMonth()->startOfMonth()->getTimestamp(),
                    'end' => Carbon::now()->subMonth()->endOfMonth()->getTimestamp(),
                ];
                break;
            case 'last-year':
                $data = [
                    'start' => Carbon::now()->subYear()->startOfYear()->getTimestamp(),
                    'end' => Carbon::now()->subYear()->endOfYear()->getTimestamp(),
                ];
                break;
            case 'this-month':
                $data = [
                    'start' => Carbon::now()->startOfMonth()->getTimestamp(),
                    'end' => Carbon::now()->endOfMonth()->getTimestamp(),
                ];
                break;
            case 'this-year':
                $data = [
                    'start' => Carbon::now()->startOfYear()->getTimestamp(),
                    'end' => Carbon::now()->endOfYear()->getTimestamp(),
                ];
                break;
            default:
                $data = [
                    'start' => null,
                    'end' => null,
                ];
                break;
        }

        $ci =& get_instance();

        $ci->load->model('settings_model', 'settings');
        $ci->load->model('characters_model', 'char');
        $ci->load->model('users_model', 'user');
        $ci->load->model('personallogs_model', 'logs');
        $ci->load->model('posts_model', 'posts');
        $ci->load->model('missions_model', 'mis');

        $info = $ci->sys->get_system_info();

        $lastPublishedPost = $ci->posts->get_last_published_post();

        $heartbeatData = [
            'name' => $ci->settings->get_setting('sim_name'),
            'version' => APP_VERSION,
            'active_users' => $ci->user->count_all_users(
                is_null($dataset) ? 'active' : null,
                $data['start'],
                $data['end']
            ),
            'active_primary_characters' => $ci->char->count_primary_characters(
                is_null($dataset) ? 'active' : null,
                $data['start'],
                $data['end']
            ),
            'active_secondary_characters' => $ci->char->count_secondary_characters(
                is_null($dataset) ? 'active' : null,
                $data['start'],
                $data['end']
            ),
            'active_support_characters' => $ci->char->count_support_characters(
                $data['start'],
                $data['end']
            ),
            'total_stories' => $ci->mis->count_missions(
                $data['start'],
                $data['end']
            ),
            'total_posts' => $ci->posts->count_all_posts(null, 'activated', $data['start'], $data['end']) + $ci->logs->count_all_logs('activated', $data['start'], $data['end']),
            'total_post_words' => $ci->posts->count_all_post_words('activated', $data['start'], $data['end']) + $ci->logs->count_all_log_words('activated', $data['start'], $data['end']),
            'last_published_post' => $lastPublishedPost ? Carbon::createFromFormat('U', $lastPublishedPost->post_date)->toDateTimeString() : null,
        ];

        if (filled($info->sys_anodyne_game_id)) {
            $heartbeatData['game_id'] = $info->sys_anodyne_game_id;
        }

        return $heartbeatData;
    }

    private static function unserialize_php($sessionData)
    {
        $return_data = [];
        $offset = 0;

        while ($offset < strlen($sessionData)) {
            if (!strstr(substr($sessionData, $offset), "|")) {
                throw new Exception("invalid data, remaining: " . substr($sessionData, $offset));
            }

            $pos = strpos($sessionData, "|", $offset);
            $num = $pos - $offset;
            $varname = substr($sessionData, $offset, $num);
            $offset += $num + 1;
            $data = @unserialize(substr($sessionData, $offset));
            $return_data[$varname] = $data;
            $offset += strlen(serialize($data));
        }

        return $return_data;
    }

    private static function unserialize_phpbinary($sessionData)
    {
        $return_data = [];
        $offset = 0;

        while ($offset < strlen($sessionData)) {
            $num = ord($sessionData[$offset]);
            $offset += 1;
            $varname = substr($sessionData, $offset, $num);
            $offset += $num;
            $data = unserialize(substr($sessionData, $offset));
            $return_data[$varname] = $data;
            $offset += strlen(serialize($data));
        }

        return $return_data;
    }
}
