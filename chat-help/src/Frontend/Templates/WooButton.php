<?php

/**
 * Multi Template Class
 *
 * This class handles the multi template functionality for Chat WhatsApp Pro.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package    chat-help
 * @subpackage chat-help/src/Frontend
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Frontend\Templates;

use ThemeAtelier\ChatHelp\Frontend\Helpers\Helpers;

// don't call the file directly.
if (! defined('ABSPATH')) {
    exit;
}

/**
 * Class WooButton
 *
 * Handles the rendering of multiple templates in the plugin.
 *
 * @since 1.0.0
 */
class WooButton
{
    /**
     * Whether the checkout live-shipping script has been queued this request.
     *
     * @var bool
     */
    protected static $checkout_shipping_script_added = false;

    public static function woo_button()
    {
        // The Product Page button must only ever render on a single product
        // page. It attaches to hooks/filters such as woocommerce_short_description
        // which are also applied while the cart and other pages render product
        // data — without this guard the button leaks onto those pages (e.g. once
        // per cart line item).
        if (function_exists('is_product') && ! is_product()) {
            return;
        }

        $options = get_option('cwp_option');
        $ch_wooCommerce = get_option('ch_wooCommerce');
        $ch_settings = get_option('ch_settings');
        $product_page_button_type_of_whatsapp = isset($ch_wooCommerce['product_page_button_type_of_whatsapp']) ? $ch_wooCommerce['product_page_button_type_of_whatsapp'] : '';
        $product_page_button_number = isset($ch_wooCommerce['product_page_button_number']) ? $ch_wooCommerce['product_page_button_number'] : '';
        $product_page_button_group = isset($ch_wooCommerce['product_page_button_group']) ? $ch_wooCommerce['product_page_button_group'] : '';
        // Empty fields inherit the Global Chat number/group (live fallback).
        $global_whatsapp = Helpers::global_whatsapp_defaults();
        $product_page_button_number = trim((string) $product_page_button_number) !== '' ? $product_page_button_number : $global_whatsapp['number'];
        $product_page_button_group = trim((string) $product_page_button_group) !== '' ? $product_page_button_group : $global_whatsapp['group'];
        $product_page_circle_button_icon = isset($ch_wooCommerce['product_page_circle_button_icon']) ? $ch_wooCommerce['product_page_circle_button_icon'] : 'icofont-brand-whatsapp';
        $product_page_button_icon_open = !empty($ch_wooCommerce['product_page_button_icon_open']) ? $ch_wooCommerce['product_page_button_icon_open'] : 'icofont-brand-whatsapp';

        $product_page_button_text = isset($ch_wooCommerce['product_page_button_text']) ? $ch_wooCommerce['product_page_button_text'] : 'How may I help you?';
        $product_page_button_size = isset($ch_wooCommerce['product_page_button_size']) ? $ch_wooCommerce['product_page_button_size'] : '1';
        $product_page_button_visibility = isset($ch_wooCommerce['product_page_button_visibility']) ? $ch_wooCommerce['product_page_button_visibility'] : 'everywhere';
        $product_page_button_visibility = 'wooCommerce-' . $product_page_button_visibility . '-only';
        $product_page_button_style = isset($ch_wooCommerce['product_page_button_style']) ? $ch_wooCommerce['product_page_button_style'] : '2';
        $color_settings = !empty($options['color_settings']) ? $options['color_settings'] : array();
        $color_primary = !empty($color_settings['primary']) ? $color_settings['primary'] : '#118c7e';
        $color_secondary = !empty($color_settings['secondary']) ? $color_settings['secondary'] : '#0b5a51';

        $button_bg = !empty($ch_wooCommerce['product_page_button_bg']) ? $ch_wooCommerce['product_page_button_bg'] : array();
        $bg_color = !empty($button_bg['normal_color']) ? $button_bg['normal_color'] : '#118c7e';
        $bg_hover_color = !empty($button_bg['hover_color']) ? $button_bg['hover_color'] : '#0b5a51';

        $button_text = !empty($ch_wooCommerce['product_page_button_text_color']) ? $ch_wooCommerce['product_page_button_text_color'] : array();
        $text_color = !empty($button_text['normal_color']) ? $button_text['normal_color'] : '#ffffff';
        $text_hover_color = !empty($button_text['hover_color']) ? $button_text['hover_color'] : '#ffffff';

        $product_page_icon_bg_color = !empty($ch_wooCommerce['product_page_icon_bg_color']) ? $ch_wooCommerce['product_page_icon_bg_color'] : array();
        $normal_bg_color = !empty($product_page_icon_bg_color['normal_color']) ? $product_page_icon_bg_color['normal_color'] : '#ffffff';
        $hover_bg_color = !empty($product_page_icon_bg_color['hover_color']) ? $product_page_icon_bg_color['hover_color'] : '#ffffff';
        $icon_bg = !empty($ch_wooCommerce['product_page_icon_bg']) ? 'icon_bg' : '';
        $product_page_icon_color = !empty($ch_wooCommerce['product_page_icon_color']) ? $ch_wooCommerce['product_page_icon_color'] : array();

        if ($product_page_button_style == '2' && $icon_bg === 'icon_bg') {
            $normal_icon_color = !empty($product_page_icon_color['normal_color']) ? $product_page_icon_color['normal_color'] : $bg_color;
            $hover_icon_color = !empty($product_page_icon_color['hover_color']) ? $product_page_icon_color['hover_color'] : $bg_hover_color;
        } else {
            $normal_icon_color = !empty($product_page_icon_color['normal_color']) ? $product_page_icon_color['normal_color'] : '#ffffff';
            $hover_icon_color = !empty($product_page_icon_color['hover_color']) ? $product_page_icon_color['hover_color'] : '#ffffff';
        }

        $url_for_desktop = isset($ch_settings['url_for_desktop']) ? $ch_settings['url_for_desktop'] : '';
        $url_for_mobile = isset($ch_settings['url_for_mobile']) ? $ch_settings['url_for_mobile'] : '';

        $product_page_button_border = isset($ch_wooCommerce['product_page_button_border']) ? $ch_wooCommerce['product_page_button_border'] : array();
        $border_all = isset($product_page_button_border['all']) ? $product_page_button_border['all'] . 'px' : '0px';
        $border_style = isset($product_page_button_border['style']) ? $product_page_button_border['style'] : 'solid';
        $border_radius = isset($product_page_button_border['border_radius']) ? $product_page_button_border['border_radius'] . 'px' : '50px';
        $border_color = isset($product_page_button_border['color']) ? $product_page_button_border['color'] : '';
        $border_color = !empty($border_color) ? $border_color : $color_primary;
        $hover_border_color = isset($product_page_button_border['hover_color']) ? $product_page_button_border['hover_color'] : '';
        $hover_border_color = !empty($hover_border_color) ? $hover_border_color : $color_secondary;

        $product_page_icon_border = isset($ch_wooCommerce['product_page_icon_border']) ? $ch_wooCommerce['product_page_icon_border'] : array();
        $icon_border_all = isset($product_page_icon_border['all']) ? $product_page_icon_border['all'] . 'px' : '0px';
        $icon_border_style = isset($product_page_icon_border['style']) ? $product_page_icon_border['style'] : 'solid';
        $icon_border_radius = isset($product_page_icon_border['border_radius']) ? $product_page_icon_border['border_radius'] . 'px' : '50px';
        $icon_border_color = isset($product_page_icon_border['color']) ? $product_page_icon_border['color'] : '';
        $icon_border_color = !empty($icon_border_color) ? $icon_border_color : $color_primary;
        $hover_icon_border_color = isset($product_page_icon_border['hover_color']) ? $product_page_icon_border['hover_color'] : '';
        $hover_icon_border_color = !empty($hover_icon_border_color) ? $hover_icon_border_color : $color_secondary;

        // Bubble button paddings
        $product_page_button_padding = isset($ch_wooCommerce['product_page_button_padding']) ? $ch_wooCommerce['product_page_button_padding'] : array();
        $product_page_button_padding_top =  isset($product_page_button_padding['top']) ? $product_page_button_padding['top'] : '5';
        $product_page_button_padding_right =  isset($product_page_button_padding['right']) ? $product_page_button_padding['right'] : '15';
        $product_page_button_padding_bottom =  isset($product_page_button_padding['bottom']) ? $product_page_button_padding['bottom'] : '5';
        $product_page_button_padding_left =  isset($product_page_button_padding['left']) ? $product_page_button_padding['left'] : '6';
        $product_page_button_padding_unit = isset($product_page_button_padding['unit']) ? $product_page_button_padding['unit'] : 'px';

        $padding = $product_page_button_padding_top . $product_page_button_padding_unit . ' ' . $product_page_button_padding_right . $product_page_button_padding_unit . ' ' . $product_page_button_padding_bottom . $product_page_button_padding_unit . ' ' . $product_page_button_padding_left . $product_page_button_padding_unit;
        // Bubble button margins
        $product_page_button_margin = isset($ch_wooCommerce['product_page_button_margin']) ? $ch_wooCommerce['product_page_button_margin'] : array();
        $product_page_button_margin_top =  isset($product_page_button_margin['top']) ? $product_page_button_margin['top'] : '5';
        $product_page_button_margin_right =  isset($product_page_button_margin['right']) ? $product_page_button_margin['right'] : '15';
        $product_page_button_margin_bottom =  isset($product_page_button_margin['bottom']) ? $product_page_button_margin['bottom'] : '5';
        $product_page_button_margin_left =  isset($product_page_button_margin['left']) ? $product_page_button_margin['left'] : '6';
        $product_page_button_margin_unit = isset($product_page_button_margin['unit']) ? $product_page_button_margin['unit'] : 'px';

        $margin = $product_page_button_margin_top . $product_page_button_margin_unit . ' ' . $product_page_button_margin_right . $product_page_button_margin_unit . ' ' . $product_page_button_margin_bottom . $product_page_button_margin_unit . ' ' . $product_page_button_margin_left . $product_page_button_margin_unit;

        $message = isset($ch_wooCommerce['product_page_button_message']) ? $ch_wooCommerce['product_page_button_message'] : '';
        $message = Helpers::replacement_vars($message);

        $url = Helpers::whatsAppUrl($product_page_button_number, $product_page_button_type_of_whatsapp, $product_page_button_group, $url_for_desktop, $url_for_mobile, $message);
        $open_in_new_tab = isset($ch_settings['open_in_new_tab']) ? $ch_settings['open_in_new_tab'] : '';
        $open_in_new_tab = $open_in_new_tab ? '_blank' : '_self';

        if ($product_page_button_type_of_whatsapp === 'group') {
            $gaAnalyticsAttr = 'data-group=' . $product_page_button_group . '';
        } else {
            $gaAnalyticsAttr = 'data-number=' . $product_page_button_number . '';
        }

        if (!empty($product_page_circle_button_icon)) {
            $circle_icon = '<i class="' . esc_attr($product_page_circle_button_icon) . '"></i>';
        } else {
            $circle_icon = '<i class="icofont-brand-whatsapp"></i>';
        }

        if (!empty($product_page_button_icon_open)) {
            $woo_button_icon = '<i class="' . esc_attr($product_page_button_icon_open) . '"></i>';
        } else {
            $woo_button_icon = '<i class="icofont-brand-whatsapp"></i>';
        }

        if ($product_page_button_style === '1') {
            echo '<a style="--wHelp-btn-scale: ' . esc_attr($product_page_button_size) . '; --wHelp-margin: ' . esc_attr($margin) . '; --wHelp-border: ' . esc_attr($border_all . ' ' . $border_style) . '; --wHelp-border-radius: ' . esc_attr($border_radius) . ';--wHelp-background: ' . esc_attr($bg_color) . '; --wHelp-hover-background: ' . esc_attr($bg_hover_color) . ';--wHelp-icon-normal-color: ' . esc_attr($normal_icon_color) . '; --wHelp-icon-hover-color: ' . esc_attr($hover_icon_color) . '; --wHelp-border-color: ' . esc_attr($border_color) . '; --wHelp-border-hover-color: ' . esc_attr($hover_border_color) . ';" target="' . esc_attr($open_in_new_tab) . '" href="' . esc_attr($url) . '" ' . esc_attr($gaAnalyticsAttr) . ' class="wHelp_button chat_help_analytics product_page_button circle-bubble ' . esc_attr($product_page_button_visibility) . '">';
            if ($circle_icon) {
                echo wp_kses_post($circle_icon);
            }
            echo '</a>';
        } else {
            echo '<a style="--wHelp-padding: ' . esc_attr($padding) . '; --wHelp-btn-scale: ' . esc_attr($product_page_button_size) . '; --wHelp-margin: ' . esc_attr($margin) . '; --wHelp-border: ' . esc_attr($border_all . ' ' . $border_style) . '; --wHelp-border-radius: ' . esc_attr($border_radius) . ';--wHelp-background: ' . esc_attr($bg_color) . '; --wHelp-hover-background: ' . esc_attr($bg_hover_color) . '; --wHelp-icon-normal-color: ' . esc_attr($normal_icon_color) . '; --wHelp-icon-hover-color: ' . esc_attr($hover_icon_color) . '; --wHelp-icon-normal-bg-color: ' . esc_attr($normal_bg_color) . '; --wHelp-icon-hover-bg-color: ' . esc_attr($hover_bg_color) . '; --wHelp-border-color: ' . esc_attr($border_color) . '; --wHelp-border-hover-color: ' . esc_attr($hover_border_color) . '; --wHelp-text-color: ' . esc_attr($text_color) . '; --wHelp-text-hover-color: ' . esc_attr($text_hover_color) . '; --wHelp-icon-border: ' . esc_attr($icon_border_all . ' ' . $icon_border_style) . '; --wHelp-icon-border-color: ' . esc_attr($icon_border_color) . '; --wHelp-hover-icon-border-color: ' . esc_attr($hover_icon_border_color) . '; --wHelp-icon-border-radius: ' . esc_attr($icon_border_radius) . ';" target="' . esc_attr($open_in_new_tab) . '" href="' . esc_attr($url) . '" ' . esc_attr($gaAnalyticsAttr) . ' class="wHelp_button chat_help_analytics product_page_button ' . esc_attr($product_page_button_visibility) . '">';
            if ($product_page_button_icon_open !== 'no_icon' && $woo_button_icon) {
                echo '<span class="bubble__icon ' . esc_attr($icon_bg) . '">';
                echo wp_kses_post($woo_button_icon);
                echo '</span>';
            }
            echo esc_html($product_page_button_text);
            echo '</a>';
        }
    }
    public static function shop_page_button()
    {
        $options = get_option('cwp_option');
        $ch_wooCommerce = get_option('ch_wooCommerce');
        $ch_settings = get_option('ch_settings');
        $shop_page_button_type_of_whatsapp = isset($ch_wooCommerce['shop_page_button_type_of_whatsapp']) ? $ch_wooCommerce['shop_page_button_type_of_whatsapp'] : '';
        $shop_page_button_number = isset($ch_wooCommerce['shop_page_button_number']) ? $ch_wooCommerce['shop_page_button_number'] : '';
        $shop_page_button_group = isset($ch_wooCommerce['shop_page_button_group']) ? $ch_wooCommerce['shop_page_button_group'] : '';
        // Empty fields inherit the Global Chat number/group (live fallback).
        $global_whatsapp = Helpers::global_whatsapp_defaults();
        $shop_page_button_number = trim((string) $shop_page_button_number) !== '' ? $shop_page_button_number : $global_whatsapp['number'];
        $shop_page_button_group = trim((string) $shop_page_button_group) !== '' ? $shop_page_button_group : $global_whatsapp['group'];
        $shop_page_circle_button_icon = isset($ch_wooCommerce['shop_page_circle_button_icon']) ? $ch_wooCommerce['shop_page_circle_button_icon'] : 'icofont-brand-whatsapp';
        $shop_page_button_icon_open = !empty($ch_wooCommerce['shop_page_button_icon_open']) ? $ch_wooCommerce['shop_page_button_icon_open'] : 'icofont-brand-whatsapp';

        $shop_page_button_text = isset($ch_wooCommerce['shop_page_button_text']) ? $ch_wooCommerce['shop_page_button_text'] : 'How may I help you?';
        $shop_page_button_size = isset($ch_wooCommerce['shop_page_button_size']) ? $ch_wooCommerce['shop_page_button_size'] : '1';
        $shop_page_button_visibility = isset($ch_wooCommerce['shop_page_button_visibility']) ? $ch_wooCommerce['shop_page_button_visibility'] : 'everywhere';
        $shop_page_button_visibility = 'wooCommerce-' . $shop_page_button_visibility . '-only';
        $shop_page_button_style = isset($ch_wooCommerce['shop_page_button_style']) ? $ch_wooCommerce['shop_page_button_style'] : '2';
        $color_settings = !empty($options['color_settings']) ? $options['color_settings'] : array();
        $color_primary = !empty($color_settings['primary']) ? $color_settings['primary'] : '#118c7e';
        $color_secondary = !empty($color_settings['secondary']) ? $color_settings['secondary'] : '#0b5a51';

        $button_bg = !empty($ch_wooCommerce['shop_page_button_bg']) ? $ch_wooCommerce['shop_page_button_bg'] : array();
        $bg_color = !empty($button_bg['normal_color']) ? $button_bg['normal_color'] : '#118c7e';
        $bg_hover_color = !empty($button_bg['hover_color']) ? $button_bg['hover_color'] : '#0b5a51';

        $button_text = !empty($ch_wooCommerce['shop_page_button_text_color']) ? $ch_wooCommerce['shop_page_button_text_color'] : array();
        $text_color = !empty($button_text['normal_color']) ? $button_text['normal_color'] : '#ffffff';
        $text_hover_color = !empty($button_text['hover_color']) ? $button_text['hover_color'] : '#ffffff';

        $shop_page_icon_bg_color = !empty($ch_wooCommerce['shop_page_icon_bg_color']) ? $ch_wooCommerce['shop_page_icon_bg_color'] : array();
        $normal_bg_color = !empty($shop_page_icon_bg_color['normal_color']) ? $shop_page_icon_bg_color['normal_color'] : '#ffffff';
        $hover_bg_color = !empty($shop_page_icon_bg_color['hover_color']) ? $shop_page_icon_bg_color['hover_color'] : '#ffffff';
        $icon_bg = !empty($ch_wooCommerce['shop_page_icon_bg']) ? 'icon_bg' : '';
        $shop_page_icon_color = !empty($ch_wooCommerce['shop_page_icon_color']) ? $ch_wooCommerce['shop_page_icon_color'] : array();

        if ($shop_page_button_style == '2' && $icon_bg === 'icon_bg') {
            $normal_icon_color = !empty($shop_page_icon_color['normal_color']) ? $shop_page_icon_color['normal_color'] : $bg_color;
            $hover_icon_color = !empty($shop_page_icon_color['hover_color']) ? $shop_page_icon_color['hover_color'] : $bg_hover_color;
        } else {
            $normal_icon_color = !empty($shop_page_icon_color['normal_color']) ? $shop_page_icon_color['normal_color'] : '#ffffff';
            $hover_icon_color = !empty($shop_page_icon_color['hover_color']) ? $shop_page_icon_color['hover_color'] : '#ffffff';
        }

        $url_for_desktop = isset($ch_settings['url_for_desktop']) ? $ch_settings['url_for_desktop'] : '';
        $url_for_mobile = isset($ch_settings['url_for_mobile']) ? $ch_settings['url_for_mobile'] : '';

        $shop_page_button_border = isset($ch_wooCommerce['shop_page_button_border']) ? $ch_wooCommerce['shop_page_button_border'] : array();
        $border_all = isset($shop_page_button_border['all']) ? $shop_page_button_border['all'] . 'px' : '0px';
        $border_style = isset($shop_page_button_border['style']) ? $shop_page_button_border['style'] : 'solid';
        $border_radius = isset($shop_page_button_border['border_radius']) ? $shop_page_button_border['border_radius'] . 'px' : '50px';
        $border_color = isset($shop_page_button_border['color']) ? $shop_page_button_border['color'] : '';
        $border_color = !empty($border_color) ? $border_color : $color_primary;
        $hover_border_color = isset($shop_page_button_border['hover_color']) ? $shop_page_button_border['hover_color'] : '';
        $hover_border_color = !empty($hover_border_color) ? $hover_border_color : $color_secondary;

        $shop_page_icon_border = isset($ch_wooCommerce['shop_page_icon_border']) ? $ch_wooCommerce['shop_page_icon_border'] : array();
        $icon_border_all = isset($shop_page_icon_border['all']) ? $shop_page_icon_border['all'] . 'px' : '0px';
        $icon_border_style = isset($shop_page_icon_border['style']) ? $shop_page_icon_border['style'] : 'solid';
        $icon_border_radius = isset($shop_page_icon_border['border_radius']) ? $shop_page_icon_border['border_radius'] . 'px' : '50px';
        $icon_border_color = isset($shop_page_icon_border['color']) ? $shop_page_icon_border['color'] : '';
        $icon_border_color = !empty($icon_border_color) ? $icon_border_color : $color_primary;
        $hover_icon_border_color = isset($shop_page_icon_border['hover_color']) ? $shop_page_icon_border['hover_color'] : '';
        $hover_icon_border_color = !empty($hover_icon_border_color) ? $hover_icon_border_color : $color_secondary;

        // Bubble button paddings
        $shop_page_button_padding = isset($ch_wooCommerce['shop_page_button_padding']) ? $ch_wooCommerce['shop_page_button_padding'] : array();
        $shop_page_button_padding_top =  isset($shop_page_button_padding['top']) ? $shop_page_button_padding['top'] : '5';
        $shop_page_button_padding_right =  isset($shop_page_button_padding['right']) ? $shop_page_button_padding['right'] : '15';
        $shop_page_button_padding_bottom =  isset($shop_page_button_padding['bottom']) ? $shop_page_button_padding['bottom'] : '5';
        $shop_page_button_padding_left =  isset($shop_page_button_padding['left']) ? $shop_page_button_padding['left'] : '6';
        $shop_page_button_padding_unit = isset($shop_page_button_padding['unit']) ? $shop_page_button_padding['unit'] : 'px';

        $padding = $shop_page_button_padding_top . $shop_page_button_padding_unit . ' ' . $shop_page_button_padding_right . $shop_page_button_padding_unit . ' ' . $shop_page_button_padding_bottom . $shop_page_button_padding_unit . ' ' . $shop_page_button_padding_left . $shop_page_button_padding_unit;
        // Bubble button margins
        $shop_page_button_margin = isset($ch_wooCommerce['shop_page_button_margin']) ? $ch_wooCommerce['shop_page_button_margin'] : array();
        $shop_page_button_margin_top =  isset($shop_page_button_margin['top']) ? $shop_page_button_margin['top'] : '5';
        $shop_page_button_margin_right =  isset($shop_page_button_margin['right']) ? $shop_page_button_margin['right'] : '15';
        $shop_page_button_margin_bottom =  isset($shop_page_button_margin['bottom']) ? $shop_page_button_margin['bottom'] : '5';
        $shop_page_button_margin_left =  isset($shop_page_button_margin['left']) ? $shop_page_button_margin['left'] : '6';
        $shop_page_button_margin_unit = isset($shop_page_button_margin['unit']) ? $shop_page_button_margin['unit'] : 'px';

        $margin = $shop_page_button_margin_top . $shop_page_button_margin_unit . ' ' . $shop_page_button_margin_right . $shop_page_button_margin_unit . ' ' . $shop_page_button_margin_bottom . $shop_page_button_margin_unit . ' ' . $shop_page_button_margin_left . $shop_page_button_margin_unit;

        $message = isset($ch_wooCommerce['shop_page_button_message']) ? $ch_wooCommerce['shop_page_button_message'] : '';
        $message = Helpers::replacement_vars($message);

        $url = Helpers::whatsAppUrl($shop_page_button_number, $shop_page_button_type_of_whatsapp, $shop_page_button_group, $url_for_desktop, $url_for_mobile, $message);
        $open_in_new_tab = isset($ch_settings['open_in_new_tab']) ? $ch_settings['open_in_new_tab'] : '';
        $open_in_new_tab = $open_in_new_tab ? '_blank' : '_self';

        if ($shop_page_button_type_of_whatsapp === 'group') {
            $gaAnalyticsAttr = 'data-group=' . $shop_page_button_group . '';
        } else {
            $gaAnalyticsAttr = 'data-number=' . $shop_page_button_number . '';
        }

        if (!empty($shop_page_circle_button_icon)) {
            $circle_icon = '<i class="' . esc_attr($shop_page_circle_button_icon) . '"></i>';
        } else {
            $circle_icon = '<i class="icofont-brand-whatsapp"></i>';
        }

        if (!empty($shop_page_button_icon_open)) {
            $woo_button_icon = '<i class="' . esc_attr($shop_page_button_icon_open) . '"></i>';
        } else {
            $woo_button_icon = '<i class="icofont-brand-whatsapp"></i>';
        }

        if ($shop_page_button_style === '1') {
            echo '<a style="--wHelp-btn-scale: ' . esc_attr($shop_page_button_size) . '; --wHelp-margin: ' . esc_attr($margin) . '; --wHelp-border: ' . esc_attr($border_all . ' ' . $border_style) . '; --wHelp-border-radius: ' . esc_attr($border_radius) . ';--wHelp-background: ' . esc_attr($bg_color) . '; --wHelp-hover-background: ' . esc_attr($bg_hover_color) . ';--wHelp-icon-normal-color: ' . esc_attr($normal_icon_color) . '; --wHelp-icon-hover-color: ' . esc_attr($hover_icon_color) . '; --wHelp-border-color: ' . esc_attr($border_color) . '; --wHelp-border-hover-color: ' . esc_attr($hover_border_color) . ';" target="' . esc_attr($open_in_new_tab) . '" href="' . esc_attr($url) . '" ' . esc_attr($gaAnalyticsAttr) . ' class="wHelp_button chat_help_analytics shop_page_button circle-bubble ' . esc_attr($shop_page_button_visibility) . '">';
            if ($circle_icon) {
                echo wp_kses_post($circle_icon);
            }
            echo '</a>';
        } else {
            echo '<a style="--wHelp-padding: ' . esc_attr($padding) . '; --wHelp-btn-scale: ' . esc_attr($shop_page_button_size) . '; --wHelp-margin: ' . esc_attr($margin) . '; --wHelp-border: ' . esc_attr($border_all . ' ' . $border_style) . '; --wHelp-border-radius: ' . esc_attr($border_radius) . ';--wHelp-background: ' . esc_attr($bg_color) . '; --wHelp-hover-background: ' . esc_attr($bg_hover_color) . '; --wHelp-icon-normal-color: ' . esc_attr($normal_icon_color) . '; --wHelp-icon-hover-color: ' . esc_attr($hover_icon_color) . '; --wHelp-icon-normal-bg-color: ' . esc_attr($normal_bg_color) . '; --wHelp-icon-hover-bg-color: ' . esc_attr($hover_bg_color) . '; --wHelp-border-color: ' . esc_attr($border_color) . '; --wHelp-border-hover-color: ' . esc_attr($hover_border_color) . '; --wHelp-text-color: ' . esc_attr($text_color) . '; --wHelp-text-hover-color: ' . esc_attr($text_hover_color) . '; --wHelp-icon-border: ' . esc_attr($icon_border_all . ' ' . $icon_border_style) . '; --wHelp-icon-border-color: ' . esc_attr($icon_border_color) . '; --wHelp-hover-icon-border-color: ' . esc_attr($hover_icon_border_color) . '; --wHelp-icon-border-radius: ' . esc_attr($icon_border_radius) . ';" target="' . esc_attr($open_in_new_tab) . '" href="' . esc_attr($url) . '" ' . esc_attr($gaAnalyticsAttr) . ' class="wHelp_button chat_help_analytics shop_page_button ' . esc_attr($shop_page_button_visibility) . '">';
            if ($shop_page_button_icon_open !== 'no_icon' && $woo_button_icon) {
                echo '<span class="bubble__icon ' . esc_attr($icon_bg) . '">';
                echo wp_kses_post($woo_button_icon);
                echo '</span>';
            }
            echo esc_html($shop_page_button_text);
            echo '</a>';
        }
    }
    public static function cart_page_button()
    {
        $options = get_option('cwp_option');
        $ch_wooCommerce = get_option('ch_wooCommerce');

        $cart_page_include_with_cart_info = isset($ch_wooCommerce['cart_page_include_with_cart_info']) ? $ch_wooCommerce['cart_page_include_with_cart_info'] : array();
        $ch_settings = get_option('ch_settings');
        $cart_page_button_type_of_whatsapp = isset($ch_wooCommerce['cart_page_button_type_of_whatsapp']) ? $ch_wooCommerce['cart_page_button_type_of_whatsapp'] : '';
        $cart_page_button_number = isset($ch_wooCommerce['cart_page_button_number']) ? $ch_wooCommerce['cart_page_button_number'] : '';
        $cart_page_button_group = isset($ch_wooCommerce['cart_page_button_group']) ? $ch_wooCommerce['cart_page_button_group'] : '';
        // Empty fields inherit the Global Chat number/group (live fallback).
        $global_whatsapp = Helpers::global_whatsapp_defaults();
        $cart_page_button_number = trim((string) $cart_page_button_number) !== '' ? $cart_page_button_number : $global_whatsapp['number'];
        $cart_page_button_group = trim((string) $cart_page_button_group) !== '' ? $cart_page_button_group : $global_whatsapp['group'];
        $cart_page_circle_button_icon = isset($ch_wooCommerce['cart_page_circle_button_icon']) ? $ch_wooCommerce['cart_page_circle_button_icon'] : 'icofont-brand-whatsapp';
        $cart_page_button_icon_open = !empty($ch_wooCommerce['cart_page_button_icon_open']) ? $ch_wooCommerce['cart_page_button_icon_open'] : 'icofont-brand-whatsapp';

        $cart_page_button_text = isset($ch_wooCommerce['cart_page_button_text']) ? $ch_wooCommerce['cart_page_button_text'] : 'How may I help you?';
        $cart_page_button_size = isset($ch_wooCommerce['cart_page_button_size']) ? $ch_wooCommerce['cart_page_button_size'] : '1';
        $cart_page_button_visibility = isset($ch_wooCommerce['cart_page_button_visibility']) ? $ch_wooCommerce['cart_page_button_visibility'] : 'everywhere';
        $cart_page_button_visibility = 'wooCommerce-' . $cart_page_button_visibility . '-only';
        $cart_page_button_style = isset($ch_wooCommerce['cart_page_button_style']) ? $ch_wooCommerce['cart_page_button_style'] : '2';
        $color_settings = !empty($options['color_settings']) ? $options['color_settings'] : array();
        $color_primary = !empty($color_settings['primary']) ? $color_settings['primary'] : '#118c7e';
        $color_secondary = !empty($color_settings['secondary']) ? $color_settings['secondary'] : '#0b5a51';

        $button_bg = !empty($ch_wooCommerce['cart_page_button_bg']) ? $ch_wooCommerce['cart_page_button_bg'] : array();
        $bg_color = !empty($button_bg['normal_color']) ? $button_bg['normal_color'] : '#118c7e';
        $bg_hover_color = !empty($button_bg['hover_color']) ? $button_bg['hover_color'] : '#0b5a51';

        $button_text = !empty($ch_wooCommerce['cart_page_button_text_color']) ? $ch_wooCommerce['cart_page_button_text_color'] : array();
        $text_color = !empty($button_text['normal_color']) ? $button_text['normal_color'] : '#ffffff';
        $text_hover_color = !empty($button_text['hover_color']) ? $button_text['hover_color'] : '#ffffff';

        $cart_page_icon_bg_color = !empty($ch_wooCommerce['cart_page_icon_bg_color']) ? $ch_wooCommerce['cart_page_icon_bg_color'] : array();
        $normal_bg_color = !empty($cart_page_icon_bg_color['normal_color']) ? $cart_page_icon_bg_color['normal_color'] : '#ffffff';
        $hover_bg_color = !empty($cart_page_icon_bg_color['hover_color']) ? $cart_page_icon_bg_color['hover_color'] : '#ffffff';
        $icon_bg = !empty($ch_wooCommerce['cart_page_icon_bg']) ? 'icon_bg' : '';
        $cart_page_icon_color = !empty($ch_wooCommerce['cart_page_icon_color']) ? $ch_wooCommerce['cart_page_icon_color'] : array();

        if ($cart_page_button_style == '2' && $icon_bg === 'icon_bg') {
            $normal_icon_color = !empty($cart_page_icon_color['normal_color']) ? $cart_page_icon_color['normal_color'] : $bg_color;
            $hover_icon_color = !empty($cart_page_icon_color['hover_color']) ? $cart_page_icon_color['hover_color'] : $bg_hover_color;
        } else {
            $normal_icon_color = !empty($cart_page_icon_color['normal_color']) ? $cart_page_icon_color['normal_color'] : '#ffffff';
            $hover_icon_color = !empty($cart_page_icon_color['hover_color']) ? $cart_page_icon_color['hover_color'] : '#ffffff';
        }

        $url_for_desktop = isset($ch_settings['url_for_desktop']) ? $ch_settings['url_for_desktop'] : '';
        $url_for_mobile = isset($ch_settings['url_for_mobile']) ? $ch_settings['url_for_mobile'] : '';

        $cart_page_agent_photo = isset($ch_wooCommerce['cart_page_agent_photo']) ? $ch_wooCommerce['cart_page_agent_photo'] : '';
        $cart_page_agent_photo_type = isset($ch_wooCommerce['cart_page_agent_photo_type']) ? $ch_wooCommerce['cart_page_agent_photo_type'] : 'default';
        $agent_photo_url = isset($cart_page_agent_photo['url']) ? $cart_page_agent_photo['url'] : '';
        $agent_name = isset($ch_wooCommerce['cart_page_button_top_label']) ? $ch_wooCommerce['cart_page_button_top_label'] : 'John Doe / Technical support';

        $cart_page_button_border = isset($ch_wooCommerce['cart_page_button_border']) ? $ch_wooCommerce['cart_page_button_border'] : array();
        $border_all = isset($cart_page_button_border['all']) ? $cart_page_button_border['all'] . 'px' : '0px';
        $border_style = isset($cart_page_button_border['style']) ? $cart_page_button_border['style'] : 'solid';
        $border_radius = isset($cart_page_button_border['border_radius']) ? $cart_page_button_border['border_radius'] . 'px' : '50px';
        $border_color = isset($cart_page_button_border['color']) ? $cart_page_button_border['color'] : '';
        $border_color = !empty($border_color) ? $border_color : $color_primary;
        $hover_border_color = isset($cart_page_button_border['hover_color']) ? $cart_page_button_border['hover_color'] : '';
        $hover_border_color = !empty($hover_border_color) ? $hover_border_color : $color_secondary;

        $cart_page_icon_border = isset($ch_wooCommerce['cart_page_icon_border']) ? $ch_wooCommerce['cart_page_icon_border'] : array();
        $icon_border_all = isset($cart_page_icon_border['all']) ? $cart_page_icon_border['all'] . 'px' : '0px';
        $icon_border_style = isset($cart_page_icon_border['style']) ? $cart_page_icon_border['style'] : 'solid';
        $icon_border_radius = isset($cart_page_icon_border['border_radius']) ? $cart_page_icon_border['border_radius'] . 'px' : '50px';
        $icon_border_color = isset($cart_page_icon_border['color']) ? $cart_page_icon_border['color'] : '';
        $icon_border_color = !empty($icon_border_color) ? $icon_border_color : $color_primary;
        $hover_icon_border_color = isset($cart_page_icon_border['hover_color']) ? $cart_page_icon_border['hover_color'] : '';
        $hover_icon_border_color = !empty($hover_icon_border_color) ? $hover_icon_border_color : $color_secondary;

        // Bubble button paddings
        $cart_page_button_padding = isset($ch_wooCommerce['cart_page_button_padding']) ? $ch_wooCommerce['cart_page_button_padding'] : array();
        $cart_page_button_padding_top =  isset($cart_page_button_padding['top']) ? $cart_page_button_padding['top'] : '5';
        $cart_page_button_padding_right =  isset($cart_page_button_padding['right']) ? $cart_page_button_padding['right'] : '15';
        $cart_page_button_padding_bottom =  isset($cart_page_button_padding['bottom']) ? $cart_page_button_padding['bottom'] : '5';
        $cart_page_button_padding_left =  isset($cart_page_button_padding['left']) ? $cart_page_button_padding['left'] : '6';
        $cart_page_button_padding_unit = isset($cart_page_button_padding['unit']) ? $cart_page_button_padding['unit'] : 'px';

        $padding = $cart_page_button_padding_top . $cart_page_button_padding_unit . ' ' . $cart_page_button_padding_right . $cart_page_button_padding_unit . ' ' . $cart_page_button_padding_bottom . $cart_page_button_padding_unit . ' ' . $cart_page_button_padding_left . $cart_page_button_padding_unit;
        // Bubble button margins
        $cart_page_button_margin = isset($ch_wooCommerce['cart_page_button_margin']) ? $ch_wooCommerce['cart_page_button_margin'] : array();
        $cart_page_button_margin_top =  isset($cart_page_button_margin['top']) ? $cart_page_button_margin['top'] : '0';
        $cart_page_button_margin_right =  isset($cart_page_button_margin['right']) ? $cart_page_button_margin['right'] : '0';
        $cart_page_button_margin_bottom =  isset($cart_page_button_margin['bottom']) ? $cart_page_button_margin['bottom'] : '0';
        $cart_page_button_margin_left =  isset($cart_page_button_margin['left']) ? $cart_page_button_margin['left'] : '0';
        $cart_page_button_margin_unit = isset($cart_page_button_margin['unit']) ? $cart_page_button_margin['unit'] : 'px';

        $margin = $cart_page_button_margin_top . $cart_page_button_margin_unit . ' ' . $cart_page_button_margin_right . $cart_page_button_margin_unit . ' ' . $cart_page_button_margin_bottom . $cart_page_button_margin_unit . ' ' . $cart_page_button_margin_left . $cart_page_button_margin_unit;

        if ($cart_page_agent_photo_type === 'default') {
            $agent_photo_url = CHAT_HELP_DIR_URL . 'src/Frontend/assets/image/user.webp';
        } elseif ($cart_page_agent_photo_type === 'custom' && $agent_photo_url) {
            $agent_photo_url;
        } elseif ($cart_page_agent_photo_type === 'none') {
            $agent_photo_url = '';
        }

        $message = isset($ch_wooCommerce['cart_page_button_message']) ? $ch_wooCommerce['cart_page_button_message'] : '';
        $message = Helpers::replacement_vars($message);

        $url = Helpers::whatsAppUrl($cart_page_button_number, $cart_page_button_type_of_whatsapp, $cart_page_button_group, $url_for_desktop, $url_for_mobile, $message);
        $open_in_new_tab = isset($ch_settings['open_in_new_tab']) ? $ch_settings['open_in_new_tab'] : '';
        $open_in_new_tab = $open_in_new_tab ? '_blank' : '_self';

        if ($cart_page_button_type_of_whatsapp === 'group') {
            $gaAnalyticsAttr = 'data-group=' . $cart_page_button_group . '';
        } else {
            $gaAnalyticsAttr = 'data-number=' . $cart_page_button_number . '';
        }


        if (!empty($cart_page_circle_button_icon)) {
            $circle_icon = '<i class="' . esc_attr($cart_page_circle_button_icon) . '"></i>';
        } else {
            $circle_icon = '<i class="icofont-brand-whatsapp"></i>';
        }


        if (!empty($cart_page_button_icon_open)) {
            $woo_button_icon = '<i class="' . esc_attr($cart_page_button_icon_open) . '"></i>';
        } else {
            $woo_button_icon = '<i class="icofont-brand-whatsapp"></i>';
        }

        if ($cart_page_button_style === '1') {
            echo '<a style= "--wHelp-btn-scale: ' . esc_attr($cart_page_button_size) . '; --wHelp-margin: ' . esc_attr($margin) . '; --wHelp-border: ' . esc_attr($border_all . ' ' . $border_style) . '; --wHelp-border-radius: ' . esc_attr($border_radius) . ';--wHelp-background: ' . esc_attr($bg_color) . '; --wHelp-hover-background: ' . esc_attr($bg_hover_color) . ';--wHelp-icon-normal-color: ' . esc_attr($normal_icon_color) . '; --wHelp-icon-hover-color: ' . esc_attr($hover_icon_color) . '; --wHelp-border-color: ' . esc_attr($border_color) . '; --wHelp-border-hover-color: ' . esc_attr($hover_border_color) . ';" target="' . esc_attr($open_in_new_tab) . '" href="' . esc_attr($url) . '" ' . esc_attr($gaAnalyticsAttr) . ' class="wHelp_button chat_help_analytics cart_page_button circle-bubble ' . esc_attr($cart_page_button_visibility) . '">';
            if ($circle_icon) {
                echo wp_kses_post($circle_icon);
            }
            echo '</a>';
        } else {
            echo '<a style="--wHelp-padding: ' . esc_attr($padding) . '; --wHelp-btn-scale: ' . esc_attr($cart_page_button_size) . '; --wHelp-margin: ' . esc_attr($margin) . '; --wHelp-border: ' . esc_attr($border_all . ' ' . $border_style) . '; --wHelp-border-radius: ' . esc_attr($border_radius) . ';--wHelp-background: ' . esc_attr($bg_color) . '; --wHelp-hover-background: ' . esc_attr($bg_hover_color) . '; --wHelp-icon-normal-color: ' . esc_attr($normal_icon_color) . '; --wHelp-icon-hover-color: ' . esc_attr($hover_icon_color) . '; --wHelp-icon-normal-bg-color: ' . esc_attr($normal_bg_color) . '; --wHelp-icon-hover-bg-color: ' . esc_attr($hover_bg_color) . '; --wHelp-border-color: ' . esc_attr($border_color) . '; --wHelp-border-hover-color: ' . esc_attr($hover_border_color) . '; --wHelp-text-color: ' . esc_attr($text_color) . '; --wHelp-text-hover-color: ' . esc_attr($text_hover_color) . '; --wHelp-icon-border: ' . esc_attr($icon_border_all . ' ' . $icon_border_style) . '; --wHelp-icon-border-color: ' . esc_attr($icon_border_color) . '; --wHelp-hover-icon-border-color: ' . esc_attr($hover_icon_border_color) . '; --wHelp-icon-border-radius: ' . esc_attr($icon_border_radius) . ';" target="' . esc_attr($open_in_new_tab) . '" href="' . esc_attr($url) . '" ' . esc_attr($gaAnalyticsAttr) . ' class="wHelp_button chat_help_analytics cart_page_button ' . esc_attr($cart_page_button_visibility) . '">';
            if ($cart_page_button_icon_open !== 'no_icon' && $woo_button_icon) {
                echo '<span class="bubble__icon ' . esc_attr($icon_bg) . '">';
                echo wp_kses_post($woo_button_icon);
                echo '</span>';
            }
            echo esc_html($cart_page_button_text);
            echo '</a>';
        }
    }
    public static function checkout_page_button()
    {
        $options = get_option('cwp_option');
        $ch_wooCommerce = get_option('ch_wooCommerce');
        $ch_settings = get_option('ch_settings');
        $checkout_page_button_type_of_whatsapp = isset($ch_wooCommerce['checkout_page_button_type_of_whatsapp']) ? $ch_wooCommerce['checkout_page_button_type_of_whatsapp'] : '';
        $checkout_page_button_number = isset($ch_wooCommerce['checkout_page_button_number']) ? $ch_wooCommerce['checkout_page_button_number'] : '';
        $checkout_page_button_group = isset($ch_wooCommerce['checkout_page_button_group']) ? $ch_wooCommerce['checkout_page_button_group'] : '';
        // Empty fields inherit the Global Chat number/group (live fallback).
        $global_whatsapp = Helpers::global_whatsapp_defaults();
        $checkout_page_button_number = trim((string) $checkout_page_button_number) !== '' ? $checkout_page_button_number : $global_whatsapp['number'];
        $checkout_page_button_group = trim((string) $checkout_page_button_group) !== '' ? $checkout_page_button_group : $global_whatsapp['group'];
        $checkout_page_circle_button_icon = isset($ch_wooCommerce['checkout_page_circle_button_icon']) ? $ch_wooCommerce['checkout_page_circle_button_icon'] : 'icofont-brand-whatsapp';
        $checkout_page_button_icon_open = !empty($ch_wooCommerce['checkout_page_button_icon_open']) ? $ch_wooCommerce['checkout_page_button_icon_open'] : 'icofont-brand-whatsapp';

        $checkout_page_button_text = isset($ch_wooCommerce['checkout_page_button_text']) ? $ch_wooCommerce['checkout_page_button_text'] : 'How may I help you?';
        $checkout_page_button_size = isset($ch_wooCommerce['checkout_page_button_size']) ? $ch_wooCommerce['checkout_page_button_size'] : '1';
        $checkout_page_button_visibility = isset($ch_wooCommerce['checkout_page_button_visibility']) ? $ch_wooCommerce['checkout_page_button_visibility'] : 'everywhere';
        $checkout_page_button_visibility = 'wooCommerce-' . $checkout_page_button_visibility . '-only';
        $checkout_page_button_style = isset($ch_wooCommerce['checkout_page_button_style']) ? $ch_wooCommerce['checkout_page_button_style'] : '2';
        $color_settings = !empty($options['color_settings']) ? $options['color_settings'] : array();
        $color_primary = !empty($color_settings['primary']) ? $color_settings['primary'] : '#118c7e';
        $color_secondary = !empty($color_settings['secondary']) ? $color_settings['secondary'] : '#0b5a51';

        $button_bg = !empty($ch_wooCommerce['checkout_page_button_bg']) ? $ch_wooCommerce['checkout_page_button_bg'] : array();
        $bg_color = !empty($button_bg['normal_color']) ? $button_bg['normal_color'] : '#118c7e';
        $bg_hover_color = !empty($button_bg['hover_color']) ? $button_bg['hover_color'] : '#0b5a51';

        $button_text = !empty($ch_wooCommerce['checkout_page_button_text_color']) ? $ch_wooCommerce['checkout_page_button_text_color'] : array();
        $text_color = !empty($button_text['normal_color']) ? $button_text['normal_color'] : '#ffffff';
        $text_hover_color = !empty($button_text['hover_color']) ? $button_text['hover_color'] : '#ffffff';

        $checkout_page_icon_bg_color = !empty($ch_wooCommerce['checkout_page_icon_bg_color']) ? $ch_wooCommerce['checkout_page_icon_bg_color'] : array();
        $normal_bg_color = !empty($checkout_page_icon_bg_color['normal_color']) ? $checkout_page_icon_bg_color['normal_color'] : '#ffffff';
        $hover_bg_color = !empty($checkout_page_icon_bg_color['hover_color']) ? $checkout_page_icon_bg_color['hover_color'] : '#ffffff';
        $icon_bg = !empty($ch_wooCommerce['checkout_page_icon_bg']) ? 'icon_bg' : '';
        $checkout_page_icon_color = !empty($ch_wooCommerce['checkout_page_icon_color']) ? $ch_wooCommerce['checkout_page_icon_color'] : array();

        if ($checkout_page_button_style == '2' && $icon_bg === 'icon_bg') {
            $normal_icon_color = !empty($checkout_page_icon_color['normal_color']) ? $checkout_page_icon_color['normal_color'] : $bg_color;
            $hover_icon_color = !empty($checkout_page_icon_color['hover_color']) ? $checkout_page_icon_color['hover_color'] : $bg_hover_color;
        } else {
            $normal_icon_color = !empty($checkout_page_icon_color['normal_color']) ? $checkout_page_icon_color['normal_color'] : '#ffffff';
            $hover_icon_color = !empty($checkout_page_icon_color['hover_color']) ? $checkout_page_icon_color['hover_color'] : '#ffffff';
        }

        $url_for_desktop = isset($ch_settings['url_for_desktop']) ? $ch_settings['url_for_desktop'] : '';
        $url_for_mobile = isset($ch_settings['url_for_mobile']) ? $ch_settings['url_for_mobile'] : '';

        $checkout_page_agent_photo = isset($ch_wooCommerce['checkout_page_agent_photo']) ? $ch_wooCommerce['checkout_page_agent_photo'] : '';
        $checkout_page_agent_photo_type = isset($ch_wooCommerce['checkout_page_agent_photo_type']) ? $ch_wooCommerce['checkout_page_agent_photo_type'] : 'default';
        $agent_photo_url = isset($checkout_page_agent_photo['url']) ? $checkout_page_agent_photo['url'] : '';
        $agent_name = isset($ch_wooCommerce['checkout_page_button_top_label']) ? $ch_wooCommerce['checkout_page_button_top_label'] : 'John Doe / Technical support';

        $checkout_page_button_border = isset($ch_wooCommerce['checkout_page_button_border']) ? $ch_wooCommerce['checkout_page_button_border'] : array();
        $border_all = isset($checkout_page_button_border['all']) ? $checkout_page_button_border['all'] . 'px' : '0px';
        $border_style = isset($checkout_page_button_border['style']) ? $checkout_page_button_border['style'] : 'solid';
        $border_radius = isset($checkout_page_button_border['border_radius']) ? $checkout_page_button_border['border_radius'] . 'px' : '50px';
        $border_color = isset($checkout_page_button_border['color']) ? $checkout_page_button_border['color'] : '';
        $border_color = !empty($border_color) ? $border_color : $color_primary;
        $hover_border_color = isset($checkout_page_button_border['hover_color']) ? $checkout_page_button_border['hover_color'] : '';
        $hover_border_color = !empty($hover_border_color) ? $hover_border_color : $color_secondary;

        $checkout_page_icon_border = isset($ch_wooCommerce['checkout_page_icon_border']) ? $ch_wooCommerce['checkout_page_icon_border'] : array();
        $icon_border_all = isset($checkout_page_icon_border['all']) ? $checkout_page_icon_border['all'] . 'px' : '0px';
        $icon_border_style = isset($checkout_page_icon_border['style']) ? $checkout_page_icon_border['style'] : 'solid';
        $icon_border_radius = isset($checkout_page_icon_border['border_radius']) ? $checkout_page_icon_border['border_radius'] . 'px' : '50px';
        $icon_border_color = isset($checkout_page_icon_border['color']) ? $checkout_page_icon_border['color'] : '';
        $icon_border_color = !empty($icon_border_color) ? $icon_border_color : $color_primary;
        $hover_icon_border_color = isset($checkout_page_icon_border['hover_color']) ? $checkout_page_icon_border['hover_color'] : '';
        $hover_icon_border_color = !empty($hover_icon_border_color) ? $hover_icon_border_color : $color_secondary;

        // Bubble button paddings
        $checkout_page_button_padding = isset($ch_wooCommerce['checkout_page_button_padding']) ? $ch_wooCommerce['checkout_page_button_padding'] : array();
        $checkout_page_button_padding_top =  isset($checkout_page_button_padding['top']) ? $checkout_page_button_padding['top'] : '5';
        $checkout_page_button_padding_right =  isset($checkout_page_button_padding['right']) ? $checkout_page_button_padding['right'] : '15';
        $checkout_page_button_padding_bottom =  isset($checkout_page_button_padding['bottom']) ? $checkout_page_button_padding['bottom'] : '5';
        $checkout_page_button_padding_left =  isset($checkout_page_button_padding['left']) ? $checkout_page_button_padding['left'] : '6';
        $checkout_page_button_padding_unit = isset($checkout_page_button_padding['unit']) ? $checkout_page_button_padding['unit'] : 'px';

        $padding = $checkout_page_button_padding_top . $checkout_page_button_padding_unit . ' ' . $checkout_page_button_padding_right . $checkout_page_button_padding_unit . ' ' . $checkout_page_button_padding_bottom . $checkout_page_button_padding_unit . ' ' . $checkout_page_button_padding_left . $checkout_page_button_padding_unit;
        // Bubble button margins
        $checkout_page_button_margin = isset($ch_wooCommerce['checkout_page_button_margin']) ? $ch_wooCommerce['checkout_page_button_margin'] : array();
        $checkout_page_button_margin_top =  isset($checkout_page_button_margin['top']) ? $checkout_page_button_margin['top'] : '20';
        $checkout_page_button_margin_right =  isset($checkout_page_button_margin['right']) ? $checkout_page_button_margin['right'] : '0';
        $checkout_page_button_margin_bottom =  isset($checkout_page_button_margin['bottom']) ? $checkout_page_button_margin['bottom'] : '0';
        $checkout_page_button_margin_left =  isset($checkout_page_button_margin['left']) ? $checkout_page_button_margin['left'] : '0';
        $checkout_page_button_margin_unit = isset($checkout_page_button_margin['unit']) ? $checkout_page_button_margin['unit'] : 'px';

        $margin = $checkout_page_button_margin_top . $checkout_page_button_margin_unit . ' ' . $checkout_page_button_margin_right . $checkout_page_button_margin_unit . ' ' . $checkout_page_button_margin_bottom . $checkout_page_button_margin_unit . ' ' . $checkout_page_button_margin_left . $checkout_page_button_margin_unit;

        if ($checkout_page_agent_photo_type === 'default') {
            $agent_photo_url = CHAT_HELP_DIR_URL . 'src/Frontend/assets/image/user.webp';
        } elseif ($checkout_page_agent_photo_type === 'custom' && $agent_photo_url) {
            $agent_photo_url;
        } elseif ($checkout_page_agent_photo_type === 'none') {
            $agent_photo_url = '';
        }

        $raw_message = isset($ch_wooCommerce['checkout_page_button_message']) ? $ch_wooCommerce['checkout_page_button_message'] : '';
        $message = Helpers::replacement_vars($raw_message);

        // When the message uses {shipping}, the value baked in at render time goes
        // stale as the customer edits the checkout form. Build a template where
        // every other variable is resolved but {shipping} is left as a JS sentinel,
        // and let a small script refresh it from the live form at click time (and
        // after WooCommerce AJAX re-renders).
        // Emitted as data-ch-ship / data-ch-msg on the button (escaped inline at
        // the echo). The refresh script only matches [data-ch-ship="1"], so the
        // empty defaults are inert.
        $ship_enabled     = '';
        $template_message = '';
        if (false !== strpos($raw_message, '{shipping}')) {
            $ship_enabled     = '1';
            $template_message = Helpers::replacement_vars(str_replace('{shipping}', '__CH_SHIPPING__', $raw_message));

            if (! self::$checkout_shipping_script_added) {
                self::$checkout_shipping_script_added = true;
                add_action('wp_footer', array(self::class, 'checkout_shipping_script'), 99);
            }
        }

        $url = Helpers::whatsAppUrl($checkout_page_button_number, $checkout_page_button_type_of_whatsapp, $checkout_page_button_group, $url_for_desktop, $url_for_mobile, $message);
        $open_in_new_tab = isset($ch_settings['open_in_new_tab']) ? $ch_settings['open_in_new_tab'] : '';
        $open_in_new_tab = $open_in_new_tab ? '_blank' : '_self';

        if ($checkout_page_button_type_of_whatsapp === 'group') {
            $gaAnalyticsAttr = 'data-group=' . $checkout_page_button_group . '';
        } else {
            $gaAnalyticsAttr = 'data-number=' . $checkout_page_button_number . '';
        }

        if (!empty($checkout_page_circle_button_icon)) {
            $circle_icon = '<i class="' . esc_attr($checkout_page_circle_button_icon) . '"></i>';
        } else {
            $circle_icon = '<i class="icofont-brand-whatsapp"></i>';
        }

        if (!empty($checkout_page_button_icon_open)) {
            $woo_button_icon = '<i class="' . esc_attr($checkout_page_button_icon_open) . '"></i>';
        } else {
            $woo_button_icon = '<i class="icofont-brand-whatsapp"></i>';
        }

        if ($checkout_page_button_style === '1') {
            echo '<a style="--wHelp-btn-scale: ' . esc_attr($checkout_page_button_size) . ';--wHelp-margin: ' . esc_attr($margin) . '; --wHelp-border: ' . esc_attr($border_all . ' ' . $border_style) . '; --wHelp-border-radius: ' . esc_attr($border_radius) . ';--wHelp-background: ' . esc_attr($bg_color) . '; --wHelp-hover-background: ' . esc_attr($bg_hover_color) . ';--wHelp-icon-normal-color: ' . esc_attr($normal_icon_color) . '; --wHelp-icon-hover-color: ' . esc_attr($hover_icon_color) . '; --wHelp-border-color: ' . esc_attr($border_color) . '; --wHelp-border-hover-color: ' . esc_attr($hover_border_color) . ';" target="' . esc_attr($open_in_new_tab) . '" href="' . esc_attr($url) . '" ' . esc_attr($gaAnalyticsAttr) . ' data-ch-ship="' . esc_attr($ship_enabled) . '" data-ch-msg="' . esc_attr($template_message) . '" class="wHelp_button chat_help_analytics checkout_page_button circle-bubble ' . esc_attr($checkout_page_button_visibility) . '">';
            if ($circle_icon) {
                echo wp_kses_post($circle_icon);
            }
            echo '</a>';
        } else {
            echo '<a style="--wHelp-padding: ' . esc_attr($padding) . '; --wHelp-btn-scale: ' . esc_attr($checkout_page_button_size) . '; --wHelp-margin: ' . esc_attr($margin) . '; --wHelp-border: ' . esc_attr($border_all . ' ' . $border_style) . '; --wHelp-border-radius: ' . esc_attr($border_radius) . ';--wHelp-background: ' . esc_attr($bg_color) . '; --wHelp-hover-background: ' . esc_attr($bg_hover_color) . '; --wHelp-icon-normal-color: ' . esc_attr($normal_icon_color) . '; --wHelp-icon-hover-color: ' . esc_attr($hover_icon_color) . '; --wHelp-icon-normal-bg-color: ' . esc_attr($normal_bg_color) . '; --wHelp-icon-hover-bg-color: ' . esc_attr($hover_bg_color) . '; --wHelp-border-color: ' . esc_attr($border_color) . '; --wHelp-border-hover-color: ' . esc_attr($hover_border_color) . '; --wHelp-text-color: ' . esc_attr($text_color) . '; --wHelp-text-hover-color: ' . esc_attr($text_hover_color) . '; --wHelp-icon-border: ' . esc_attr($icon_border_all . ' ' . $icon_border_style) . '; --wHelp-icon-border-color: ' . esc_attr($icon_border_color) . '; --wHelp-hover-icon-border-color: ' . esc_attr($hover_icon_border_color) . '; --wHelp-icon-border-radius: ' . esc_attr($icon_border_radius) . ';" target="' . esc_attr($open_in_new_tab) . '" href="' . esc_attr($url) . '" ' . esc_attr($gaAnalyticsAttr) . ' data-ch-ship="' . esc_attr($ship_enabled) . '" data-ch-msg="' . esc_attr($template_message) . '" class="wHelp_button chat_help_analytics checkout_page_button ' . esc_attr($checkout_page_button_visibility) . '">';
            if ($checkout_page_button_icon_open !== 'no_icon' && $woo_button_icon) {
                echo '<span class="bubble__icon ' . esc_attr($icon_bg) . '">';
                echo wp_kses_post($woo_button_icon);
                echo '</span>';
            }
            echo esc_html($checkout_page_button_text);
            echo '</a>';
        }
    }

    /**
     * Print the script that refreshes the checkout button's {shipping} value.
     *
     * Works on both checkout types:
     *  - Classic (shortcode) checkout: reads the live billing/shipping form
     *    fields (honouring "ship to a different address").
     *  - Block checkout: reads the live customer data from the wc/store/cart data
     *    store, which stays current as the customer edits the React form (and even
     *    while the address is shown collapsed as a saved card).
     *
     * Binding uses event delegation on the document so it also covers the button
     * the block checkout injects dynamically and any re-render — there is nothing
     * to re-bind. The WhatsApp URL's text parameter is rewritten just before the
     * button is followed. Mirrors Helpers::get_shipping_whatsapp_info().
     *
     * @return void
     */
    public static function checkout_shipping_script()
    {
        ?>
<script>
(function () {
    var SENTINEL = '__CH_SHIPPING__';

    function fmt(p) {
        var lines = [];
        if (p.name)    lines.push('*Name:* ' + p.name);
        if (p.company) lines.push('*Company:* ' + p.company);
        if (p.a1)      lines.push('*Address:* ' + p.a1);
        if (p.a2)      lines.push('*Address 2:* ' + p.a2);
        if (p.city)    lines.push('*City:* ' + p.city);
        if (p.state)   lines.push('*State:* ' + p.state);
        if (p.post)    lines.push('*Postcode:* ' + p.post);
        if (p.country) lines.push('*Country:* ' + p.country);
        return lines.join('\n');
    }

    function countryName(code) {
        if (!code) return '';
        try {
            if (window.Intl && Intl.DisplayNames) {
                var n = new Intl.DisplayNames(['en'], { type: 'region' }).of(code);
                if (n) return n;
            }
        } catch (e) {}
        return code;
    }

    // Read an element's live value. The DOM always holds the latest keystroke,
    // so this is fresher than any cached/debounced store value. Handles native
    // selects (classic) and combobox inputs (block) alike.
    function read(id) {
        var e = document.getElementById(id);
        if (!e) return '';
        if (e.tagName === 'SELECT' && e.selectedIndex >= 0) {
            var o = e.options[e.selectedIndex];
            return o ? String(o.text).trim() : '';
        }
        return String(e.value != null ? e.value : '').trim();
    }

    // Snapshot of the block checkout's customer data (used only when the address
    // is shown collapsed as a saved card, so no inputs are in the DOM).
    function storeData() {
        if (!document.querySelector('.wp-block-woocommerce-checkout')) return null;
        if (!(window.wp && wp.data && typeof wp.data.select === 'function')) return null;
        try {
            var sel = wp.data.select('wc/store/cart');
            if (!sel || typeof sel.getCustomerData !== 'function') return null;
            var d = sel.getCustomerData();
            if (!d) return null;
            return { ship: d.shippingAddress || {}, bill: d.billingAddress || {} };
        } catch (e) {
            return null;
        }
    }

    function buildShipping() {
        var store = storeData();
        var classicDiff = document.getElementById('ship-to-different-address-checkbox');
        var classicPrefix = (classicDiff && classicDiff.checked) ? 'shipping_' : 'billing_';

        // For each field, take the freshest available value: live block input,
        // live classic input, then the block store (collapsed card) as fallback.
        function resolve(key) {
            var v = read('shipping-' + key) || read('billing-' + key); // block inputs
            if (v) return v;
            v = read(classicPrefix + key) || read('billing_' + key);    // classic inputs
            if (v) return v;
            if (store) {                                                // block store
                var base = (store.ship.address_1 || store.ship.first_name || store.ship.city) ? store.ship : store.bill;
                var sv = (base[key] != null && base[key] !== '') ? base[key] : (store.bill[key] || '');
                sv = String(sv).trim();
                if (sv) return (key === 'country') ? countryName(sv) : sv;
            }
            return '';
        }

        var first = resolve('first_name'), last = resolve('last_name');
        return fmt({
            name: (first + ' ' + last).trim(),
            company: resolve('company'),
            a1: resolve('address_1'),
            a2: resolve('address_2'),
            city: resolve('city'),
            state: resolve('state'),
            post: resolve('postcode'),
            country: resolve('country')
        });
    }

    function refresh(a) {
        var tmpl = a.getAttribute('data-ch-msg');
        if (tmpl === null) return;
        var msg = tmpl.split(SENTINEL).join(buildShipping());
        var href = a.getAttribute('href') || '';
        if (/[?&]text=/.test(href)) {
            href = href.replace(/([?&]text=)[^&#]*/, '$1' + encodeURIComponent(msg));
            a.setAttribute('href', href);
        }
    }

    // Delegated handler: covers the classic button and the button the block
    // checkout injects dynamically, with no need to (re)bind on re-renders.
    function handler(e) {
        var t = e.target;
        if (!t || !t.closest) return;
        var a = t.closest('a.checkout_page_button[data-ch-ship="1"]');
        if (a) refresh(a);
    }

    ['pointerdown', 'touchstart', 'click'].forEach(function (ev) {
        document.addEventListener(ev, handler, true);
    });
})();
</script>
        <?php
    }

    public static function thank_you_page_button()
    {
        $options = get_option('cwp_option');
        $ch_wooCommerce = get_option('ch_wooCommerce');
        $ch_settings = get_option('ch_settings');
        $thank_you_page_button_type_of_whatsapp = isset($ch_wooCommerce['thank_you_page_button_type_of_whatsapp']) ? $ch_wooCommerce['thank_you_page_button_type_of_whatsapp'] : '';
        $thank_you_page_button_number = isset($ch_wooCommerce['thank_you_page_button_number']) ? $ch_wooCommerce['thank_you_page_button_number'] : '';
        $thank_you_page_button_group = isset($ch_wooCommerce['thank_you_page_button_group']) ? $ch_wooCommerce['thank_you_page_button_group'] : '';
        // Empty fields inherit the Global Chat number/group (live fallback).
        $global_whatsapp = Helpers::global_whatsapp_defaults();
        $thank_you_page_button_number = trim((string) $thank_you_page_button_number) !== '' ? $thank_you_page_button_number : $global_whatsapp['number'];
        $thank_you_page_button_group = trim((string) $thank_you_page_button_group) !== '' ? $thank_you_page_button_group : $global_whatsapp['group'];
        $thank_you_page_button_icon = isset($ch_wooCommerce['thank_you_page_button_icon']) ? $ch_wooCommerce['thank_you_page_button_icon'] : 1;
        $thank_you_page_circle_button_icon = isset($ch_wooCommerce['thank_you_page_circle_button_icon']) ? $ch_wooCommerce['thank_you_page_circle_button_icon'] : 'icofont-brand-whatsapp';
        $thank_you_page_circle_button_icon_native = isset($ch_wooCommerce['thank_you_page_circle_button_icon_native']) ? $ch_wooCommerce['thank_you_page_circle_button_icon_native'] : '';
        $thank_you_page_circle_button_icon_custom = isset($ch_wooCommerce['thank_you_page_circle_button_icon_custom']) ? $ch_wooCommerce['thank_you_page_circle_button_icon_custom']['url'] : '';
        $thank_you_page_button_icon_open = !empty($ch_wooCommerce['thank_you_page_button_icon_open']) ? $ch_wooCommerce['thank_you_page_button_icon_open'] : 'icofont-brand-whatsapp';
        $thank_you_page_button_icon_native = !empty($ch_wooCommerce['thank_you_page_button_icon_native']) ? $ch_wooCommerce['thank_you_page_button_icon_native'] : '';
        $thank_you_page_button_icon_custom = !empty($ch_wooCommerce['thank_you_page_button_icon_custom']) ? $ch_wooCommerce['thank_you_page_button_icon_custom']['url'] : '';

        $thank_you_page_button_text = isset($ch_wooCommerce['thank_you_page_button_text']) ? $ch_wooCommerce['thank_you_page_button_text'] : 'How may I help you?';
        $thank_you_page_button_size = isset($ch_wooCommerce['thank_you_page_button_size']) ? $ch_wooCommerce['thank_you_page_button_size'] : '1';
        $thank_you_page_button_size_custom = isset($ch_wooCommerce["thank_you_page_button_size_custom"]) ? $ch_wooCommerce["thank_you_page_button_size_custom"] : '100';
        if ($thank_you_page_button_size === 'custom') {
            $thank_you_page_button_size = $thank_you_page_button_size_custom / 100;
        }
        $thank_you_page_button_visibility = isset($ch_wooCommerce['thank_you_page_button_visibility']) ? $ch_wooCommerce['thank_you_page_button_visibility'] : 'everywhere';
        $thank_you_page_button_visibility = 'wooCommerce-' . $thank_you_page_button_visibility . '-only';
        $thank_you_page_button_style = isset($ch_wooCommerce['thank_you_page_button_style']) ? $ch_wooCommerce['thank_you_page_button_style'] : '2';
        $color_settings = !empty($options['color_settings']) ? $options['color_settings'] : array();
        $color_primary = !empty($color_settings['primary']) ? $color_settings['primary'] : '#118c7e';
        $color_secondary = !empty($color_settings['secondary']) ? $color_settings['secondary'] : '#0b5a51';

        $button_bg = !empty($ch_wooCommerce['thank_you_page_button_bg']) ? $ch_wooCommerce['thank_you_page_button_bg'] : array();
        $bg_color = !empty($button_bg['normal_color']) ? $button_bg['normal_color'] : '#118c7e';
        $bg_hover_color = !empty($button_bg['hover_color']) ? $button_bg['hover_color'] : '#0b5a51';

        $button_text = !empty($ch_wooCommerce['thank_you_page_button_text_color']) ? $ch_wooCommerce['thank_you_page_button_text_color'] : array();
        $text_color = !empty($button_text['normal_color']) ? $button_text['normal_color'] : '#ffffff';
        $text_hover_color = !empty($button_text['hover_color']) ? $button_text['hover_color'] : '#ffffff';

        $thank_you_page_icon_bg_color = !empty($ch_wooCommerce['thank_you_page_icon_bg_color']) ? $ch_wooCommerce['thank_you_page_icon_bg_color'] : array();
        $normal_bg_color = !empty($thank_you_page_icon_bg_color['normal_color']) ? $thank_you_page_icon_bg_color['normal_color'] : '#ffffff';
        $hover_bg_color = !empty($thank_you_page_icon_bg_color['hover_color']) ? $thank_you_page_icon_bg_color['hover_color'] : '#ffffff';
        $icon_bg = !empty($ch_wooCommerce['thank_you_page_icon_bg']) ? 'icon_bg' : '';
        $thank_you_page_icon_color = !empty($ch_wooCommerce['thank_you_page_icon_color']) ? $ch_wooCommerce['thank_you_page_icon_color'] : array();

        if ($thank_you_page_button_style == '2' && $icon_bg === 'icon_bg') {
            $normal_icon_color = !empty($thank_you_page_icon_color['normal_color']) ? $thank_you_page_icon_color['normal_color'] : $bg_color;
            $hover_icon_color = !empty($thank_you_page_icon_color['hover_color']) ? $thank_you_page_icon_color['hover_color'] : $bg_hover_color;
        } else {
            $normal_icon_color = !empty($thank_you_page_icon_color['normal_color']) ? $thank_you_page_icon_color['normal_color'] : '#ffffff';
            $hover_icon_color = !empty($thank_you_page_icon_color['hover_color']) ? $thank_you_page_icon_color['hover_color'] : '#ffffff';
        }

        $url_for_desktop = isset($ch_settings['url_for_desktop']) ? $ch_settings['url_for_desktop'] : '';
        $url_for_mobile = isset($ch_settings['url_for_mobile']) ? $ch_settings['url_for_mobile'] : '';

        $thank_you_page_agent_photo = isset($ch_wooCommerce['thank_you_page_agent_photo']) ? $ch_wooCommerce['thank_you_page_agent_photo'] : '';
        $thank_you_page_agent_photo_type = isset($ch_wooCommerce['thank_you_page_agent_photo_type']) ? $ch_wooCommerce['thank_you_page_agent_photo_type'] : 'default';
        $agent_photo_url = isset($thank_you_page_agent_photo['url']) ? $thank_you_page_agent_photo['url'] : '';
        $agent_name = isset($ch_wooCommerce['thank_you_page_button_top_label']) ? $ch_wooCommerce['thank_you_page_button_top_label'] : 'John Doe / Technical support';

        $thank_you_page_button_border = isset($ch_wooCommerce['thank_you_page_button_border']) ? $ch_wooCommerce['thank_you_page_button_border'] : array();
        $border_all = isset($thank_you_page_button_border['all']) ? $thank_you_page_button_border['all'] . 'px' : '0px';
        $border_style = isset($thank_you_page_button_border['style']) ? $thank_you_page_button_border['style'] : 'solid';
        $border_radius = isset($thank_you_page_button_border['border_radius']) ? $thank_you_page_button_border['border_radius'] . 'px' : '50px';
        $border_color = isset($thank_you_page_button_border['color']) ? $thank_you_page_button_border['color'] : '';
        $border_color = !empty($border_color) ? $border_color : $color_primary;
        $hover_border_color = isset($thank_you_page_button_border['hover_color']) ? $thank_you_page_button_border['hover_color'] : '';
        $hover_border_color = !empty($hover_border_color) ? $hover_border_color : $color_secondary;

        $thank_you_page_icon_border = isset($ch_wooCommerce['thank_you_page_icon_border']) ? $ch_wooCommerce['thank_you_page_icon_border'] : array();
        $icon_border_all = isset($thank_you_page_icon_border['all']) ? $thank_you_page_icon_border['all'] . 'px' : '0px';
        $icon_border_style = isset($thank_you_page_icon_border['style']) ? $thank_you_page_icon_border['style'] : 'solid';
        $icon_border_radius = isset($thank_you_page_icon_border['border_radius']) ? $thank_you_page_icon_border['border_radius'] . 'px' : '50px';
        $icon_border_color = isset($thank_you_page_icon_border['color']) ? $thank_you_page_icon_border['color'] : '';
        $icon_border_color = !empty($icon_border_color) ? $icon_border_color : $color_primary;
        $hover_icon_border_color = isset($thank_you_page_icon_border['hover_color']) ? $thank_you_page_icon_border['hover_color'] : '';
        $hover_icon_border_color = !empty($hover_icon_border_color) ? $hover_icon_border_color : $color_secondary;

        // Bubble button paddings
        $thank_you_page_button_padding = isset($ch_wooCommerce['thank_you_page_button_padding']) ? $ch_wooCommerce['thank_you_page_button_padding'] : array();
        $thank_you_page_button_padding_top =  isset($thank_you_page_button_padding['top']) ? $thank_you_page_button_padding['top'] : '5';
        $thank_you_page_button_padding_right =  isset($thank_you_page_button_padding['right']) ? $thank_you_page_button_padding['right'] : '15';
        $thank_you_page_button_padding_bottom =  isset($thank_you_page_button_padding['bottom']) ? $thank_you_page_button_padding['bottom'] : '5';
        $thank_you_page_button_padding_left =  isset($thank_you_page_button_padding['left']) ? $thank_you_page_button_padding['left'] : '6';
        $thank_you_page_button_padding_unit = isset($thank_you_page_button_padding['unit']) ? $thank_you_page_button_padding['unit'] : 'px';

        $padding = $thank_you_page_button_padding_top . $thank_you_page_button_padding_unit . ' ' . $thank_you_page_button_padding_right . $thank_you_page_button_padding_unit . ' ' . $thank_you_page_button_padding_bottom . $thank_you_page_button_padding_unit . ' ' . $thank_you_page_button_padding_left . $thank_you_page_button_padding_unit;
        // Bubble button margins
        $thank_you_page_button_margin = isset($ch_wooCommerce['thank_you_page_button_margin']) ? $ch_wooCommerce['thank_you_page_button_margin'] : array();
        $thank_you_page_button_margin_top =  isset($thank_you_page_button_margin['top']) ? $thank_you_page_button_margin['top'] : '20';
        $thank_you_page_button_margin_right =  isset($thank_you_page_button_margin['right']) ? $thank_you_page_button_margin['right'] : '0';
        $thank_you_page_button_margin_bottom =  isset($thank_you_page_button_margin['bottom']) ? $thank_you_page_button_margin['bottom'] : '0';
        $thank_you_page_button_margin_left =  isset($thank_you_page_button_margin['left']) ? $thank_you_page_button_margin['left'] : '0';
        $thank_you_page_button_margin_unit = isset($thank_you_page_button_margin['unit']) ? $thank_you_page_button_margin['unit'] : 'px';

        $margin = $thank_you_page_button_margin_top . $thank_you_page_button_margin_unit . ' ' . $thank_you_page_button_margin_right . $thank_you_page_button_margin_unit . ' ' . $thank_you_page_button_margin_bottom . $thank_you_page_button_margin_unit . ' ' . $thank_you_page_button_margin_left . $thank_you_page_button_margin_unit;

        if ($thank_you_page_agent_photo_type === 'default') {
            $agent_photo_url = CHAT_HELP_DIR_URL . 'src/Frontend/assets/image/user.webp';
        } elseif ($thank_you_page_agent_photo_type === 'custom' && $agent_photo_url) {
            $agent_photo_url;
        } elseif ($thank_you_page_agent_photo_type === 'none') {
            $agent_photo_url = '';
        }

        $message = isset($ch_wooCommerce['thank_you_page_button_message']) ? $ch_wooCommerce['thank_you_page_button_message'] : '';
        $message = Helpers::replacement_vars($message);

        $url = Helpers::whatsAppUrl($thank_you_page_button_number, $thank_you_page_button_type_of_whatsapp, $thank_you_page_button_group, $url_for_desktop, $url_for_mobile, $message);
        $open_in_new_tab = isset($ch_settings['open_in_new_tab']) ? $ch_settings['open_in_new_tab'] : '';
        $open_in_new_tab = $open_in_new_tab ? '_blank' : '_self';

        if ($thank_you_page_button_type_of_whatsapp === 'group') {
            $gaAnalyticsAttr = 'data-group=' . $thank_you_page_button_group . '';
        } else {
            $gaAnalyticsAttr = 'data-number=' . $thank_you_page_button_number . '';
        }

        if ($thank_you_page_circle_button_icon === 'native') {
            $circle_icon = '<i class="' . esc_attr($thank_you_page_circle_button_icon_native) . '"></i>';
        } elseif ($thank_you_page_circle_button_icon === 'custom' && !empty($thank_you_page_circle_button_icon_custom)) {
            $circle_icon = '<img src="' . esc_url($thank_you_page_circle_button_icon_custom) . '" alt="" />';
        } else {
            if (!empty($thank_you_page_circle_button_icon)) {
                $circle_icon = '<i class="' . esc_attr($thank_you_page_circle_button_icon) . '"></i>';
            } else {
                $circle_icon = '<i class="icofont-brand-whatsapp"></i>';
            }
        }
        if ($thank_you_page_button_icon_open === 'native') {
            $woo_button_icon = '<i class="' . esc_attr($thank_you_page_button_icon_native) . '"></i>';
        } elseif ($thank_you_page_button_icon_open === 'custom' && !empty($thank_you_page_button_icon_custom)) {
            $woo_button_icon = '<img src="' . esc_url($thank_you_page_button_icon_custom) . '" alt="" />';
        } else {
            if (!empty($thank_you_page_button_icon_open)) {
                $woo_button_icon = '<i class="' . esc_attr($thank_you_page_button_icon_open) . '"></i>';
            } else {
                $woo_button_icon = '<i class="icofont-brand-whatsapp"></i>';
            }
        }

        $thank_you_page_custom_title = isset($ch_wooCommerce['thank_you_page_custom_title']) ? $ch_wooCommerce['thank_you_page_custom_title'] : '';
        $thank_you_page_custom_subtitle = isset($ch_wooCommerce['thank_you_page_custom_subtitle']) ? $ch_wooCommerce['thank_you_page_custom_subtitle'] : '';

        global $wp;
        // Check the order with enhanced security validation
        $order_id               = (int) $wp->query_vars['order-received'];
        if (!$order_id) {
            return '';
        }

        // Validate order access (if security enhancements are loaded)
        if (function_exists('wa_order_validate_order_access') && !wa_order_validate_order_access($order_id)) {
            return '';
        }

        $order = wc_get_order($order_id);
        if (!$order) {
            return '';
        }

        $customer_id        = $order->get_user_id();
        $first_name         = $order->get_billing_first_name();

        echo '<div class="thank_you_custom_wrapper">';
        echo '<h2 class="thank_you_title">' . wp_kses_post($thank_you_page_custom_title) . ', ' . esc_html($first_name) . '!' . '</h2>';
        echo '<p class="thank_you_subtitle">' . wp_kses_post($thank_you_page_custom_subtitle) . '</p>';


        if ($thank_you_page_button_style === '1') {
            echo '<a style="--wHelp-btn-scale: ' . esc_attr($thank_you_page_button_size) . ';--wHelp-margin: ' . esc_attr($margin) . '; --wHelp-border: ' . esc_attr($border_all . ' ' . $border_style) . '; --wHelp-border-radius: ' . esc_attr($border_radius) . ';--wHelp-background: ' . esc_attr($bg_color) . '; --wHelp-hover-background: ' . esc_attr($bg_hover_color) . ';--wHelp-icon-normal-color: ' . esc_attr($normal_icon_color) . '; --wHelp-icon-hover-color: ' . esc_attr($hover_icon_color) . '; --wHelp-border-color: ' . esc_attr($border_color) . '; --wHelp-border-hover-color: ' . esc_attr($hover_border_color) . ';" target="' . esc_attr($open_in_new_tab) . '" href="' . esc_attr($url) . '" ' . esc_attr($gaAnalyticsAttr) . ' class="wHelp_button chat_help_analytics thank_you_page_button circle-bubble ' . esc_attr($thank_you_page_button_visibility) . '">';
            if ($circle_icon) {
                echo wp_kses_post($circle_icon);
            }
            echo '</a>';
        } else if ($thank_you_page_button_style === '2') {
            echo '<a style="--wHelp-padding: ' . esc_attr($padding) . '; --wHelp-btn-scale: ' . esc_attr($thank_you_page_button_size) . '; --wHelp-margin: ' . esc_attr($margin) . '; --wHelp-border: ' . esc_attr($border_all . ' ' . $border_style) . '; --wHelp-border-radius: ' . esc_attr($border_radius) . ';--wHelp-background: ' . esc_attr($bg_color) . '; --wHelp-hover-background: ' . esc_attr($bg_hover_color) . '; --wHelp-icon-normal-color: ' . esc_attr($normal_icon_color) . '; --wHelp-icon-hover-color: ' . esc_attr($hover_icon_color) . '; --wHelp-icon-normal-bg-color: ' . esc_attr($normal_bg_color) . '; --wHelp-icon-hover-bg-color: ' . esc_attr($hover_bg_color) . '; --wHelp-border-color: ' . esc_attr($border_color) . '; --wHelp-border-hover-color: ' . esc_attr($hover_border_color) . '; --wHelp-text-color: ' . esc_attr($text_color) . '; --wHelp-text-hover-color: ' . esc_attr($text_hover_color) . '; --wHelp-icon-border: ' . esc_attr($icon_border_all . ' ' . $icon_border_style) . '; --wHelp-icon-border-color: ' . esc_attr($icon_border_color) . '; --wHelp-hover-icon-border-color: ' . esc_attr($hover_icon_border_color) . '; --wHelp-icon-border-radius: ' . esc_attr($icon_border_radius) . ';" target="' . esc_attr($open_in_new_tab) . '" href="' . esc_attr($url) . '" ' . esc_attr($gaAnalyticsAttr) . ' class="wHelp_button chat_help_analytics thank_you_page_button ' . esc_attr($thank_you_page_button_visibility) . '">';
            if ($thank_you_page_button_icon_open !== 'no_icon' && $woo_button_icon) {
                echo '<span class="bubble__icon ' . esc_attr($icon_bg) . '">';
                echo wp_kses_post($woo_button_icon);
                echo '</span>';
            }
            echo esc_html($thank_you_page_button_text);
            echo '</a>';
        } else {
            echo '<div style="--wHelp-padding: ' . esc_attr($padding) . '; --wHelp-btn-scale: ' . esc_attr($thank_you_page_button_size) . '; --wHelp-margin: ' . esc_attr($margin) . '; --wHelp-border: ' . esc_attr($border_all . ' ' . $border_style) . '; --wHelp-border-radius: ' . esc_attr($border_radius) . ';--wHelp-background: ' . esc_attr($bg_color) . '; --wHelp-hover-background: ' . esc_attr($bg_hover_color) . '; --wHelp-border-color: ' . esc_attr($border_color) . '; --wHelp-border-hover-color: ' . esc_attr($hover_border_color) . '; --wHelp-text-color: ' . esc_attr($text_color) . '; --wHelp-text-hover-color: ' . esc_attr($text_hover_color) . '; --wHelp-icon-border: ' . esc_attr($icon_border_all . ' ' . $icon_border_style) . '; --wHelp-icon-border-color: ' . esc_attr($icon_border_color) . '; --wHelp-hover-icon-border-color: ' . esc_attr($hover_icon_border_color) . '; --wHelp-icon-border-radius: ' . esc_attr($icon_border_radius) . ';" ' . esc_attr($gaAnalyticsAttr) . ' class="wHelp_button wHelp_button_advance chat_help_analytics thank_you_page_button ' . esc_attr($thank_you_page_button_visibility) . '">';
            if ($agent_photo_url) {
                echo '<img decoding="async" src="' . esc_url($agent_photo_url) . '">';
            }
            echo '<div class="info-wrapper">
                        <div class="info">' . esc_html($agent_name) . '</div>
                        <div class="wHelp_title">' . esc_html($thank_you_page_button_text) . '</div>
                    </div>
				    <a href="' . esc_attr($url) . '" target="' . esc_attr($open_in_new_tab) . '" class="chat-link"></a>			
                </div>';
        }
        echo '</div>';
    }
}
