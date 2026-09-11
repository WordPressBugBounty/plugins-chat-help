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

use ThemeAtelier\ChatHelp\Admin\Views\ProductPage;
use ThemeAtelier\ChatHelp\Admin\Schema\SchemaRegistry;

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

        SchemaRegistry::createOptions($prefix, array(
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
            'framework_class'         => 'chat-help-admin ch_wooCommerce',
            'class'                    => 'chat-help-preloader',
        ));
        ShopPage::options($prefix);
        ProductPage::options($prefix);
        CartPage::options($prefix);
        CheckoutPage::options($prefix);
        ThankYouPage::options($prefix);
        // No Backup section here: one place moves this data now — Settings →
        // Import/Export, which carries these settings along with the chats,
        // leads and everything else, in three formats.
    }
}
