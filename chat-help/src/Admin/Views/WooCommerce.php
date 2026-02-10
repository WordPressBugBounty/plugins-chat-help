<?php

/**
 * Views class for Shortcode generator options.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/src/Admin/Views/Options
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Views;

use ThemeAtelier\ChatHelp\Admin\Framework\Classes\Chat_Help;
use ThemeAtelier\ChatHelp\Admin\Views\ProductPage;
use ThemeAtelier\ChatHelp\Admin\Views\ShopPage;

class WooCommerce
{

    /**
     * Create Option fields for the setting options.
     *
     * @param string $prefix Option setting key prefix.
     * @return void
     */
    public static function options($prefix)
    {

        //
        // Create options
        //
        Chat_Help::createOptions($prefix, array(
            'menu_title'        => esc_html__('ChatHelp WooCommerce', 'chat-help'),
            'menu_slug'         => 'chat-help-woo',
            'menu_type'               => 'submenu',
            'show_search'             => false,
            'show_bar_menu'           => false,
            'show_sub_menu'           => false,
            'show_reset_all'          => false,
            'show_footer'              => false,
            'show_all_options'          => false,
            'framework_title'   => esc_html__('ChatHelp WooCommerce', 'chat-help'),
            'admin_bar_menu_priority' => 5,
            'footer_text'             => esc_html__('Thank you for using our product', 'chat-help'),
            'theme'                   => 'light',
            // 'nav'                     => 'inline',
            'framework_class'         => 'chat-help-setting-admin ch_wooCommerce',
            'class'                    => 'chat-help-preloader',
        ));
        ShopPage::options($prefix);
        ProductPage::options($prefix);

        Chat_Help::createSection(
            $prefix,
            array(
                'title' => esc_html__('Backup', 'chat-help'),
                'icon'  => 'icofont-shield',
                'fields' => array(
                    array(
                        'title'    => esc_html__('Backup', 'chat-help'),
                        'title_help' =>
                        '<div class="chat-help-info-label">' .
                            esc_html__('Export or import plugin settings for backup or migration purposes.', 'chat-help') .
                            '</div>' .
                            ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/backup/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                        'type' => 'backup',
                    ),
                )
            ),
        );
    }
}
