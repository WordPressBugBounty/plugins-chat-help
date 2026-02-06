<?php
/*
Plugin Name: 	ChatHelp
Plugin URI: 	https://wpchathelp.com/
Description: 	WhatsApp 💬 ChatHelp 🔥 Unlimited customer support tool that allows visitors to engage using "WhatsApp" or "WhatsApp Business". WhatsApp button included.
Version: 		3.1.13
Author:         ThemeAtelier
Author URI:     https://themeatelier.net/
License:        GPL-2.0+
License URI:    https://www.gnu.org/licenses/gpl-2.0.html
Requirements:   PHP 7.0 or above, WordPress 4.0 or above.
Text Domain:    chat-help
Domain Path:    /languages
Network:        true
RequiresWP:     4.0
RequiresPHP:    7.0
UpdateURI:      https://wpchathelp.com/
*/

// Block Direct access
if (!defined('ABSPATH')) {
    die('You should not access this file directly!.');
}
require_once __DIR__ . '/vendor/autoload.php';

use ThemeAtelier\ChatHelp\Includes\ChatHelp;

if (!defined('CHAT_HELP_VERSION')) {
    define('CHAT_HELP_VERSION', '3.1.13');
}
if (!defined('CHAT_HELP_FILE')) {
    define('CHAT_HELP_FILE', __FILE__);
}
if (!defined('CHAT_HELP_DIRNAME')) {
    define('CHAT_HELP_DIRNAME', dirname(__FILE__));
}
if (!defined('CHAT_HELP_DIR_PATH')) {
    define('CHAT_HELP_DIR_PATH', plugin_dir_path(__FILE__));
}
if (!defined('CHAT_HELP_DIR_URL')) {
    define('CHAT_HELP_DIR_URL', plugin_dir_url(__FILE__));
}
if (!defined('CHAT_HELP_BASENAME')) {
    define('CHAT_HELP_BASENAME', plugin_basename(__FILE__));
}
if (!defined('CHAT_HELP_URL')) {
    define('CHAT_HELP_URL', plugins_url('', CHAT_HELP_FILE));
}
if (!defined('CHAT_HELP_ASSETS')) {
    define('CHAT_HELP_ASSETS', CHAT_HELP_URL . '/src/Frontend/assets/');
}
if (!defined('CHAT_HELP_DEMO_URL')) {
    define('CHAT_HELP_DEMO_URL', 'https://wpchathelp.com/');
}

function chat_help_run()
{
    // Launch the plugin.
    $ChatHelp = new ChatHelp();
    $ChatHelp->run();
}

/**
 * Pro version check.
*
* @return boolean
*/
include_once ABSPATH . 'wp-admin/includes/plugin.php';
if (! (is_plugin_active('chat-help-pro/chat-help-pro.php') || is_plugin_active_for_network('chat-help-pro/chat-help-pro.php'))) {
    chat_help_run();
}

$pro_plugin_slug = 'chat-help-pro/chat-help-pro.php';
// kick-off the plugin
if (!is_plugin_active($pro_plugin_slug)) {
    // Register block
    function create_chat_help_block_init()
    {
        register_block_type_from_metadata(CHAT_HELP_DIR_PATH . 'src/Frontend/blocks/');
    }
    add_action('init', 'create_chat_help_block_init');

    // Register block category 
    function chat_help_plugin_block_categories($categories)
    {
        return array_merge(
            $categories,
            [
                [
                    'slug'  => 'whatsapp-block',
                    'title' => __('Whatsapp block', 'chat-help'),
                ],
            ]
        );
    }
    add_action('block_categories_all', 'chat_help_plugin_block_categories', 10, 2);
}
