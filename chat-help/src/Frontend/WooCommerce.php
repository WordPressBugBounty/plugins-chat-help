<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package     chat-help
 * @subpackage  chat-help/src/WooCommerce
 * @author      ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Frontend;

use ThemeAtelier\ChatHelp\Frontend\Templates\WooButton;

// don't call the file directly.
if (! defined('ABSPATH')) {
    exit;
}

/**
 * The WooCommerce class to manage all public facing stuffs.
 *
 * @since 1.0.0
 */
class WooCommerce
{
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name       The name of the plugin.
     * @param      string $version    The version of this plugin.
     */
    public function __construct()
    {
        $ch_wooCommerce = get_option('ch_wooCommerce');
        $shop_page_hide_add_to_cart_button = isset($ch_wooCommerce['shop_page_hide_add_to_cart_button']) ? $ch_wooCommerce['shop_page_hide_add_to_cart_button'] : '';
        $this->shop_page_button();
        $this->product_page_button();

        if ($shop_page_hide_add_to_cart_button) {
            add_action('wp_head', function () {
                if (is_shop() || is_product_category() || is_product_tag()) {
                    echo '<style>
                .add_to_cart_button,
                .product_type_simple,
                .product_type_variable,
                .product_type_external {
                    display:none !important;
                }
            </style>';
                }
            });
        }
    }

    public function shop_page_button()
    {
        $shopPageButton = new WooButton();
        $ch_wooCommerce = get_option('ch_wooCommerce');

        $shop_page_button = isset($ch_wooCommerce['shop_page_button']) ? $ch_wooCommerce['shop_page_button'] : '';
        $button_position = isset($ch_wooCommerce['shop_page_button_position']) ? $ch_wooCommerce['shop_page_button_position'] : 'after';
        $position = 12;
        if ("woocommerce_after_shop_loop_item" === $button_position) {
            $position = 6;
        } elseif ("woocommerce_before_shop_loop_item" === $button_position) {
            $position = 12;
        }

        $type_of_whatsapp_woo = isset($ch_wooCommerce['shop_page_button_type_of_whatsapp']) ? $ch_wooCommerce['shop_page_button_type_of_whatsapp'] : '';
        $shop_page_number = isset($ch_wooCommerce['shop_page_button_number']) ? $ch_wooCommerce['shop_page_button_number'] : '';
        $shop_page_group = isset($ch_wooCommerce['shop_page_button_group']) ? $ch_wooCommerce['shop_page_button_group'] : '';

        if ($shop_page_button) {
            if ('number' === $type_of_whatsapp_woo && !empty($shop_page_number) || ('group' === $type_of_whatsapp_woo && !empty($shop_page_group))) {
                add_action("woocommerce_after_shop_loop_item", array($shopPageButton, 'shop_page_button'), $position);
            }
        }
    }
    public function product_page_button()
    {
        $wooButton = new WooButton();
        $ch_wooCommerce = get_option('ch_wooCommerce');
        $product_page_button = isset($ch_wooCommerce['product_page_button']) ? $ch_wooCommerce['product_page_button'] : '';
        $button_position = isset($ch_wooCommerce['product_page_button_position']) ? $ch_wooCommerce['product_page_button_position'] : 'after';

        $type_of_whatsapp_woo = isset($ch_wooCommerce['product_page_button_type_of_whatsapp']) ? $ch_wooCommerce['product_page_button_type_of_whatsapp'] : '';
        $product_page_number = isset($ch_wooCommerce['product_page_button_number']) ? $ch_wooCommerce['product_page_button_number'] : '';
        $product_page_group = isset($ch_wooCommerce['product_page_button_group']) ? $ch_wooCommerce['product_page_button_group'] : '';

        if ($product_page_button) {
            if ('number' === $type_of_whatsapp_woo && !empty($product_page_number) || ('group' === $type_of_whatsapp_woo && !empty($product_page_group))) {
                add_action($button_position, array($wooButton, 'woo_button'));
            }
        }

        if ($product_page_button) {
            if ('woocommerce_short_description_after' == $button_position) {
                if ('number' === $type_of_whatsapp_woo && !empty($product_page_number) || ('group' === $type_of_whatsapp_woo && !empty($product_page_group))) {
                    add_filter('woocommerce_short_description', function ($description) use ($wooButton) {
                        ob_start();
                        $wooButton->woo_button(); // echoes
                        $button_html = ob_get_clean();
                        return $description . $button_html;
                    }, 20);
                }
            }
        }
    }
}
