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
        $wooCommerce_button_type_of_whatsapp = isset($options['wooCommerce_button_type_of_whatsapp']) ? $options['wooCommerce_button_type_of_whatsapp'] : '';
        $wooCommerce_button_number = isset($options['wooCommerce_button_number']) ? $options['wooCommerce_button_number'] : '';
        $wooCommerce_button_group = isset($options['wooCommerce_button_group']) ? $options['wooCommerce_button_group'] : '';
        $wooCommerce_circle_button_icon = isset($options['wooCommerce_circle_button_icon']) ? $options['wooCommerce_circle_button_icon'] : 'icofont-brand-whatsapp';
        $wooCommerce_button_icon_open = !empty($options['wooCommerce_button_icon_open']) ? $options['wooCommerce_button_icon_open'] : 'icofont-brand-whatsapp';

        $wooCommerce_button_text = isset($options['wooCommerce_button_text']) ? $options['wooCommerce_button_text'] : 'How may I help you?';
        $wooCommerce_button_size = isset($options['wooCommerce_button_size']) ? $options['wooCommerce_button_size'] : 'medium';
        $wooCommerce_button_visibility = isset($options['wooCommerce_button_visibility']) ? $options['wooCommerce_button_visibility'] : 'everywhere';
        $wooCommerce_button_visibility = 'wooCommerce-' . $wooCommerce_button_visibility . '-only';
        $wooCommerce_button_style = isset($options['wooCommerce_button_style']) ? $options['wooCommerce_button_style'] : '2';
        $color_settings = !empty($options['color_settings']) ? $options['color_settings'] : array();
        $color_primary = !empty($color_settings['primary']) ? $color_settings['primary'] : '#118c7e';
        $color_secondary = !empty($color_settings['secondary']) ? $color_settings['secondary'] : '#0b5a51';

        $button_bg = !empty($options['wooCommerce_button_bg']) ? $options['wooCommerce_button_bg'] : array();
        $bg_color = !empty($button_bg['normal_color']) ? $button_bg['normal_color'] : $color_primary;
        $bg_hover_color = !empty($button_bg['hover_color']) ? $button_bg['hover_color'] : $color_secondary;

        $button_text = !empty($options['wooCommerce_button_text_color']) ? $options['wooCommerce_button_text_color'] : array();
        $text_color = !empty($button_text['normal_color']) ? $button_text['normal_color'] : '#ffffff';
        $text_hover_color = !empty($button_text['hover_color']) ? $button_text['hover_color'] : '#ffffff';

        $wooCommerce_icon_bg_color = !empty($options['wooCommerce_icon_bg_color']) ? $options['wooCommerce_icon_bg_color'] : array();
        $normal_bg_color = !empty($wooCommerce_icon_bg_color['normal_color']) ? $wooCommerce_icon_bg_color['normal_color'] : '#ffffff';
        $hover_bg_color = !empty($wooCommerce_icon_bg_color['hover_color']) ? $wooCommerce_icon_bg_color['hover_color'] : '#ffffff';
        $icon_bg = !empty($options['wooCommerce_icon_bg']) ? 'icon_bg' : '';
        $wooCommerce_icon_color = !empty($options['wooCommerce_icon_color']) ? $options['wooCommerce_icon_color'] : array();

        if ($wooCommerce_button_style == '2' && $icon_bg === 'icon_bg') {
            $normal_icon_color = !empty($wooCommerce_icon_color['normal_color']) ? $wooCommerce_icon_color['normal_color'] : $bg_color;
            $hover_icon_color = !empty($wooCommerce_icon_color['hover_color']) ? $wooCommerce_icon_color['hover_color'] : $bg_hover_color;
        } else {
            $normal_icon_color = !empty($wooCommerce_icon_color['normal_color']) ? $wooCommerce_icon_color['normal_color'] : '#ffffff';
            $hover_icon_color = !empty($wooCommerce_icon_color['hover_color']) ? $wooCommerce_icon_color['hover_color'] : '#ffffff';
        }

        $url_for_desktop = isset($options['url_for_desktop']) ? $options['url_for_desktop'] : '';
        $url_for_mobile = isset($options['url_for_mobile']) ? $options['url_for_mobile'] : '';

        $wooCommerce_button_border = isset($options['wooCommerce_button_border']) ? $options['wooCommerce_button_border'] : array();
        $border_all = isset($wooCommerce_button_border['all']) ? $wooCommerce_button_border['all'] . 'px' : '0px';
        $border_style = isset($wooCommerce_button_border['style']) ? $wooCommerce_button_border['style'] : 'solid';
        $border_radius = isset($wooCommerce_button_border['border_radius']) ? $wooCommerce_button_border['border_radius'] . 'px' : '50px';
        $border_color = isset($wooCommerce_button_border['color']) ? $wooCommerce_button_border['color'] : '';
        $border_color = !empty($border_color) ? $border_color : $color_primary;
        $hover_border_color = isset($wooCommerce_button_border['hover_color']) ? $wooCommerce_button_border['hover_color'] : '';
        $hover_border_color = !empty($hover_border_color) ? $hover_border_color : $color_secondary;

        $wooCommerce_icon_border = isset($options['wooCommerce_icon_border']) ? $options['wooCommerce_icon_border'] : array();
        $icon_border_all = isset($wooCommerce_icon_border['all']) ? $wooCommerce_icon_border['all'] . 'px' : '0px';
        $icon_border_style = isset($wooCommerce_icon_border['style']) ? $wooCommerce_icon_border['style'] : 'solid';
        $icon_border_radius = isset($wooCommerce_icon_border['border_radius']) ? $wooCommerce_icon_border['border_radius'] . 'px' : '50px';
        $icon_border_color = isset($wooCommerce_icon_border['color']) ? $wooCommerce_icon_border['color'] : '';
        $icon_border_color = !empty($icon_border_color) ? $icon_border_color : $color_primary;
        $hover_icon_border_color = isset($wooCommerce_icon_border['hover_color']) ? $wooCommerce_icon_border['hover_color'] : '';
        $hover_icon_border_color = !empty($hover_icon_border_color) ? $hover_icon_border_color : $color_secondary;

        // Bubble button paddings
        $wooCommerce_button_padding = isset($options['wooCommerce_button_padding']) ? $options['wooCommerce_button_padding'] : array();
        $wooCommerce_button_padding_top =  isset($wooCommerce_button_padding['top']) ? $wooCommerce_button_padding['top'] : '5';
        $wooCommerce_button_padding_right =  isset($wooCommerce_button_padding['right']) ? $wooCommerce_button_padding['right'] : '15';
        $wooCommerce_button_padding_bottom =  isset($wooCommerce_button_padding['bottom']) ? $wooCommerce_button_padding['bottom'] : '5';
        $wooCommerce_button_padding_left =  isset($wooCommerce_button_padding['left']) ? $wooCommerce_button_padding['left'] : '6';
        $wooCommerce_button_padding_unit = isset($wooCommerce_button_padding['unit']) ? $wooCommerce_button_padding['unit'] : 'px';

        $padding = $wooCommerce_button_padding_top . $wooCommerce_button_padding_unit . ' ' . $wooCommerce_button_padding_right . $wooCommerce_button_padding_unit . ' ' . $wooCommerce_button_padding_bottom . $wooCommerce_button_padding_unit . ' ' . $wooCommerce_button_padding_left . $wooCommerce_button_padding_unit;
        // Bubble button margins
        $wooCommerce_button_margin = isset($options['wooCommerce_button_margin']) ? $options['wooCommerce_button_margin'] : array();
        $wooCommerce_button_margin_top =  isset($wooCommerce_button_margin['top']) ? $wooCommerce_button_margin['top'] : '5';
        $wooCommerce_button_margin_right =  isset($wooCommerce_button_margin['right']) ? $wooCommerce_button_margin['right'] : '15';
        $wooCommerce_button_margin_bottom =  isset($wooCommerce_button_margin['bottom']) ? $wooCommerce_button_margin['bottom'] : '5';
        $wooCommerce_button_margin_left =  isset($wooCommerce_button_margin['left']) ? $wooCommerce_button_margin['left'] : '6';
        $wooCommerce_button_margin_unit = isset($wooCommerce_button_margin['unit']) ? $wooCommerce_button_margin['unit'] : 'px';

        $margin = $wooCommerce_button_margin_top . $wooCommerce_button_margin_unit . ' ' . $wooCommerce_button_margin_right . $wooCommerce_button_margin_unit . ' ' . $wooCommerce_button_margin_bottom . $wooCommerce_button_margin_unit . ' ' . $wooCommerce_button_margin_left . $wooCommerce_button_margin_unit;

        $message = isset($options['wooCommerce_button_message']) ? $options['wooCommerce_button_message'] : '';
        $message = Helpers::replacement_vars($message);

        $url = Helpers::whatsAppUrl($wooCommerce_button_number, $wooCommerce_button_type_of_whatsapp, $wooCommerce_button_group, $url_for_desktop, $url_for_mobile, $message);
        $open_in_new_tab = isset($options['open_in_new_tab']) ? $options['open_in_new_tab'] : '';
        $open_in_new_tab = $open_in_new_tab ? '_blank' : '_self';

        if ($wooCommerce_button_type_of_whatsapp === 'group') {
            $gaAnalyticsAttr = 'data-group=' . $wooCommerce_button_group . '';
        } else {
            $gaAnalyticsAttr = 'data-number=' . $wooCommerce_button_number . '';
        }

        if (!empty($wooCommerce_circle_button_icon)) {
            $circle_icon = '<i class="' . esc_attr($wooCommerce_circle_button_icon) . '"></i>';
        } else {
            $circle_icon = '<i class="icofont-brand-whatsapp"></i>';
        }

        if (!empty($wooCommerce_button_icon_open)) {
            $woo_button_icon = '<i class="' . esc_attr($wooCommerce_button_icon_open) . '"></i>';
        } else {
            $woo_button_icon = '<i class="icofont-brand-whatsapp"></i>';
        }

        if ($wooCommerce_button_style === '1') {
            echo '<a style="--wHelp-margin: ' . esc_attr($margin) . '; --wHelp-border: ' . esc_attr($border_all . ' ' . $border_style) . '; --wHelp-border-radius: ' . esc_attr($border_radius) . ';--wHelp-background: ' . esc_attr($bg_color) . '; --wHelp-hover-background: ' . esc_attr($bg_hover_color) . ';--wHelp-icon-normal-color: ' . esc_attr($normal_icon_color) . '; --wHelp-icon-hover-color: ' . esc_attr($hover_icon_color) . '; --wHelp-border-color: ' . esc_attr($border_color) . '; --wHelp-border-hover-color: ' . esc_attr($hover_border_color) . ';" target="' . esc_attr($open_in_new_tab) . '" href="' . esc_attr($url) . '" ' . esc_attr($gaAnalyticsAttr) . ' class="wHelp_button chat_help_analytics wooCommerce_button circle-bubble ' . esc_attr($wooCommerce_button_visibility . ' ' . $wooCommerce_button_size) . '">';
            if ($circle_icon) {
                echo wp_kses_post($circle_icon);
            }
            echo '</a>';
        } else {
            echo '<a style="--wHelp-padding: ' . esc_attr($padding) . '; --wHelp-margin: ' . esc_attr($margin) . '; --wHelp-border: ' . esc_attr($border_all . ' ' . $border_style) . '; --wHelp-border-radius: ' . esc_attr($border_radius) . ';--wHelp-background: ' . esc_attr($bg_color) . '; --wHelp-hover-background: ' . esc_attr($bg_hover_color) . '; --wHelp-icon-normal-color: ' . esc_attr($normal_icon_color) . '; --wHelp-icon-hover-color: ' . esc_attr($hover_icon_color) . '; --wHelp-icon-normal-bg-color: ' . esc_attr($normal_bg_color) . '; --wHelp-icon-hover-bg-color: ' . esc_attr($hover_bg_color) . '; --wHelp-border-color: ' . esc_attr($border_color) . '; --wHelp-border-hover-color: ' . esc_attr($hover_border_color) . '; --wHelp-text-color: ' . esc_attr($text_color) . '; --wHelp-text-hover-color: ' . esc_attr($text_hover_color) . '; --wHelp-icon-border: ' . esc_attr($icon_border_all . ' ' . $icon_border_style) . '; --wHelp-icon-border-color: ' . esc_attr($icon_border_color) . '; --wHelp-hover-icon-border-color: ' . esc_attr($hover_icon_border_color) . '; --wHelp-icon-border-radius: ' . esc_attr($icon_border_radius) . ';" target="' . esc_attr($open_in_new_tab) . '" href="' . esc_attr($url) . '" ' . esc_attr($gaAnalyticsAttr) . ' class="wHelp_button chat_help_analytics wooCommerce_button ' . esc_attr($wooCommerce_button_size . ' ' . $wooCommerce_button_visibility) . '">';
            if ($wooCommerce_button_icon_open !== 'no_icon' && $woo_button_icon) {
                echo '<span class="bubble__icon ' . esc_attr($icon_bg) . '">';
                echo wp_kses_post($woo_button_icon);
                echo '</span>';
            }
            echo esc_html($wooCommerce_button_text);
            echo '</a>';
        }
    }
}
