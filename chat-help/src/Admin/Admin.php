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
use ThemeAtelier\ChatHelp\Admin\TADiscountPage\TADiscountPage;
use ThemeAtelier\ChatHelp\Admin\DBUpdates;

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
		Options::options('cwp_option');
		add_action('admin_menu', array($this, 'add_plugin_page'));
		add_filter('plugin_action_links_' . CHAT_HELP_BASENAME, array($this, 'chat_help_action_links'));
		new TADiscountPage();
		new DBUpdates();
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
			9
		);

		do_action('chat_help_recommended_page_menu');
		add_submenu_page('chat-help', __('👑 Upgrade to Pro!', 'chat-help'), sprintf('<span class="chat-help-get-pro-text">%s</span>', __('👑 Upgrade to Pro!', 'chat-help')), 'manage_options', 'https://chathelp.themeatelier.net/pricing/');
		do_action('chat_help_after_upgrade_pro_menu');
	}

	/**
	 * Options page callback
	 */
	public function chat_help_settings() {}

	public function chat_help_get_help_callback()
	{
?>
		<div class="wrap">
			<div class="chat-help-help-wrapper">
				<div class="chat_help__help--header">
					<h3><?php echo esc_html__('Chat Help', 'chat-help') ?> <span><?php echo esc_html(CHAT_HELP_VERSION) ?></span></h3>
					<?php echo wp_kses_post('Thank you for installing <strong>Chat Help</strong> plugin! This video will help you get started with the plugin.', 'chat-help') ?>
				</div>

				<div class="chat_help__help--video">
					<iframe width="560" height="315" src="https://www.youtube.com/embed/OrnL0DSvjeE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
				</div>

				<div class="chat_help__help--footer">
					<a class="button button-primary" href="<?php echo esc_url(get_admin_url()) . '/admin.php?page=chat-help'; ?>"><?php echo esc_html__('Go to settings page', 'chat-help') ?></a>
					<a target="_blank" class="button button-secondary" href="https://chathelp.themeatelier.net/pricing/"><?php echo esc_html__('Upgrade to pro', 'chat-help') ?></a>
				</div>

			</div>
		</div>
<?php }

	// Plugin settings in plugin list
	// Plugin settings in plugin list
	public function chat_help_action_links(array $links)
	{
		$new_links = array(
			sprintf('<a href="%s">%s</a>', esc_url(admin_url('admin.php?page=chat-help')), esc_html__('Settings', 'chat-help')),
			sprintf('<a target="_blank" href="%s">%s</a>', 'https://wordpress.org/support/plugin/chat-help/', esc_html__('Support', 'chat-help')),
			sprintf('<a style="font-weight: bold;color:#118c7e" target="_blank" href="%s">%s</a>', 'https://chathelp.themeatelier.net/pricing/', esc_html__('Go Pro', 'chat-help')),
		);

		return array_merge($new_links, $links);
	}
}
