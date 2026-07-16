<?php
/*
Plugin Name: 	ChatHelp
Plugin URI: 	https://wpchathelp.com/
Description: 	WhatsApp 💬 ChatHelp 🔥 Unlimited customer support tool that allows visitors to engage using "WhatsApp" or "WhatsApp Business". WhatsApp button included.
Version: 		3.5.2
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
    define('CHAT_HELP_VERSION', '3.5.2');
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

    /**
     * New WhatsApp Button blocks start prefilled with the Global Chat
     * number/group. The block saves static HTML (no server render), so a live
     * fallback is impossible here — injecting the attribute defaults at
     * registration is the closest equivalent. Applies to newly inserted
     * blocks; already-saved blocks keep the values baked into their markup.
     */
    function chat_help_block_default_whatsapp($metadata)
    {
        if (isset($metadata['name']) && 'create-block/whatsapp-button' === $metadata['name']) {
            $global = \ThemeAtelier\ChatHelp\Frontend\Helpers\Helpers::global_whatsapp_defaults();
            if ('' !== $global['number']) {
                $metadata['attributes']['numberInput']['default'] = $global['number'];
            }
            if ('' !== $global['group']) {
                $metadata['attributes']['groupInput']['default'] = $global['group'];
            }
        }
        return $metadata;
    }
    add_filter('block_type_metadata', 'chat_help_block_default_whatsapp');

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

/**
 * Runs once on activation: best-effort detects the site's country and stores
 * it as the WhatsApp Number field's default country/dial-code. Only ever
 * runs when nothing has been detected/saved yet, so re-activating an
 * existing install (or a plugin update) never touches an admin's real
 * settings — Assets::detect_default_country() only falls back to this value
 * while the field itself is still empty.
 */
function chat_help_detect_activation_country()
{
    // Reverse-proxy geo header (Cloudflare, etc.), when present — instant,
    // no network call.
    foreach (['HTTP_CF_IPCOUNTRY', 'HTTP_X_COUNTRY_CODE', 'HTTP_GEOIP_COUNTRY_CODE'] as $header) {
        if (!empty($_SERVER[$header]) && strlen($_SERVER[$header]) === 2) {
            return strtolower(sanitize_text_field($_SERVER[$header]));
        }
    }

    // One-time, short-timeout IP geolocation lookup — activation only runs
    // once per install, so a couple of seconds here is an acceptable cost.
    $response = wp_remote_get('https://ipapi.co/country/', ['timeout' => 3]);
    if (!is_wp_error($response) && 200 === (int) wp_remote_retrieve_response_code($response)) {
        $code = trim(wp_remote_retrieve_body($response));
        if (preg_match('/^[A-Za-z]{2}$/', $code)) {
            return strtolower($code);
        }
    }

    // Last resort: same site-locale guess Assets::detect_default_country() uses.
    $locale = get_locale();
    if (preg_match('/_([A-Za-z]{2})$/', $locale, $matches)) {
        return strtolower($matches[1]);
    }

    return '';
}

function chat_help_activate()
{
    if (false !== get_option('chat_help_default_country')) {
        return;
    }

    $country = chat_help_detect_activation_country();
    if ($country) {
        update_option('chat_help_default_country', $country, false);
    }
}
register_activation_hook(CHAT_HELP_FILE, 'chat_help_activate');

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
    $client = new WhatsHelpAppSero\Client('faa96fc0-6c04-4d9e-95fa-3612fea71662', 'WhatsApp Chat Help', __FILE__);
    // Active insights
    $client->insights()->init();
}

whatsHelp_chat_appsero_init();
