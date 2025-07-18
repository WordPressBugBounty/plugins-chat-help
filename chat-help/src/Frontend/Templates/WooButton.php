<?php

/**
 * Multi Template Class
 *
 * This class handles the multi template functionality for Chat WhatsApp .
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package    chat-help
 * @subpackage chat-help/src/Frontend
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Frontend\Templates;

use ThemeAtelier\ChatHelp\Helpers\Helpers;

/**
 * Class WooButton
 *
 * Handles the rendering of multiple templates in the plugin.
 *
 * @since 1.0.0
 */
class WooButton
{
    public static function woo_button()
    {
        $options = get_option('cwp_option');
        $wooCommerce_button_type_of_whatsapp = isset($options['wooCommerce_button_type_of_whatsapp']) ? $options['wooCommerce_button_type_of_whatsapp'] : '';
        $wooCommerce_button_number = isset($options['wooCommerce_button_number']) ? $options['wooCommerce_button_number'] : '';
        $wooCommerce_button_group = isset($options['wooCommerce_button_group']) ? $options['wooCommerce_button_group'] : '';
        $wooCommerce_button_icon = isset($options['wooCommerce_button_icon']) ? $options['wooCommerce_button_icon'] : 1;
        $wooCommerce_button_icon_open = isset($options['wooCommerce_button_icon_open']) ? $options['wooCommerce_button_icon_open'] : 'icofont-brand-whatsapp';
        $wooCommerce_button_text = isset($options['wooCommerce_button_text']) ? $options['wooCommerce_button_text'] : 'How may I help you?';
        $wooCommerce_button_visibility = isset($options['wooCommerce_button_visibility']) ? $options['wooCommerce_button_visibility'] : 'everywhere';
        $wooCommerce_button_visibility = 'wooCommerce-' . $wooCommerce_button_visibility . '-only';

        // Bubble button paddings
        $bubble_button_padding = isset($options['wooCommerce_button_padding']) ? $options['wooCommerce_button_padding'] : array();
        $bubble_button_padding_top =  isset($bubble_button_padding['top']) ? $bubble_button_padding['top'] : '5';
        $bubble_button_padding_right =  isset($bubble_button_padding['right']) ? $bubble_button_padding['right'] : '10';
        $bubble_button_padding_bottom =  isset($bubble_button_padding['bottom']) ? $bubble_button_padding['bottom'] : '5';
        $bubble_button_padding_left =  isset($bubble_button_padding['left']) ? $bubble_button_padding['left'] : '10';
        $bubble_button_padding_unit = isset($bubble_button_padding['unit']) ? $bubble_button_padding['unit'] : 'px';
        $padding = $bubble_button_padding_top . $bubble_button_padding_unit . ' ' . $bubble_button_padding_right . $bubble_button_padding_unit . ' ' . $bubble_button_padding_bottom . $bubble_button_padding_unit . ' ' . $bubble_button_padding_left . $bubble_button_padding_unit;
        // Bubble button margins
        $bubble_button_margin = isset($options['wooCommerce_button_margin']) ? $options['wooCommerce_button_margin'] : array();
        $bubble_button_margin_top =  isset($bubble_button_margin['top']) ? $bubble_button_margin['top'] : '5';
        $bubble_button_margin_right =  isset($bubble_button_margin['right']) ? $bubble_button_margin['right'] : '10';
        $bubble_button_margin_bottom =  isset($bubble_button_margin['bottom']) ? $bubble_button_margin['bottom'] : '5';
        $bubble_button_margin_left =  isset($bubble_button_margin['left']) ? $bubble_button_margin['left'] : '10';
        $bubble_button_margin_unit = isset($bubble_button_margin['unit']) ? $bubble_button_margin['unit'] : 'px';
        $margin = $bubble_button_margin_top . $bubble_button_margin_unit . ' ' . $bubble_button_margin_right . $bubble_button_margin_unit . ' ' . $bubble_button_margin_bottom . $bubble_button_margin_unit . ' ' . $bubble_button_margin_left . $bubble_button_margin_unit;
        // Bubble button border radius
        $bubble_button_border_radius = isset($options['wooCommerce_button_border_radius']) ? $options['wooCommerce_button_border_radius'] : array();
        $bubble_button_border_radius_top =  isset($bubble_button_border_radius['top']) ? $bubble_button_border_radius['top'] : '5';
        $bubble_button_border_radius_right =  isset($bubble_button_border_radius['right']) ? $bubble_button_border_radius['right'] : '10';
        $bubble_button_border_radius_bottom =  isset($bubble_button_border_radius['bottom']) ? $bubble_button_border_radius['bottom'] : '5';
        $bubble_button_border_radius_left =  isset($bubble_button_border_radius['left']) ? $bubble_button_border_radius['left'] : '10';
        $bubble_button_border_radius_unit = isset($bubble_button_border_radius['unit']) ? $bubble_button_border_radius['unit'] : 'px';
        $border_radius = $bubble_button_border_radius_top . $bubble_button_border_radius_unit . ' ' . $bubble_button_border_radius_right . $bubble_button_border_radius_unit . ' ' . $bubble_button_border_radius_bottom . $bubble_button_border_radius_unit . ' ' . $bubble_button_border_radius_left . $bubble_button_border_radius_unit;

        global $product;
        if (! $product || ! is_a($product, 'WC_Product')) {
            return false;
        }

        $productName = $product->get_name();
        $productSku = $product->get_sku();
        $productSlug = $product->get_slug();
        $productPrice = $product->get_price();
        $productRegularPrice = $product->get_regular_price();
        $productSalePrice = $product->get_sale_price();
        $productStockStatus = $product->get_stock_status();
        $ip = esc_sql(sanitize_text_field($_SERVER['REMOTE_ADDR']));
        $siteURL = get_site_url();

        $variables = array('{siteURL}', '{productName}', '{productSlug}', '{productSku}', '{productPrice}', '{productRegularPrice}', '{productSalePrice}', '{productStockStatus}', '{ip}');
        $values = array($siteURL, $productName, $productSlug, $productSku, $productPrice, $productRegularPrice, $productSalePrice, $productStockStatus, $ip);
        $message = trim(str_replace($variables, $values, isset($options['wooCommerce_button_message']) ? $options['wooCommerce_button_message'] : ''));

        $url_for_desktop = isset($options['url_for_desktop']) ? $options['url_for_desktop'] : '';
        $url_for_mobile = isset($options['url_for_mobile']) ? $options['url_for_mobile'] : '';
        $url = Helpers::whatsAppUrl($wooCommerce_button_number, $wooCommerce_button_type_of_whatsapp, $wooCommerce_button_group, $url_for_desktop, $url_for_mobile, $message);
        $open_in_new_tab = isset($options['open_in_new_tab']) ? $options['open_in_new_tab'] : '';
        $open_in_new_tab = $open_in_new_tab ? '_blank' : '_self';

        echo '<a style="--padding: ' . esc_attr($padding) . '; --radius: ' . esc_attr($border_radius) . ';--margin: ' . esc_attr($margin) . ';" target="' . esc_attr($open_in_new_tab) . '" href="' . esc_url($url) . '" class="bubble wHelp-btn-bg wooCommerce_button ' . esc_attr($wooCommerce_button_visibility) . '">';
        if ($wooCommerce_button_icon) {
            echo '<i class="' . esc_attr($wooCommerce_button_icon_open) . '"></i>';
        }
        echo esc_html($wooCommerce_button_text);
        echo '</a>';
    }
}
