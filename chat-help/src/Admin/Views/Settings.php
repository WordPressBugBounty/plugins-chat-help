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

use ThemeAtelier\ChatHelp\Admin\Schema\SchemaRegistry;

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
        SchemaRegistry::createOptions($prefix, array(
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
            'framework_class'         => 'chat-help-admin ch_wooCommerce',
            'class'                    => 'chat-help-preloader',
        ));
        AdvancedControls::options($prefix);
        Analytics::options($prefix);
        Webhooks::options($prefix);
        AdditionalCssJs::options($prefix);

        // Intentionally not registered in the free plugin: there is no license to
        // activate here (and no LicenseRest controller backing the field). This is
        // the one Pro section deliberately omitted rather than shown as a locked
        // preview — an inert "License Key" box would be confusing, not a feature
        // preview. The Pro config file is kept in place so the two plugins' Views
        // directories stay in sync.
        // License::options($prefix);
    }
}
