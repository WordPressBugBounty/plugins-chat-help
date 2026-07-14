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
use ThemeAtelier\ChatHelp\Admin\Assets;
use ThemeAtelier\ChatHelp\Admin\Rest\SettingsRest;
use ThemeAtelier\ChatHelp\Admin\Rest\MetaRest;
use ThemeAtelier\ChatHelp\Admin\Rest\PreviewRest;
use ThemeAtelier\ChatHelp\Admin\Rest\HelpRest;
use ThemeAtelier\ChatHelp\Admin\Rest\OnboardingRest;
use ThemeAtelier\ChatHelp\Admin\Views\AssignWidget;
use ThemeAtelier\ChatHelp\Admin\Views\WidgetMetabox;
use ThemeAtelier\ChatHelp\Frontend\Helpers\Helpers;

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
		// Pro-only schemas, registered so the React admin can render them as
		// locked previews (ProFeatures marks both keys fully Pro-locked).
		add_action('after_setup_theme', array($this, 'assign_widget_configs'));
		add_action('after_setup_theme', array($this, 'floating_widget_metabox'));
		add_filter('admin_footer_text', array($this, 'admin_footer'), 1, 2);

		new DBUpdates();
		new Leads();

		// React admin: single bundle/asset owner + REST controllers. Constructed
		// unconditionally (this class runs on every request, incl. REST) so the
		// routes register on rest_api_init.
		new Assets();
		new SettingsRest();
		new MetaRest();
		new PreviewRest();
		new HelpRest();
		new OnboardingRest();

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

		// Every classic settings slug now redirects into the React SPA.
		add_action('admin_init', array($this, 'redirect_settings_to_spa'));

		// Chat Layouts. The CPT is registered (so its URLs resolve and the SPA's
		// list/editor can read existing layouts) but it is Pro-locked: MetaRest
		// refuses every write and the React editor renders read-only.
		add_action('init', array($this, 'register_chat_help_post_type'));
		add_filter('parent_file', array($this, 'chat_help_highlight_menu'));
		add_filter('submenu_file', array($this, 'chat_help_submenu_highlight'));
		add_action('admin_head', array($this, 'admin_menu_styles'));
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
	 * Register the Assign Layouts schema. Pro-only: rendered read-only.
	 */
	public function assign_widget_configs()
	{
		AssignWidget::settings('assign_widget');
	}

	/**
	 * Register the Chat Layouts (floating widget) schema. Pro-only: the editor
	 * renders as a read-only preview and MetaRest refuses every write.
	 */
	public function floating_widget_metabox()
	{
		WidgetMetabox::options('ch_meta');
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public static function enqueue_scripts($hook)
	{
		$min = defined('WP_DEBUG') && WP_DEBUG ? '' : '.min';

		// The React admin bundle is enqueued by Assets (the single owner). The old
		// Codestar `admin` stylesheet handle was registered by the removed
		// framework, and the classic Help page now redirects into the SPA, so
		// neither is enqueued here any more.

		// Review notice CSS (free-only).
		wp_enqueue_style('chat-help-review-notice', CHAT_HELP_DIR_URL . 'src/Admin/ReviewNotice/assets/css/review-notice' . $min . '.css', array(), CHAT_HELP_VERSION, 'all');
	}

	/**
	 * Register the admin menu. Mirrors the Pro plugin's structure one-for-one so
	 * both versions navigate identically, plus the free-only "Upgrade To Pro" item.
	 */
	public function add_plugin_page()
	{
		add_menu_page(
			esc_html__('WhatsApp Chat', 'chat-help'),
			esc_html__('WhatsApp Chat', 'chat-help'),
			'manage_options',
			'chat-help',
			[$this, 'render_react_page'],
			'dashicons-whatsapp',
			58
		);
		do_action('chat_help_before_submenus');

		add_submenu_page(
			'chat-help',
			esc_html__('Dashboard', 'chat-help'),
			esc_html__('Dashboard', 'chat-help'),
			'manage_options',
			'chat-help',
			[$this, 'render_react_page']
		);

		// Parent group header, rendered as a collapsible toggle in the sidebar
		// (see admin_menu_styles). Its Global Chat / Chat Layouts / Leads children
		// are the next 3 submenu items, registered contiguously right after it.
		add_submenu_page(
			'chat-help',
			esc_html__('Floating Chat', 'chat-help'),
			esc_html__('Floating Chat', 'chat-help'),
			'manage_options',
			'chat-help-floating',
			[$this, 'chat_help_settings']
		);

		add_submenu_page(
			'chat-help',
			esc_html__('Global Chat', 'chat-help'),
			esc_html__('Global Chat', 'chat-help'),
			'manage_options',
			'floating-chat',
			[$this, 'chat_help_settings']
		);
		add_submenu_page(
			'chat-help',
			esc_html__('Chat Layouts', 'chat-help'),
			esc_html__('Chat Layouts', 'chat-help'),
			'manage_options',
			'edit.php?post_type=floating_widget'
		);

		// NOTE: the slug must not contain `#` — WordPress URL-encodes the menu
		// href, so the hash never reaches the browser. A clean slug +
		// redirect_settings_to_spa() lands on #/leads reliably.
		add_submenu_page(
			'chat-help',
			esc_html__('Leads', 'chat-help'),
			esc_html__('Leads', 'chat-help'),
			'manage_options',
			'chat-help-leads',
			[$this, 'chat_help_settings']
		);

		// Assign Layouts keeps its registration (so `page=assign-widget` resolves
		// and redirect_settings_to_spa() can map it) but its <li> is hidden — it's
		// reached via a tab on the Chat Layouts page, exactly as in Pro.
		add_submenu_page(
			'chat-help',
			esc_html__('Assign Layouts', 'chat-help'),
			esc_html__('Assign Layouts', 'chat-help'),
			'manage_options',
			'assign-widget',
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
			esc_html__('Get Help', 'chat-help'),
			esc_html__('Get Help', 'chat-help'),
			'manage_options',
			'chat-help-help',
			[$this, 'chat_help_settings']
		);

		// Free-only.
		add_submenu_page('chat-help', __('Upgrade To Premium', 'chat-help'), sprintf('<span style="color:#35b747; font-weight: bold;" class="chat-help-get-pro-text">%s</span>', __('Upgrade To Pro! 👑', 'chat-help')), 'manage_options', CHAT_HELP_DEMO_URL . 'pricing/?utm_source=chat_help_plugin&utm_medium=submenu_page&utm_campaign=regular');
	}

	/**
	 * Redirect the classic (Codestar) settings slugs into the React SPA.
	 *
	 * Every settings page now lives inside the single SPA mounted on the
	 * `chat-help` top-level page as a hash route. Direct loads of the classic
	 * submenu slugs (which WordPress still registers for the menu links) are
	 * redirected to `admin.php?page=chat-help#/global?section=general<route>`. In-SPA clicks are
	 * intercepted client-side by Layout.jsx (no reload). Append `&classic=1` to
	 * bypass the redirect (used only during migration/debugging).
	 *
	 * @return void
	 */
	public function redirect_settings_to_spa()
	{
		if (wp_doing_ajax() || (defined('REST_REQUEST') && REST_REQUEST)) {
			return;
		}

		$page = isset($_GET['page']) ? sanitize_key(wp_unslash($_GET['page'])) : '';
		$map  = array(
			'chat-help-floating'  => '#/global',
			'floating-chat'       => '#/global',
			'chat-help-leads'     => '#/leads',
			'chat-help-woo'       => '#/woocommerce',
			'chat-help-shortcode' => '#/shortcode',
			'chat-help-settings'  => '#/settings',
			'chat-help-help'      => '#/help',
			'assign-widget'       => '#/assign-widget',
		);

		if (isset($map[$page]) && empty($_GET['classic'])) {
			wp_safe_redirect(admin_url('admin.php?page=chat-help#/global?section=general') . $map[$page]);
			exit;
		}

		if (! empty($_GET['classic'])) {
			return;
		}

		// Redirect the classic floating_widget CPT screens (list / new / edit)
		// into the SPA's React editor.
		global $pagenow;
		$base = admin_url('admin.php?page=chat-help#/global?section=general');

		if ($pagenow === 'edit.php'
			&& isset($_GET['post_type'])
			&& sanitize_key(wp_unslash($_GET['post_type'])) === 'floating_widget'
		) {
			wp_safe_redirect($base . '#/widgets');
			exit;
		}

		if ($pagenow === 'post-new.php'
			&& isset($_GET['post_type'])
			&& sanitize_key(wp_unslash($_GET['post_type'])) === 'floating_widget'
		) {
			wp_safe_redirect($base . '#/widgets/new');
			exit;
		}

		if ($pagenow === 'post.php'
			&& isset($_GET['post'])
			&& get_post_type((int) $_GET['post']) === 'floating_widget'
		) {
			wp_safe_redirect($base . '#/widgets/' . (int) $_GET['post']);
			exit;
		}
	}

	/**
	 * Options page callback
	 */
	public function chat_help_settings() {}

	public static function render_react_page(): void
	{
		echo '<div id="chat_help_pro_react"></div>';
	}

	/**
	 * Register the Chat Layouts post type.
	 *
	 * Registered in the free plugin so the Chat Layouts screens resolve and the
	 * SPA can list any layouts a user created while running Pro. Creating and
	 * editing them is Pro-only (MetaRest returns 403; the editor is read-only).
	 *
	 * Unlike the Pro plugin this does NOT call flush_rewrite_rules() — the CPT is
	 * private (`public => false`, no front-end URLs), so flushing on every `init`
	 * would just burn a write on each request.
	 *
	 * @return void
	 */
	public function register_chat_help_post_type()
	{
		if (post_type_exists('floating_widget')) {
			return;
		}
		$capability = Helpers::chat_help_dashboard_capability();
		$show_ui    = current_user_can($capability) ? true : false;

		$labels = apply_filters(
			'chat_help_post_type_labels',
			array(
				'name'               => esc_html__('Floating Widget', 'chat-help'),
				'singular_name'      => esc_html__('Floating Widget', 'chat-help'),
				'menu_name'          => esc_html__('Floating Widget', 'chat-help'),
				'all_items'          => esc_html__('All Widgets', 'chat-help'),
				'add_new'            => esc_html__('Add Widget', 'chat-help'),
				'add_new_item'       => esc_html__('Add New Layout', 'chat-help'),
				'new_item'           => esc_html__('Add New Layout', 'chat-help'),
				'edit_item'          => esc_html__('Edit Generated Widget', 'chat-help'),
				'view_item'          => esc_html__('View Generated Widget', 'chat-help'),
				'name_admin_bar'     => esc_html__('Widget Generator', 'chat-help'),
				'search_items'       => esc_html__('Search Layout', 'chat-help'),
				'parent_item_colon'  => esc_html__('Parent Layout:', 'chat-help'),
				'not_found'          => esc_html__('No Widget found.', 'chat-help'),
				'not_found_in_trash' => esc_html__('No Widget found in Trash.', 'chat-help'),
			)
		);

		$args = apply_filters(
			'chat_help_post_type_args',
			array(
				'label'             => esc_html__('Floating Widget', 'chat-help'),
				'description'       => esc_html__('Floating Widget', 'chat-help'),
				'public'            => false,
				'show_ui'           => $show_ui,
				'show_in_nav_menus' => false,
				'show_in_menu'      => false,
				'menu_icon'         => 'dashicons-calendar',
				'hierarchical'      => false,
				'query_var'         => false,
				'menu_position'     => 7,
				'supports'          => array('title'),
				'capabilities'      => array(
					'publish_posts'       => $capability,
					'edit_posts'          => $capability,
					'edit_others_posts'   => $capability,
					'delete_posts'        => $capability,
					'delete_others_posts' => $capability,
					'read_private_posts'  => $capability,
					'edit_post'           => $capability,
					'delete_post'         => $capability,
					'read_post'           => $capability,
				),
				'capability_type'   => 'post',
				'rewrite'           => array('slug' => 'floating-widget'),
				'labels'            => $labels,
			)
		);

		register_post_type('floating_widget', $args);
	}

	public function chat_help_highlight_menu($parent_file)
	{
		global $current_screen;
		if ($current_screen && $current_screen->post_type === 'floating_widget') {
			$parent_file = 'chat-help';
		}
		return $parent_file;
	}

	public function chat_help_submenu_highlight($submenu_file)
	{
		global $current_screen;
		if ($current_screen && $current_screen->post_type === 'floating_widget') {
			$submenu_file = 'edit.php?post_type=floating_widget';
		}
		return $submenu_file;
	}

	/**
	 * Render the "Floating Chat" submenu as a collapsible group in the WordPress
	 * admin sidebar. WordPress submenus are flat, so a little scoped CSS/JS nests
	 * Global Chat / Chat Layouts / Leads under a "Floating Chat" parent. Assign
	 * Layouts is always hidden here (it's a tab on the Chat Layouts page) but stays
	 * registered so its URL keeps resolving. Mirrors the Pro plugin exactly.
	 *
	 * Hooked to admin_head. Only the initial paint happens here — the React app
	 * (Layout.jsx) owns the menu's dynamic state on every route change.
	 *
	 * @return void
	 */
	public function admin_menu_styles()
	{
?>
		<style>
			/* Parent toggle row + caret. */
			#toplevel_page_chat-help .chp-parent > a {
				position: relative;
			}
			#toplevel_page_chat-help .chp-parent > a::after {
				content: "\f345";
				font-family: dashicons;
				font-size: 13px;
				line-height: 1;
				position: absolute;
				right: 9px;
				top: 50%;
				transform: translateY(-50%) rotate(0deg);
				transition: transform .2s ease;
				opacity: .75;
			}
			#toplevel_page_chat-help .chp-parent.chp-expanded > a::after {
				transform: translateY(-50%) rotate(90deg);
			}
			/* Parent looks active (theme highlight) while a child page is open. */
			#toplevel_page_chat-help .chp-parent.chp-parent-active > a {
				color: var(--wp-admin-theme-color, #2271b1);
				font-weight: 600;
			}

			/* Children: indented under the parent. */
			#toplevel_page_chat-help .chp-child > a {
				padding-left: 28px !important;
			}
			/* Collapse only when the submenu is shown inline (menu open on a
			   plugin page). On other pages WordPress renders it as a hover
			   flyout, where every child must stay visible. */
			#toplevel_page_chat-help.wp-menu-open .chp-child {
				display: none;
			}
			#toplevel_page_chat-help.wp-menu-open .chp-child.chp-visible {
				display: list-item;
			}

			/* Folded (icon-only) sidebar: the submenu is always a hover flyout —
			   reveal every child there and drop the caret. */
			.folded #toplevel_page_chat-help .chp-child {
				display: list-item !important;
			}
			.folded #toplevel_page_chat-help .chp-parent > a::after {
				display: none;
			}

			/* Assign Layouts keeps its submenu registration (so its URL still
			   resolves) but is reached via a tab on the Chat Layouts page. */
			#toplevel_page_chat-help li:has(> a[href*="page=assign-widget"]) {
				display: none !important;
			}
		</style>

		<script>
			/*
			 * One-time structure tag + initial paint only. The React app
			 * (Layout.jsx) is the single source of truth for the menu's dynamic
			 * state (active highlight, expand/collapse) on every route change, so
			 * this runs once to avoid a flash before React mounts, then stays out
			 * of the way — no listeners, no click handling here.
			 */
			(function () {
				'use strict';
				function init() {
					var root = document.getElementById('toplevel_page_chat-help');
					if (!root) return;

					var items = Array.prototype.slice.call(
						root.querySelectorAll('ul.wp-submenu > li')
					);
					var parent = items.filter(function (li) {
						var a = li.querySelector('a');
						return a && (a.getAttribute('href') || '').indexOf('page=chat-help-floating') !== -1;
					})[0];
					if (!parent) return;

					var pIndex = items.indexOf(parent);
					var children = items.slice(pIndex + 1, pIndex + 4);
					if (!children.length) return;

					parent.classList.add('chp-parent');
					children.forEach(function (li) { li.classList.add('chp-child'); });

					// Initial expanded state from the URL hash, so a refresh /
					// direct load of a child page shows the group open immediately.
					var h = window.location.hash || '';
					var active = ['#/global', '#/widgets', '#/leads'].some(function (r) {
						return h === r || h.indexOf(r + '/') === 0;
					});
					parent.classList.toggle('chp-parent-active', active);
					parent.classList.toggle('chp-expanded', active);
					children.forEach(function (li) { li.classList.toggle('chp-visible', active); });
				}

				if (document.readyState !== 'loading') init();
				else document.addEventListener('DOMContentLoaded', init);
			}());
		</script>
<?php
	}

	// Plugin settings in plugin list
	public function chat_help_action_links(array $links)
	{
		$new_links = array(
			sprintf('<a href="%s">%s</a>', esc_url(admin_url('admin.php?page=chat-help#/global?section=general')), esc_html__('Settings', 'chat-help')),
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
	 * Admin screens that show the plugin's "rate us" footer. Every settings page
	 * redirects into the SPA (see redirect_settings_to_spa), so in practice this
	 * is the toplevel screen; the rest are kept so the footer still appears if a
	 * page is reached directly (e.g. with `?classic=1`).
	 *
	 * @var string[]
	 */
	const FOOTER_SCREENS = array(
		'toplevel_page_chat-help',
		'whatsapp-chat_page_chat-help-floating',
		'whatsapp-chat_page_chat-help-shortcode',
		'whatsapp-chat_page_chat-help-settings',
		'whatsapp-chat_page_chat-help-woo',
		'whatsapp-chat_page_chat-help-help',
	);

	/**
	 * Replace the admin footer "thank you" text with our review prompt.
	 *
	 * The text is echoed rather than returned. Other ThemeAtelier plugins hook
	 * `admin_footer_text` at this same priority and return null (their `return`
	 * is commented out), which discards whatever earlier callbacks returned — so
	 * a returned string never reaches WordPress's `echo`. Printing directly is
	 * immune to that, and is what Chat Help Pro does. We still return the
	 * (now-consumed) value as an empty string so WordPress doesn't print it twice,
	 * and pass `$text` through untouched on every other screen so we don't break
	 * anyone else's footer.
	 *
	 * @param string $text Footer text.
	 *
	 * @return string
	 */
	public function admin_footer($text)
	{
		$screen = get_current_screen();

		if (! $screen || ! in_array($screen->id, self::FOOTER_SCREENS, true)) {
			return $text;
		}

		$review = sprintf(
			/* translators: 1: start strong tag, 2: close strong tag. 3: start link 4: close link */
			__('<i>Enjoying %1$sWhatsApp Chat Help?%2$s Please rate us %3$sWordPress.org%4$s. Your positive feedback will help us grow more. Thank you! 😊</i>', 'chat-help'),
			'<strong>',
			'</strong>',
			'<span class="chat-help-footer-text-star">★★★★★</span> <a href="https://wordpress.org/support/plugin/chat-help/reviews/#new-post" target="_blank">',
			'</a>'
		);

		echo wp_kses_post($review);

		return '';
	}
}
