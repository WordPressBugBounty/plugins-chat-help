<?php

/**
 * The admin-facing functionality of the plugin.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/Admin
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin;

/**
 * The admin class
 */
class DBUpdates
{
    /**
     * DB updates that need to be run
     *
     * @var array
     */
    private static $updates = array(
        '2.1.0' => 'updates/update-2.1.0.php',
        '2.2.9' => 'updates/update-2.2.9.php',
    );

    /**
     * The class constructor.
     *
     */
    function __construct()
    {
        add_action('admin_init', array($this, 'perform_updates'));
    }

    /**
     * Check if an update is needed.
     *
     * @return bool
     */
    public function is_needs_update()
    {
        $installed_version = get_option('chat_help_version');
        $first_version     = get_option('chat_help_first_version');
        $activation_date   = get_option('chat_help_activation_date');

        if (false === $installed_version) {
            update_option('chat_help_version', '2.0.14');
            update_option('chat_help_db_version', '2.0.14');
        }
        if (false === $first_version) {
            update_option('chat_help_first_version', CHAT_HELP_VERSION);
        }
        if (false === $activation_date) {
            update_option('chat_help_activation_date', current_time('timestamp'));
        }

        if (version_compare($installed_version, CHAT_HELP_VERSION, '<')) {
            return true;
        }

        return false;
    }

    /**
     * Perform all updates.
     *
     */
    public function perform_updates()
    {
        if (!$this->is_needs_update()) {
            return;
        }

        $installed_version = get_option('chat_help_version');

        foreach (self::$updates as $version => $path) {
            if (version_compare($installed_version, $version, '<')) {
                include $path;
                update_option('chat_help_version', $version);
            }
        }

        update_option('chat_help_version', CHAT_HELP_VERSION);
    }
}
