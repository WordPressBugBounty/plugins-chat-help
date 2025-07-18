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

use ThemeAtelier\ChatHelp\Helpers\Helpers;

/**
 * Class Buttons
 *
 * Handles the rendering of multiple templates in the plugin.
 *
 * @since 1.0.0
 */
class Buttons
{
    public static function buttons($options)
    {
        // Default Options
        $chat_type = $options['chat_layout'] ?? 'form';
        $open_in_new_tab = isset($options['open_in_new_tab']) ? $options['open_in_new_tab'] : '';
        $button_style = $options['opt-button-style'] ?? '1';
        $circle_button_icon = $options['circle-button-icon'] ?? 'icofont-brand-whatsapp';
        $circle_button_close = $options['circle-button-close'] ?? 'icofont-close';
        $circle_button_icon_1 = $options['circle-button-icon-1'] ?? 'icofont-brand-whatsapp';
        $circle_button_close_1 = $options['circle-button-close-1'] ?? 'icofont-close';
        $tooltip_enabled = $options['bubble_button_tooltip'] ?? true;
        $tooltip_text = $options['bubble_button_tooltip_text'] ?? 'Need Help? <strong>Chat with us</strong>';
        $circle_animation = $options['circle-animation'] ?? '3';
        $button_label = $options['bubble-text'] ?? '';
        $disable_icon = $options['disable-button-icon'] ?? true;
        $color_settings = $options['color_settings'] ?? '';
        $primary = $color_settings['primary'] ?? '#118c7e';
        $secondary = $color_settings['secondary'] ?? '#118c7e';
        $tooltip_class = '';
        if ($tooltip_enabled == 'on_hover') {
            $tooltip_class = 'hover_tooltip';
        }

        // Keep Button Style 1 as Is
        if ($button_style === '1') {
            $bubble_type = '<div class="wHelp-bubble circle-bubble circle-animation-' . esc_attr($circle_animation) . ' wHelp_' . $chat_type . ' ' . esc_attr($chat_type) . ' ' . esc_attr($tooltip_class) . '" style="--color-primary: ' . esc_attr($primary) . ';--color-secondary: ' . esc_attr($secondary) . ';">';
            $bubble_type .= '<span class="open-icon"><i class="' . esc_attr($circle_button_icon_1) . '"></i></span>';
            $bubble_type .= '<span class="close-icon"><i class="' . esc_attr($circle_button_close_1) . '"></i></span>';
            if ($chat_type == 'button') {
                $type_of_whatsapp = isset($options['type_of_whatsapp']) ? $options['type_of_whatsapp'] : '';
                $whatsapp_number = isset($options['opt-number']) ? $options['opt-number'] : '';
                $whatsapp_group = isset($options['opt-group']) ? $options['opt-group'] : '';

                $url_for_desktop = isset($options['url_for_desktop']) ? $options['url_for_desktop'] : '';
                $url_for_mobile = isset($options['url_for_mobile']) ? $options['url_for_mobile'] : '';
                $url = Helpers::whatsAppUrl($whatsapp_number, $type_of_whatsapp, $whatsapp_group, $url_for_desktop, $url_for_mobile);

                $open_in_new_tab = $open_in_new_tab ? '_blank' : '_self';
                $bubble_type .= '<a href="' . esc_url($url) . '" target="' . esc_attr($open_in_new_tab) . '" class="chat-link"></a>';
            }
            if ($tooltip_enabled != 'hide' && !empty($tooltip_text)) {
                $bubble_type .= '<span class="tooltip_text">' . wp_kses_post($tooltip_text) . '</span>';
            }
            $bubble_type .= '</div>';
            return $bubble_type;
        }

        // Optimize for All Other Button Styles
        $icons = '';
        if ($disable_icon) {
            $icons = '
            <div class="bubble__icon bubble-animation' . esc_attr($circle_animation) . '">
                <span class="bubble__icon--open"><i class="' . esc_attr($circle_button_icon) . '"></i></span>
                <span class="bubble__icon--close"><i class="' . esc_attr($circle_button_close) . '"></i></span>
            </div>';
        }

        $base_classes = 'wHelp-bubble bubble ';

        switch ($button_style) {
            case '2':
                $style_classes = 'wHelp-btn-bg';
                break;
            case '3':
                $style_classes = '';
                break;
            case '4':
                $style_classes = 'wHelp-btn-rounded wHelp-btn-bg';
                break;
            case '5':
                $style_classes = 'wHelp-btn-rounded';
                break;
            case '6':
                $style_classes = 'wHelp-btn-bg bubble-transparent btn-with-padding';
                break;
            case '7':
                $style_classes = 'bubble-transparent btn-with-padding';
                break;
            case '8':
                $style_classes = 'wHelp-btn-bg wHelp-btn-rounded bubble-transparent btn-with-padding';
                break;
            case '9':
                $style_classes = 'wHelp-btn-rounded bubble-transparent btn-with-padding';
                break;
            default:
                $style_classes = '';
                break;
        }

        $bubble_type = '<div class="' . esc_attr($base_classes . $style_classes . ' wHelp_' . $chat_type . ' ' . $tooltip_class) . '" style="--color-primary: ' . esc_attr($primary) . ';--color-secondary: ' . esc_attr($secondary) . ';">';
        $bubble_type .= $icons . esc_attr($button_label);

        // Add Tooltip
        if ($tooltip_enabled != 'hide' && $tooltip_text) {
            $bubble_type .= '<span class="tooltip_text">' . wp_kses_post($tooltip_text) . '</span>';
        }
        if ($chat_type === 'button') {
            $type_of_whatsapp = isset($options['type_of_whatsapp']) ? $options['type_of_whatsapp'] : '';
            $whatsapp_number = isset($options['opt-number']) ? $options['opt-number'] : '';
            $whatsapp_group = isset($options['opt-group']) ? $options['opt-group'] : '';

            $url_for_desktop = isset($options['url_for_desktop']) ? $options['url_for_desktop'] : '';
            $url_for_mobile = isset($options['url_for_mobile']) ? $options['url_for_mobile'] : '';
            $url = Helpers::whatsAppUrl($whatsapp_number, $type_of_whatsapp, $whatsapp_group, $url_for_desktop, $url_for_mobile);
            $open_in_new_tab = $open_in_new_tab ? '_blank' : '_self';
            $bubble_type .= '<a href="' . $url . '" target="' . esc_attr($open_in_new_tab) . '" class="chat-link"></a>';
        }
        $bubble_type .= '</div>';

        return $bubble_type;
    }
}
