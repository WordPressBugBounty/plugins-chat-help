<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help-pro
 * @subpackage chat-help-pro/src/Admin/Views/Advance
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

// If uninstall not called from WordPress, then exit.
if (! defined('WP_UNINSTALL_PLUGIN')) {
	exit;
}

/**
 * Delete plugin data function.
 *
 * @return void
 */
function chat_help_delete_plugin_data()
{
	global $wpdb;
	// Delete plugin option settings.
	$options = [
		'cwp_option',
		'chat_help_version',
		'chat_help_db_version',
		'chat_help_first_version',
		'chat_help_activation_date'
	];

	foreach ($options as $option_name) {
		delete_option($option_name);       // Delete regular option.
		delete_site_option($option_name); // Delete multisite option.
	}

	// delete leads table
	$table_name = $wpdb->prefix . 'chat_help_leads';
	$wpdb->query("DROP TABLE IF EXISTS `$table_name`");
}

// Load WPTP file.
require plugin_dir_path(__FILE__) . '/chat-whatsapp.php';
$chat_help_plugin_settings = get_option('cwp_option');
$chat_help_data_delete     = isset($chat_help_plugin_settings['cleanup_data_deletion']) ? $chat_help_plugin_settings['cleanup_data_deletion'] : false;

if ($chat_help_data_delete) {
	chat_help_delete_plugin_data();
}
