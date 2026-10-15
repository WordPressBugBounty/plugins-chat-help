<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/src/Admin/Views/Advance
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
	$chat_help_options = [
		'cwp_option',
		'ch_wooCommerce',
		'ch_shortcode',
		'ch_settings',
		'ch_help',
		'chat_help_version',
		'chat_help_db_version',
		'chat_help_first_version',
		'chat_help_activation_date',
		'themeatelier_offer_banner_dismissed_new_year_2026',
	];

	foreach ($chat_help_options as $chat_help_option_name) {
		delete_option($chat_help_option_name);       // Delete regular option.
		delete_site_option($chat_help_option_name); // Delete multisite option.
	}

	// delete leads table
	$chat_help_table_name = $wpdb->prefix . 'chat_help_leads';
	$wpdb->query("DROP TABLE IF EXISTS `$chat_help_table_name`"); // phpcs:ignore PluginCheck.Security.DirectDB.UnescapedDBParameter, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.SchemaChange, WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Drops the plugin's own tables on uninstall; the names are $wpdb->prefix . 'chat_help_*'.
	$chat_help_table_name_analytics = $wpdb->prefix . 'chat_help_analytics';
	$wpdb->query("DROP TABLE IF EXISTS `$chat_help_table_name_analytics`"); // phpcs:ignore PluginCheck.Security.DirectDB.UnescapedDBParameter, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.SchemaChange, WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Drops the plugin's own tables on uninstall; the names are $wpdb->prefix . 'chat_help_*'.
}

// Load WPTP file.
require plugin_dir_path(__FILE__) . '/chat-whatsapp.php';
$chat_help_ch_settings = get_option('ch_settings');
$chat_help_data_delete     = isset($chat_help_ch_settings['cleanup_data_deletion']) ? $chat_help_ch_settings['cleanup_data_deletion'] : false;

if ($chat_help_data_delete) {
	chat_help_delete_plugin_data();
}
