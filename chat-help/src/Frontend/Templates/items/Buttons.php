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

namespace ThemeAtelier\ChatHelp\Frontend\Templates\items;

use ThemeAtelier\ChatHelp\Frontend\Helpers\Helpers;

/**
 * Class Buttons
 *
 * Handles the rendering of multiple templates in the plugin.
 *
 * @since 1.0.0
 */
class Buttons
{
    public static function buttons($options, $ch_settings)
    {
        $chat_type = $options['chat_layout'] ?? 'form';
        $open_in_new_tab = isset($ch_settings['open_in_new_tab']) ? $ch_settings['open_in_new_tab'] : '';
        $button_size = isset($options['button_size']) ? $options['button_size'] : '1';
        $floating_button_style = $options['opt-button-style'] ?? '1';
        $circle_button_icon = $options['circle-button-icon'] ?? 'icofont-brand-whatsapp';
        $circle_button_close = $options['circle-button-close'] ?? 'icofont-close';
        $circle_button_icon_1 = $options['circle-button-icon-1'] ?? 'icofont-brand-whatsapp';
        $circle_button_close_1 = $options['circle-button-close-1'] ?? 'icofont-close';
        $tooltip_enabled = $options['bubble_button_tooltip'] ?? true;
        $tooltip_text = $options['bubble_button_tooltip_text'] ?? 'Need Help? <strong>Chat with us</strong>';
        $circle_animation = !empty($options['circle-animation']) ? $options['circle-animation'] : '3';
        $button_label = $options['bubble-text'] ?? '';
        $color_settings = $options['color_settings'] ?? '';
        $tooltip_class = '';
        if ($tooltip_enabled == 'on_hover') {
            $tooltip_class = 'hover_tooltip';
        }
        $type_of_whatsapp = isset($options['type_of_whatsapp']) ? $options['type_of_whatsapp'] : '';
        $whatsapp_number = isset($options['opt-number']) ? $options['opt-number'] : '';
        $whatsapp_group = isset($options['opt-group']) ? $options['opt-group'] : '';
        $url_for_desktop = isset($ch_settings['url_for_desktop']) ? $ch_settings['url_for_desktop'] : '';
        $url_for_mobile = isset($ch_settings['url_for_mobile']) ? $ch_settings['url_for_mobile'] : '';
        $message = isset($options['prefilled_message']) ? $options['prefilled_message'] : '';
        $message = Helpers::replacement_vars($message);
        $url = Helpers::whatsAppUrl($whatsapp_number, $type_of_whatsapp, $whatsapp_group, $url_for_desktop, $url_for_mobile, $message);
        $open_in_new_tab = $open_in_new_tab ? '_blank' : '_self';

        // Determine the open icon
        if (!empty($circle_button_icon)) {
            $open_icon = '<i class="' . esc_attr($circle_button_icon) . '"></i>';
        } else {
            $open_icon = '<i class="icofont-brand-whatsapp"></i>';
        }

        // Determine the close icon
        if (!empty($circle_button_close)) {
            $close_icon = '<i class="' . esc_attr($circle_button_close) . '"></i>';
        } else {
            $close_icon = '<i class="icofont-close"></i>';
        }

        $color_settings = !empty($options['color_settings']) ? $options['color_settings'] : array();
        $color_primary = !empty($color_settings['primary']) ? $color_settings['primary'] : '#118c7e';
        $color_secondary = !empty($color_settings['secondary']) ? $color_settings['secondary'] : '#0b5a51';
        $button_bg = !empty($options['bubble_button_bg']) ? $options['bubble_button_bg'] : array();
        $bg_color = !empty($button_bg['normal_color']) ? $button_bg['normal_color'] : $color_primary;
        $bg_hover_color = !empty($button_bg['hover_color']) ? $button_bg['hover_color'] : $color_secondary;

        $bubble_button_text = !empty($options['bubble_button_text']) ? $options['bubble_button_text'] : array();
        $text_color = !empty($bubble_button_text['normal_color']) ? $bubble_button_text['normal_color'] : '#ffffff';
        $text_hover_color = !empty($bubble_button_text['hover_color']) ? $bubble_button_text['hover_color'] : '#ffffff';

        $bubble_icon_bg_color = !empty($options['bubble_icon_bg_color']) ? $options['bubble_icon_bg_color'] : array();
        $normal_bg_color = !empty($bubble_icon_bg_color['normal_color']) ? $bubble_icon_bg_color['normal_color'] : '#ffffff';
        $hover_bg_color = !empty($bubble_icon_bg_color['hover_color']) ? $bubble_icon_bg_color['hover_color'] : '#ffffff';
        $icon_bg = !empty($options['bubble_icon_bg']) ? 'icon_bg' : '';
        $bubble_icon_color = !empty($options['bubble_icon_color']) ? $options['bubble_icon_color'] : array();

        if ($floating_button_style == '2' && $icon_bg === 'icon_bg') {
            $normal_icon_color = !empty($bubble_icon_color['normal_color']) ? $bubble_icon_color['normal_color'] : $bg_color;
            $hover_icon_color = !empty($bubble_icon_color['hover_color']) ? $bubble_icon_color['hover_color'] : $bg_hover_color;
        } else {
            $normal_icon_color = !empty($bubble_icon_color['normal_color']) ? $bubble_icon_color['normal_color'] : '#ffffff';
            $hover_icon_color = !empty($bubble_icon_color['hover_color']) ? $bubble_icon_color['hover_color'] : '#ffffff';
        }

        $bubble_button_border = isset($options['bubble_button_border']) ? $options['bubble_button_border'] : array();
        $border_all = isset($bubble_button_border['all']) ? $bubble_button_border['all'] . 'px' : '0px';
        $border_style = isset($bubble_button_border['style']) ? $bubble_button_border['style'] : 'solid';
        $border_radius = isset($bubble_button_border['border_radius']) ? $bubble_button_border['border_radius'] . 'px' : '50px';
        $border_color = isset($bubble_button_border['color']) ? $bubble_button_border['color'] : '';
        $border_color = !empty($border_color) ? $border_color : $color_primary;
        $hover_border_color = isset($bubble_button_border['hover_color']) ? $bubble_button_border['hover_color'] : '';
        $hover_border_color = !empty($hover_border_color) ? $hover_border_color : $color_secondary;

        $bubble_icon_border = isset($options['bubble_icon_border']) ? $options['bubble_icon_border'] : array();
        $icon_border_all = isset($bubble_icon_border['all']) ? $bubble_icon_border['all'] . 'px' : '0px';
        $icon_border_style = isset($bubble_icon_border['style']) ? $bubble_icon_border['style'] : 'solid';
        $icon_border_color = isset($bubble_icon_border['color']) ? $bubble_icon_border['color'] : '';
        $icon_border_color = !empty($icon_border_color) ? $icon_border_color : $color_primary;
        $hover_icon_border_color = isset($bubble_icon_border['hover_color']) ? $bubble_icon_border['hover_color'] : '';
        $hover_icon_border_color = !empty($hover_icon_border_color) ? $hover_icon_border_color : $color_secondary;
        $icon_border_radius = isset($bubble_icon_border['border_radius']) ? $bubble_icon_border['border_radius'] . 'px' : '50px';

        // Bubble button paddings
        $bubble_button_padding = isset($options['bubble-button-padding']) ? $options['bubble-button-padding'] : array();
        $bubble_button_padding_top =  isset($bubble_button_padding['top']) ? $bubble_button_padding['top'] : '5';
        $bubble_button_padding_right =  isset($bubble_button_padding['right']) ? $bubble_button_padding['right'] : '15';
        $bubble_button_padding_bottom =  isset($bubble_button_padding['bottom']) ? $bubble_button_padding['bottom'] : '5';
        $bubble_button_padding_left =  isset($bubble_button_padding['left']) ? $bubble_button_padding['left'] : '6';
        $bubble_button_padding_unit = isset($bubble_button_padding['unit']) ? $bubble_button_padding['unit'] : 'px';

        $padding = $bubble_button_padding_top . $bubble_button_padding_unit . ' ' . $bubble_button_padding_right . $bubble_button_padding_unit . ' ' . $bubble_button_padding_bottom . $bubble_button_padding_unit . ' ' . $bubble_button_padding_left . $bubble_button_padding_unit;

        // Keep Button Style 1 as Is
        if ($floating_button_style === '1') {
            $bubble_type = '<div style="--wHelp-btn-scale: ' . esc_attr($button_size) . '; --wHelp-border: ' . esc_attr($border_all . ' ' . $border_style) . '; --wHelp-border-radius: ' . esc_attr($border_radius) . '; --wHelp-background: ' . esc_attr($bg_color) . '; --wHelp-hover-background: ' . esc_attr($bg_hover_color) . '; --wHelp-icon-normal-color: ' . esc_attr($normal_icon_color) . '; --wHelp-icon-hover-color: ' . esc_attr($hover_icon_color) . '; --wHelp-border-color: ' . esc_attr($border_color) . '; --wHelp-border-hover-color: ' . esc_attr($hover_border_color) . ';" class="wHelp_button wHelp-bubble circle-bubble circle-animation-' . esc_attr($circle_animation) . ' wHelp_' . $chat_type . ' layout_' . $chat_type . ' ' . esc_attr($chat_type) . ' ' . esc_attr($tooltip_class) . '">';
            $bubble_type .= '<span class="open-icon">';

            $bubble_type .= '<i class="' . esc_attr($circle_button_icon_1) . '"></i>';

            $bubble_type .= '</span>';
            $bubble_type .= '<span class="close-icon">';
            if ($circle_button_close_1 == 'custom') {
                if (!empty($circle_button_close_custom)) {
                    $bubble_type .= '<img src="' . esc_url($circle_button_close_custom) . '" alt="" />';
                } else {
                    $bubble_type .= '<i class="icofont-brand-whatsapp"></i>';
                }
            } else {
                $bubble_type .= '<i class="' . esc_attr($circle_button_close_1) . '"></i>';
            }
            $bubble_type .= '</span>';
            if ($chat_type == 'button') {
                $type_of_whatsapp = isset($options['type_of_whatsapp']) ? $options['type_of_whatsapp'] : '';
                $whatsapp_number = isset($options['opt-number']) ? $options['opt-number'] : '';
                $whatsapp_group = isset($options['opt-group']) ? $options['opt-group'] : '';

                $url_for_desktop = isset($ch_settings['url_for_desktop']) ? $ch_settings['url_for_desktop'] : '';
                $url_for_mobile = isset($ch_settings['url_for_mobile']) ? $ch_settings['url_for_mobile'] : '';
                $message = isset($options['prefilled_message']) ? $options['prefilled_message'] : '';
                $message = Helpers::replacement_vars($message);
                $url = Helpers::whatsAppUrl($whatsapp_number, $type_of_whatsapp, $whatsapp_group, $url_for_desktop, $url_for_mobile, $message);

                $open_in_new_tab = $open_in_new_tab ? '_blank' : '_self';
                $bubble_type .= '<a href="' . esc_attr($url) . '" target="' . esc_attr($open_in_new_tab) . '" class="chat-link chat_help_link"></a>';
            }
            if ($tooltip_enabled != 'hide' && !empty($tooltip_text)) {
                $bubble_type .= '<span class="tooltip_text">' . wp_kses_post($tooltip_text) . '</span>';
            }
            $bubble_type .= '</div>';
            return $bubble_type;
        } else if ($floating_button_style === '2') {
            // Optimize for All Other Button Styles
            $icons = '';
            if ($circle_button_icon !== 'no_icon') {
                // Generate the HTML
                $icons = '
                <div class="bubble__icon bubble-animation' . esc_attr($circle_animation . ' ' . $icon_bg) . '">
                    <span class="bubble__icon--open">' . $open_icon . '</span>
                    <span class="bubble__icon--close">' . $close_icon . '</span>
                </div>';
            }

            $bubble_type = '<div style="--wHelp-padding: ' . esc_attr($padding) . '; --wHelp-btn-scale: ' . esc_attr($button_size) . '; --wHelp-border: ' . esc_attr($border_all . ' ' . $border_style) . '; --wHelp-border-radius: ' . esc_attr($border_radius) . '; --wHelp-background: ' . esc_attr($bg_color) . '; --wHelp-hover-background: ' . esc_attr($bg_hover_color) . '; --wHelp-icon-normal-color: ' . esc_attr($normal_icon_color) . '; --wHelp-icon-hover-color: ' . esc_attr($hover_icon_color) . '; --wHelp-icon-normal-bg-color: ' . esc_attr($normal_bg_color) . '; --wHelp-icon-hover-bg-color: ' . esc_attr($hover_bg_color) . '; --wHelp-border-color: ' . esc_attr($border_color) . '; --wHelp-border-hover-color: ' . esc_attr($hover_border_color) . '; --wHelp-text-color: ' . esc_attr($text_color) . '; --wHelp-text-hover-color: ' . esc_attr($text_hover_color) . '; --wHelp-icon-border: ' . esc_attr($icon_border_all . ' ' . $icon_border_style) . '; --wHelp-icon-border-color: ' . esc_attr($icon_border_color) . '; --wHelp-hover-icon-border-color: ' . esc_attr($hover_icon_border_color) . '; --wHelp-icon-border-radius: ' . esc_attr($icon_border_radius) . ';" class="wHelp_button wHelp-bubble bubble ' . esc_attr(' wHelp_' . $chat_type . ' layout_' . $chat_type . ' ' . $tooltip_class) . '">';
            $bubble_type .= $icons . esc_attr($button_label);

            // Add Tooltip
            if ($tooltip_enabled != 'hide' && $tooltip_text) {
                $bubble_type .= '<span class="tooltip_text">' . wp_kses_post($tooltip_text) . '</span>';
            }
            if ($chat_type === 'button') {
                $type_of_whatsapp = isset($options['type_of_whatsapp']) ? $options['type_of_whatsapp'] : '';
                $whatsapp_number = isset($options['opt-number']) ? $options['opt-number'] : '';
                $whatsapp_group = isset($options['opt-group']) ? $options['opt-group'] : '';

                $url_for_desktop = isset($ch_settings['url_for_desktop']) ? $ch_settings['url_for_desktop'] : '';
                $url_for_mobile = isset($ch_settings['url_for_mobile']) ? $ch_settings['url_for_mobile'] : '';
                $message = isset($options['prefilled_message']) ? $options['prefilled_message'] : '';
                $message = Helpers::replacement_vars($message);
                $url = Helpers::whatsAppUrl($whatsapp_number, $type_of_whatsapp, $whatsapp_group, $url_for_desktop, $url_for_mobile, $message);
                $open_in_new_tab = $open_in_new_tab ? '_blank' : '_self';
                $bubble_type .= '<a href="' . esc_attr($url) . '" target="' . esc_attr($open_in_new_tab) . '" class="chat-link chat_help_link"></a>';
            }
            $bubble_type .= '</div>';
            return $bubble_type;
        }
    }
}
