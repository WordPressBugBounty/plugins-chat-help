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
    public static function woo_button()
    {
        $options = get_option('cwp_option');
        $ch_wooCommerce = get_option('ch_wooCommerce');
        $ch_settings = get_option('ch_settings');
        $product_page_button_type_of_whatsapp = isset($ch_wooCommerce['product_page_button_type_of_whatsapp']) ? $ch_wooCommerce['product_page_button_type_of_whatsapp'] : '';
        $product_page_button_number = isset($ch_wooCommerce['product_page_button_number']) ? $ch_wooCommerce['product_page_button_number'] : '';
        $product_page_button_group = isset($ch_wooCommerce['product_page_button_group']) ? $ch_wooCommerce['product_page_button_group'] : '';
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
        $bg_color = !empty($button_bg['normal_color']) ? $button_bg['normal_color'] : $color_primary;
        $bg_hover_color = !empty($button_bg['hover_color']) ? $button_bg['hover_color'] : $color_secondary;

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
        $bg_color = !empty($button_bg['normal_color']) ? $button_bg['normal_color'] : $color_primary;
        $bg_hover_color = !empty($button_bg['hover_color']) ? $button_bg['hover_color'] : $color_secondary;

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
}
