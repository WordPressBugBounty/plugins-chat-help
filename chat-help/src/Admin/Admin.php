<?php

/**
 * The admin-facing functionality of the plugin.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/src/Admin
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin;

use ThemeAtelier\ChatHelp\Admin\Views\Options;
use ThemeAtelier\ChatHelp\Admin\DBUpdates;
use ThemeAtelier\ChatHelp\Admin\Leads;
use ThemeAtelier\ChatHelp\Admin\ReviewNotice\ThemeAtelier_Offer_Banner;
use ThemeAtelier\ChatHelp\Admin\Views\GetHelp;
use ThemeAtelier\ChatHelp\Admin\Views\Settings;
use ThemeAtelier\ChatHelp\Admin\Views\Shortcode;
use ThemeAtelier\ChatHelp\Admin\Views\WooCommerce;

if (! defined('ABSPATH')) {
	die;
} // Cannot access directly.
/**
 * The admin class
 */
class Admin
{

	/**
	 * The slug of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_slug   The slug of this plugin.
	 */
	private $plugin_slug;

	/**
	 * The min of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $min   The slug of this plugin.
	 */
	private $min;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The class constructor.
	 *
	 * @param string $plugin_slug The slug of the plugin.
	 * @param string $version Current version of the plugin.
	 */
	function __construct($plugin_slug, $version)
	{
		$this->plugin_slug = $plugin_slug;
		$this->version     = $version;
		$this->min         = defined('WP_DEBUG') && WP_DEBUG ? '' : '.min';
		add_action('admin_menu', array($this, 'add_plugin_page'));
		add_action('after_setup_theme', array($this, 'initialize_options'));
		add_filter('admin_footer_text', array($this, 'admin_footer'), 1, 2);

		new DBUpdates();
		new Leads();

		if (! defined('THEMEATELIER_OFFER_BANNER_LOADED')) {
			define('THEMEATELIER_OFFER_BANNER_LOADED', true);
			ThemeAtelier_Offer_Banner::instance();
		}

		$active_plugins = get_option('active_plugins');
		foreach ($active_plugins as $active_plugin) {
			$_temp = strpos($active_plugin, 'chat-whatsapp.php');
			if (false != $_temp) {
				add_filter('plugin_action_links_' . CHAT_HELP_BASENAME, array($this, 'chat_help_action_links'));
				add_filter('plugin_row_meta', array($this, 'after_chat_help_row_meta'), 10, 4);
			}
		}
	}

	public function initialize_options()
	{
		Options::options('cwp_option');
		WooCommerce::options('ch_wooCommerce');
		Shortcode::options('ch_shortcode');
		Settings::options('ch_settings');
		GetHelp::options('ch_help');
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public static function enqueue_scripts($hook)
	{
		$min         = defined('WP_DEBUG') && WP_DEBUG ? '' : '.min';
		if ('whatsapp-chat_page_chat-help-help' == $hook) {

			wp_enqueue_style('chat-help-help');
		}
		wp_enqueue_style('admin');

		// Review notice CSS
		wp_enqueue_style('chat-help-review-notice', CHAT_HELP_DIR_URL . 'src/Admin/ReviewNotice/assets/css/review-notice' . $min . '.css', array(), CHAT_HELP_VERSION, 'all');
	}

	public function add_plugin_page()
	{
		// This page will be under "Settings"
		add_menu_page(
			esc_html__('WhatsApp Chat', 'chat-help'),
			esc_html__('WhatsApp Chat', 'chat-help'),
			'manage_options',
			'chat-help',
			array($this, 'chat_help_settings'),
			'dashicons-whatsapp',
			58
		);
		add_submenu_page(
			'chat-help',
			esc_html__('Floating Chat', 'chat-help'),
			esc_html__('Floating Chat', 'chat-help'),
			'manage_options',
			'chat-help',
			[$this, 'chat_help_settings']
		);
		do_action('chat_help_recommended_page_menu');
		add_submenu_page(
			'chat-help',
			esc_html__('WooCommerce', 'chat-help'),
			esc_html__('WooCommerce', 'chat-help'),
			'manage_options',
			'chat-help-woo',
			[$this, 'chat_help_settings']
		);
		add_submenu_page(
			'chat-help',
			esc_html__('Shortcode', 'chat-help'),
			esc_html__('Shortcode', 'chat-help'),
			'manage_options',
			'chat-help-shortcode',
			[$this, 'chat_help_settings']
		);
		add_submenu_page(
			'chat-help',
			esc_html__('Settings', 'chat-help'),
			esc_html__('Settings', 'chat-help'),
			'manage_options',
			'chat-help-settings',
			[$this, 'chat_help_settings']
		);
		add_submenu_page(
			'chat-help',
			esc_html__('Help', 'chat-help'),
			esc_html__('Help', 'chat-help'),
			'manage_options',
			'chat-help-help',
			[$this, 'chat_help_settings']
		);
		add_submenu_page('chat-help', __('Upgrade To Premium', 'chat-help'), sprintf('<span style="color:#35b747; font-weight: bold;" class="chat-help-get-pro-text">%s</span>', __('Upgrade To Pro! 👑', 'chat-help')), 'manage_options', CHAT_HELP_DEMO_URL . 'pricing/?utm_source=chat_help_plugin&utm_medium=submenu_page&utm_campaign=regular');
	}

	/**
	 * Options page callback
	 */
	public function chat_help_settings() {}

	// Plugin settings in plugin list
	public function chat_help_action_links(array $links)
	{
		$new_links = array(
			sprintf('<a href="%s">%s</a>', esc_url(admin_url('admin.php?page=chat-help')), esc_html__('Settings', 'chat-help')),
			sprintf('<a target="_blank" href="%s">%s</a>', 'https://wordpress.org/support/plugin/chat-help/', esc_html__('Support', 'chat-help')),
		);

		$links[] = sprintf('<a style="font-weight: bold;color:#35b747" target="_blank" href="https://wpchathelp.com/pricing/?utm_source=chat_help_plugin&utm_medium=action_link&utm_campaign=new_year_regular">%s</a>', esc_html__('Go Pro!', 'chat-help'));

		return array_merge($new_links, $links);
	}

	/**
	 * Add plugin row meta link.
	 *
	 * @since 2.0
	 *
	 * @param array  $plugin_meta .
	 * @param string $file .
	 *
	 * @return array
	 */
	public function after_chat_help_row_meta($plugin_meta, $file)
	{

		if (CHAT_HELP_BASENAME === $file) {
			$plugin_meta[] = '<a href="' . CHAT_HELP_DEMO_URL . '" target="_blank">' . __('Live Demo', 'chat-help') . '</a>';
		}

		return $plugin_meta;
	}

	/**
	 * Review Text.
	 *
	 * @param string $text text.
	 *
	 * @return string
	 */
	public function admin_footer($text)
	{

		$screen = get_current_screen();
		if ('toplevel_page_chat-help' === $screen->id || 'whatsapp-chat_page_chat-help-leads' === $screen->id || 'whatsapp-chat_page_chat-help-shortcode' === $screen->id || 'whatsapp-chat_page_chat-help-settings' === $screen->id || 'whatsapp-chat_page_chat-help-woo' === $screen->id || 'whatsapp-chat_page_chat-help-help' === $screen->id) {
			$text = sprintf(
				/* translators: 1: start strong tag, 2: close strong tag. 3: start link 4: close link */
				__('<i>Enjoying %1$sWhatsApp ChatHelp?%2$s Please rate us %3$sWordPress.org%4$s. Your positive feedback will help us grow more. Thank you! 😊</i>', 'chat-help'),
				'<strong>',
				'</strong>',
				'<span class="greet-footer-text-star">★★★★★</span> <a href="https://wordpress.org/support/plugin/chat-help/reviews/#new-post" target="_blank">',
				'</a>'
			);
		}

		return $text;
	}
}
