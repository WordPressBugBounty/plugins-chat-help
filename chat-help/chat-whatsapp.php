<?php
/*
Plugin Name: 	Chat Help
Plugin URI: 	https://chathelp.themeatelier.net/
Description: 	WhatsApp 💬 Chat Help 🔥 Unlimited customer support tool that allows visitors to engage using "WhatsApp" or "WhatsApp Business". WhatsApp button included.
Version: 		2.2.12
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
UpdateURI:      https://chathelp.themeatelier.net/
*/

// Block Direct access
if (!defined('ABSPATH')) {
    die('You should not access this file directly!.');
}
require_once __DIR__ . '/vendor/autoload.php';

use ThemeAtelier\ChatHelp\ChatHelp;

define('CHAT_HELP_VERSION', '2.2.12');
define('CHAT_HELP_FILE', __FILE__);
define('CHAT_HELP_DIRNAME', dirname(__FILE__));
define('CHAT_HELP_DIR_PATH', plugin_dir_path(__FILE__));
define('CHAT_HELP_DIR_URL', plugin_dir_url(__FILE__));
define('CHAT_HELP_BASENAME', plugin_basename(__FILE__));

function chat_help_run()
{
    // Launch the plugin.
    $ChatHelp = new ChatHelp();
    $ChatHelp->run();
}

include_once ABSPATH . 'wp-admin/includes/plugin.php';
$pro_plugin_slug = 'chat-help-pro/chat-help-pro.php';
add_action('after_setup_theme', 'chat_help_run');
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

add_action('activated_plugin', 'redirect_to');
function redirect_to($plugin){
    if (CHAT_HELP_BASENAME === $plugin) {
        $redirect_url = esc_url(admin_url('admin.php?page=chat-help#tab=help#get-start'));
        exit(wp_kses_post(wp_safe_redirect($redirect_url)));
    }
}

/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function whatsHelp_chat_appsero_init()
{
    if (!class_exists('WhatsHelpAppSero\Insights')) {
        require_once CHAT_HELP_DIR_PATH . 'src/Admin/appsero/Client.php';
    }
    $client = new WhatsHelpAppSero\Client('faa96fc0-6c04-4d9e-95fa-3612fea71662', 'WhatsHelp Chat Support', __FILE__);
    // Active insights
    $client->insights()->init();
}

whatsHelp_chat_appsero_init();
