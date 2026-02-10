<?php

/**
 * Views class for Shortcode generator options.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/src/Admin/Views/Settings
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Views;

use ThemeAtelier\ChatHelp\Admin\Framework\Classes\Chat_Help;
use ThemeAtelier\ChatHelp\Admin\Views\AdditionalCssJs;
use ThemeAtelier\ChatHelp\Admin\Views\AdvancedControls;
use ThemeAtelier\ChatHelp\Admin\Views\Analytics;
use ThemeAtelier\ChatHelp\Admin\Views\Webhooks;

class Settings
{

	/**
	 * Create Option fields for the setting options.
	 *
	 * @param string $prefix Option setting key prefix.
	 * @return void
	 */
	public static function options($prefix)
	{
		Chat_Help::createOptions($prefix, array(
			'menu_title'        => esc_html__('ChatHelp Settings', 'chat-help'),
			'menu_slug'         => 'chat-help-settings',
			'menu_type'               => 'submenu',
			'show_search'             => false,
			'show_bar_menu'           => false,
			'show_sub_menu'           => false,
			'show_reset_all'          => false,
			'show_footer'              => false,
			'show_all_options'          => false,
			'framework_title'   => esc_html__('ChatHelp Settings', 'chat-help'),
			'admin_bar_menu_priority' => 5,
			'footer_text'             => esc_html__('Thank you for using our product', 'chat-help'),
			'theme'                   => 'light',
			'framework_class'         => 'chat-help-setting-admin ch_wooCommerce',
			'class'                    => 'chat-help-preloader',
		));
		AdvancedControls::options($prefix);
		Analytics::options($prefix);
		Webhooks::options($prefix);
		AdditionalCssJs::options($prefix);

		// License::options($prefix);
	}
}
