<?php if (! defined('ABSPATH')) {
    die;
} // Cannot access directly.

/**
 * Update version.
 */
update_option('chat_help_version', CHAT_HELP_VERSION);
update_option('chat_help_db_version', CHAT_HELP_VERSION);

/**
 * Convert old data keys to new ones.
 */
function chat_help_convert_old_to_new_data_3_1_12($options)
{
    $options = get_option('cwp_option');
    $button_style = isset($options['opt-button-style']) ? $options['opt-button-style'] : '';
    $wooCommerce_button_style = isset($options['wooCommerce_button_style']) ? $options['wooCommerce_button_style'] : '';
    $disable_button_icon = isset($options['disable-button-icon']) ? $options['disable-button-icon'] : '';
    $button_size = isset($options['button_size']) ? $options['button_size'] : '';
    $wooCommerce_button_size = isset($options['wooCommerce_button_size']) ? $options['wooCommerce_button_size'] : '';
    $color_settings = isset($options['color_settings']) ? $options['color_settings'] : '';
    $primary = isset($color_settings['primary']) ? $color_settings['primary'] : '#118c7e';
    $secondary = isset($color_settings['secondary']) ? $color_settings['secondary'] : '#0b5a51';

    if ($button_style == '1') {
        $options['bubble_button_border']['border_radius'] = '50';
        $options['wooCommerce_button_border']['border_radius'] = '50';
    } else if ($button_style == '2') {
        $options['bubble_icon_bg'] = true;
        $options['bubble_button_border']['border_radius'] = '5';
        $options['wooCommerce_button_border']['border_radius'] = '5';
        $options['opt-button-style'] = '2';
        $options['wooCommerce_button_style'] = '2';
        $options['bubble_icon_bg'] = true;
    } else if ($button_style == '3') {
        $options['bubble_icon_bg'] = true;
        $options['bubble_button_border']['border_radius'] = '5';
        $options['wooCommerce_button_border']['border_radius'] = '5';
        $options['opt-button-style'] = '2';
        $options['wooCommerce_button_style'] = '2';
        $options['bubble_icon_bg'] = true;
        $options['bubble_button_border']['all'] = '1';
        $options['bubble_button_border']['color'] = $primary;
        $options['bubble_button_border']['hover_color'] = $secondary;
        $options['bubble_button_bg']['normal_color'] = '#ffffff';
        $options['bubble_button_bg']['hover_color'] = '#ffffff';
        $options['bubble_button_text']['normal_color'] = $primary;
        $options['bubble_button_text']['hover_color'] = $secondary;
        $options['bubble_icon_bg_color']['normal_color'] = $primary;
        $options['bubble_icon_bg_color']['hover_color'] = $secondary;
        $options['bubble-button-padding']['top'] = '5';
        $options['bubble-button-padding']['right'] = '15';
        $options['bubble-button-padding']['bottom'] = '5';
        $options['bubble-button-padding']['left'] = '6';
    } else if ($button_style == '4') {
        $options['opt-button-style'] = '2';
        $options['wooCommerce_button_style'] = '2';
        $options['bubble_icon_bg'] = true;
        $options['bubble_button_border']['border_radius'] = '50';
        $options['wooCommerce_button_border']['border_radius'] = '50';
    } else if ($button_style == '5') {
        $options['opt-button-style'] = '2';
        $options['wooCommerce_button_style'] = '2';
        $options['bubble_icon_bg'] = true;
        $options['bubble_button_border']['border_radius'] = '50';
        $options['wooCommerce_button_border']['border_radius'] = '50';
        $options['bubble_button_border']['all'] = '1';
        $options['bubble_button_border']['color'] = $primary;
        $options['bubble_button_border']['hover_color'] = $secondary;
        $options['bubble_button_bg']['normal_color'] = '#ffffff';
        $options['bubble_button_bg']['hover_color'] = '#ffffff';
        $options['bubble_button_text']['normal_color'] = $primary;
        $options['bubble_button_text']['hover_color'] = $secondary;
        $options['bubble_icon_bg_color']['normal_color'] = $primary;
        $options['bubble_icon_bg_color']['hover_color'] = $secondary;
    } else if ($button_style == '6') {
        $options['opt-button-style'] = '2';
        $options['wooCommerce_button_style'] = '2';
        $options['bubble_icon_bg'] = false;
        $options['bubble_button_border']['border_radius'] = '5';
        $options['wooCommerce_button_border']['border_radius'] = '5';
        $options['bubble-button-padding']['top'] = '5';
        $options['bubble-button-padding']['right'] = '15';
        $options['bubble-button-padding']['bottom'] = '5';
        $options['bubble-button-padding']['left'] = '6';
        $options['bubble-button-padding']['unit'] = 'px';
        $options['bubble_button_border']['all'] = '1';
        $options['bubble_button_border']['color'] = $primary;
        $options['bubble_button_border']['hover_color'] = $secondary;
        $options['bubble_button_bg']['normal_color'] = '#ffffff';
        $options['bubble_button_bg']['hover_color'] = '#ffffff';
        $options['bubble_button_text']['normal_color'] = $primary;
        $options['bubble_button_text']['hover_color'] = $secondary;
    } else if ($button_style == '7') {
        $options['opt-button-style'] = '2';
        $options['wooCommerce_button_style'] = '2';
        $options['bubble_icon_bg'] = false;
        $options['bubble_button_border']['border_radius'] = '5';
        $options['wooCommerce_button_border']['border_radius'] = '5';
        $options['bubble-button-padding']['top'] = '5';
        $options['bubble-button-padding']['right'] = '15';
        $options['bubble-button-padding']['bottom'] = '5';
        $options['bubble-button-padding']['left'] = '6';
        $options['bubble-button-padding']['unit'] = 'px';
        $options['bubble_button_bg']['normal_color'] = '#ffffff';
        $options['bubble_button_bg']['hover_color'] = '#ffffff';
        $options['bubble_button_text']['normal_color'] = '#ffffff';
        $options['bubble_button_text']['hover_color'] = '#ffffff';
    } else if ($button_style == '8') {
        $options['opt-button-style'] = '2';
        $options['wooCommerce_button_style'] = '2';
        $options['bubble_icon_bg'] = false;
        $options['bubble_button_border']['border_radius'] = '50';
        $options['wooCommerce_button_border']['border_radius'] = '50';
        $options['bubble-button-padding']['top'] = '5';
        $options['bubble-button-padding']['right'] = '15';
        $options['bubble-button-padding']['bottom'] = '5';
        $options['bubble-button-padding']['left'] = '6';
        $options['bubble-button-padding']['unit'] = 'px';
        $options['bubble_button_bg']['normal_color'] = '#ffffff';
        $options['bubble_button_bg']['hover_color'] = '#ffffff';
        $options['bubble_button_text']['normal_color'] = '#ffffff';
        $options['bubble_button_text']['hover_color'] = '#ffffff';
    } else if ($button_style == '9') {
        $options['opt-button-style'] = '2';
        $options['wooCommerce_button_style'] = '2';
        $options['bubble_icon_bg'] = false;
        $options['bubble_button_border']['border_radius'] = '50';
        $options['wooCommerce_button_border']['border_radius'] = '50';
        $options['bubble-button-padding']['top'] = '5';
        $options['bubble-button-padding']['right'] = '15';
        $options['bubble-button-padding']['bottom'] = '5';
        $options['bubble-button-padding']['left'] = '6';
        $options['bubble-button-padding']['unit'] = 'px';
        $options['bubble_button_border']['all'] = '1';
        $options['bubble_button_border']['color'] = $primary;
        $options['bubble_button_border']['hover_color'] = $secondary;
        $options['bubble_button_bg']['normal_color'] = '#ffffff';
        $options['bubble_button_bg']['hover_color'] = '#ffffff';
        $options['bubble_button_text']['normal_color'] = $primary;
        $options['bubble_button_text']['hover_color'] = $secondary;
    }

    if ($wooCommerce_button_style != '1') {
        $options['wooCommerce_button_style'] = '2';
    }

    if (!$disable_button_icon) {
        $options['circle-button-icon'] = 'no_icon';
    }
    if ($button_size == 'wHelp-btn-sm') {
        $options['button_size'] = 'small';
    } elseif ($button_size == 'wHelp-btn-lg') {
        $options['button_size'] = 'custom';
    } else {
        $options['button_size'] = 'medium';
    }
    if ($wooCommerce_button_size == 'wHelp-btn-sm') {
        $options['wooCommerce_button_size'] = 'small';
    } elseif ($wooCommerce_button_size == 'wHelp-btn-lg') {
        $options['wooCommerce_button_size'] = 'custom';
    } else {
        $options['wooCommerce_button_size'] = 'medium';
    }
    update_option('cwp_option', $options);
}

/**
 * Update old to new data.
 */
$options = get_option('cwp_option');
if ($options) {
    chat_help_convert_old_to_new_data_3_1_12($options);
}
