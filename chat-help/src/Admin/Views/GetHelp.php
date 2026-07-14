<?php

/**
 * Views class for Shortcode generator options.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/src/Admin/Views/Advance
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Views;

use ThemeAtelier\ChatHelp\Admin\Schema\SchemaRegistry;

class GetHelp
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
            'menu_title'              => esc_html__('ChatHelp Help', 'chat-help'),
            'menu_slug'               => 'chat-help-help',
            'menu_type'               => 'submenu',
            'show_search'             => false,
            'show_bar_menu'           => false,
            'show_sub_menu'           => false,
            'show_reset_all'          => false,
            'show_save_button'          => false,
            'show_reset_section'          => false,
            'show_footer'             => false,
            'show_all_options'        => false,
            'framework_title'         => esc_html__('ChatHelp Help', 'chat-help'),
            'admin_bar_menu_priority' => 5,
            'footer_text'             => esc_html__('Thank you for using our product', 'chat-help'),
            'theme'                   => 'light',
            'nav'                     => 'inline',
            'framework_class'         => 'chat-help-admin chat-help-help-page',
            'class'                   => 'chat-help-preloader',
        ));
        SchemaRegistry::createSection($prefix, array(
            'title'       => esc_html__('GET HELP', 'chat-help'),
            'icon'        => 'icofont-life-buoy',

            'fields'      => array(
                array(
                    'id'   => 'ta_help',
                    'type' => 'ta_help',
                ),
            )
        ));
    }
}
