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
function chat_help_convert_data_3_2_0($options)
{
    $options = get_option('cwp_option');
    $ch_wooCommerce = get_option('ch_wooCommerce');
    $ch_settings = get_option('ch_settings');
    $wooCommerce_button = isset($options['wooCommerce_button']) ? $options['wooCommerce_button'] : '';
    $wooCommerce_button_type_of_whatsapp = isset($options['wooCommerce_button_type_of_whatsapp']) ? $options['wooCommerce_button_type_of_whatsapp'] : 'number';
    $wooCommerce_button_number = isset($options['wooCommerce_button_number']) ? $options['wooCommerce_button_number'] : '';
    $wooCommerce_button_group = isset($options['wooCommerce_button_group']) ? $options['wooCommerce_button_group'] : '';
    $wooCommerce_button_message = isset($options['wooCommerce_button_message']) ? $options['wooCommerce_button_message'] : '';
    $wooCommerce_button_position = isset($options['wooCommerce_button_position']) ? $options['wooCommerce_button_position'] : 'woocommerce_after_add_to_cart_form';
    $wooCommerce_button_style = isset($options['wooCommerce_button_style']) ? $options['wooCommerce_button_style'] : '2';
    $woo_agent_photo_type = isset($options['woo_agent_photo_type']) ? $options['woo_agent_photo_type'] : 'default';
    $woo_agent_photo = isset($options['woo_agent_photo']) ? $options['woo_agent_photo'] : '';
    $woo_button_top_label = isset($options['woo_button_top_label']) ? $options['woo_button_top_label'] : 'John Doe / Technical support';
    $wooCommerce_button_text = isset($options['wooCommerce_button_text']) ? $options['wooCommerce_button_text'] : 'How may I help you?';
    $wooCommerce_circle_button_icon = isset($options['wooCommerce_circle_button_icon']) ? $options['wooCommerce_circle_button_icon'] : 'icofont-brand-whatsapp';
    $wooCommerce_circle_button_icon_native = isset($options['wooCommerce_circle_button_icon_native']) ? $options['wooCommerce_circle_button_icon_native'] : 'icofont-brand-whatsapp';
    $wooCommerce_circle_button_icon_custom = isset($options['wooCommerce_circle_button_icon_custom']) ? $options['wooCommerce_circle_button_icon_custom'] : '';
    $wooCommerce_button_icon_open = isset($options['wooCommerce_button_icon_open']) ? $options['wooCommerce_button_icon_open'] : 'icofont-brand-whatsapp';
    $wooCommerce_button_icon_native = isset($options['wooCommerce_button_icon_native']) ? $options['wooCommerce_button_icon_native'] : 'icofont-brand-whatsapp';
    $wooCommerce_button_icon_custom = isset($options['wooCommerce_button_icon_custom']) ? $options['wooCommerce_button_icon_custom'] : 'icofont-brand-whatsapp';
    $wooCommerce_button_size = isset($options['wooCommerce_button_size']) ? $options['wooCommerce_button_size'] : 'medium';
    $wooCommerce_icon_color = isset($options['wooCommerce_icon_color']) ? $options['wooCommerce_icon_color'] : '';
    $wooCommerce_icon_bg = isset($options['wooCommerce_icon_bg']) ? $options['wooCommerce_icon_bg'] : '';
    $wooCommerce_icon_bg_color = isset($options['wooCommerce_icon_bg_color']) ? $options['wooCommerce_icon_bg_color'] : '';
    $wooCommerce_button_bg = isset($options['wooCommerce_button_bg']) ? $options['wooCommerce_button_bg'] : '';
    $wooCommerce_button_text_color = isset($options['wooCommerce_button_text_color']) ? $options['wooCommerce_button_text_color'] : '';
    $wooCommerce_button_border = isset($options['wooCommerce_button_border']) ? $options['wooCommerce_button_border'] : '';
    $wooCommerce_icon_border = isset($options['wooCommerce_icon_border']) ? $options['wooCommerce_icon_border'] : '';
    $wooCommerce_button_padding = isset($options['wooCommerce_button_padding']) ? $options['wooCommerce_button_padding'] : array('top' => '5', 'right' => '15', 'bottom' => '5', 'left' => '6', 'unit' => 'px');
    $wooCommerce_button_margin = isset($options['wooCommerce_button_margin']) ? $options['wooCommerce_button_margin'] : '';
    $wooCommerce_button_visibility = isset($options['wooCommerce_button_visibility']) ? $options['wooCommerce_button_visibility'] : 'everywhere';

    $cleanup_data_deletion = isset($options['cleanup_data_deletion']) ? $options['cleanup_data_deletion'] : '';
    $open_in_new_tab = isset($options['open_in_new_tab']) ? $options['open_in_new_tab'] : '';
    $url_for_desktop = isset($options['url_for_desktop']) ? $options['url_for_desktop'] : '';
    $url_for_mobile = isset($options['url_for_mobile']) ? $options['url_for_mobile'] : '';
    $google_analytics = isset($options['google_analytics']) ? $options['google_analytics'] : '';
    $event_name = isset($options['event_name']) ? $options['event_name'] : '';
    $google_analytics_parameter = isset($options['google_analytics_parameter']) ? $options['google_analytics_parameter'] : '';
    $whatsapp_custom_css = isset($options['whatsapp-custom-css']) ? $options['whatsapp-custom-css'] : '';
    $whatsapp_custom_js = isset($options['whatsapp-custom-js']) ? $options['whatsapp-custom-js'] : '';

    $license_key = isset($options['license_key']) ? $options['license_key'] : '';

    $button_size = isset($options['button_size']) ? $options['button_size'] : 'medium';
    $button_size_custom = isset($options["button_size_custom"]) ? $options["button_size_custom"] : '100';
    if ($button_size === 'custom') {
        $button_size = $button_size_custom / 100;
    }

    if ($button_size == 'small') {
        $options['button_size'] = '0.8';
    } elseif ($button_size == 'large') {
        $options['button_size'] = '1.2';
    } else {
        $options['button_size'] = '1';
    }
    if ($wooCommerce_button_size == 'small') {
        $wooCommerce_button_size = '0.8';
    } elseif ($wooCommerce_button_size == 'large') {
        $wooCommerce_button_size = '1.2';
    } else {
        $wooCommerce_button_size = '1';
    }

    $ch_wooCommerce['product_page_button'] = $wooCommerce_button;
    $ch_wooCommerce['product_page_button_type_of_whatsapp'] = $wooCommerce_button_type_of_whatsapp;
    $ch_wooCommerce['product_page_button_number'] = $wooCommerce_button_number;
    $ch_wooCommerce['product_page_button_group'] = $wooCommerce_button_group;
    $ch_wooCommerce['product_page_button_message'] = $wooCommerce_button_message;
    $ch_wooCommerce['product_page_button_position'] = $wooCommerce_button_position;
    $ch_wooCommerce['product_page_button_style'] = $wooCommerce_button_style;
    $ch_wooCommerce['product_page_agent_photo_type'] = $woo_agent_photo_type;
    $ch_wooCommerce['product_page_agent_photo'] = $woo_agent_photo;
    $ch_wooCommerce['product_page_button_top_label'] = $woo_button_top_label;
    $ch_wooCommerce['product_page_button_text'] = $wooCommerce_button_text;
    $ch_wooCommerce['product_page_circle_button_icon'] = $wooCommerce_circle_button_icon;
    $ch_wooCommerce['product_page_circle_button_icon_native'] = $wooCommerce_circle_button_icon_native;
    $ch_wooCommerce['product_page_circle_button_icon_custom'] = $wooCommerce_circle_button_icon_custom;
    $ch_wooCommerce['product_page_button_icon_open'] = $wooCommerce_button_icon_open;
    $ch_wooCommerce['product_page_button_icon_native'] = $wooCommerce_button_icon_native;
    $ch_wooCommerce['product_page_button_icon_custom'] = $wooCommerce_button_icon_custom;
    $ch_wooCommerce['product_page_button_size'] = $wooCommerce_button_size;
    $ch_wooCommerce['product_page_icon_color'] = $wooCommerce_icon_color;
    $ch_wooCommerce['product_page_icon_bg'] = $wooCommerce_icon_bg;
    $ch_wooCommerce['product_page_icon_bg_color'] = $wooCommerce_icon_bg_color;
    $ch_wooCommerce['product_page_button_bg'] = $wooCommerce_button_bg;
    $ch_wooCommerce['product_page_button_text_color'] = $wooCommerce_button_text_color;
    $ch_wooCommerce['product_page_button_border'] = $wooCommerce_button_border;
    $ch_wooCommerce['product_page_icon_border'] = $wooCommerce_icon_border;
    $ch_wooCommerce['product_page_button_padding'] = $wooCommerce_button_padding;
    $ch_wooCommerce['product_page_button_margin'] = $wooCommerce_button_margin;
    $ch_wooCommerce['product_page_button_visibility'] = $wooCommerce_button_visibility;

    $ch_settings['cleanup_data_deletion'] = $cleanup_data_deletion;
    $ch_settings['open_in_new_tab'] = $open_in_new_tab;
    $ch_settings['url_for_desktop'] = $url_for_desktop;
    $ch_settings['url_for_mobile'] = $url_for_mobile;
    $ch_settings['google_analytics'] = $google_analytics;
    $ch_settings['event_name'] = $event_name;
    $ch_settings['google_analytics_parameter'] = $google_analytics_parameter;
    $ch_settings['whatsapp_custom_css'] = $whatsapp_custom_css;
    $ch_settings['whatsapp_custom_js'] = $whatsapp_custom_js;
    $ch_settings['license_key'] = $license_key;

    update_option('ch_wooCommerce', $ch_wooCommerce);
    update_option('ch_settings', $ch_settings);

    $keys_to_remove = array(
        'wooCommerce_button',
        'wooCommerce_button_type_of_whatsapp',
        'wooCommerce_button_number',
        'wooCommerce_button_group',
        'wooCommerce_button_message',
        'wooCommerce_button_position',
        'wooCommerce_button_style',
        'woo_agent_photo_type',
        'woo_agent_photo',
        'woo_button_top_label',
        'wooCommerce_button_text',
        'wooCommerce_circle_button_icon',
        'wooCommerce_circle_button_icon_native',
        'wooCommerce_circle_button_icon_custom',
        'wooCommerce_button_icon_open',
        'wooCommerce_button_icon_native',
        'wooCommerce_button_icon_custom',
        'wooCommerce_button_size',
        'wooCommerce_icon_color',
        'wooCommerce_icon_bg',
        'wooCommerce_icon_bg_color',
        'wooCommerce_button_bg',
        'wooCommerce_button_text_color',
        'wooCommerce_button_border',
        'wooCommerce_icon_border',
        'wooCommerce_button_padding',
        'wooCommerce_button_margin',
        'wooCommerce_button_visibility',

        'cleanup_data_deletion',
        'open_in_new_tab',
        'url_for_desktop',
        'url_for_mobile',
        'google_analytics',
        'event_name',
        'google_analytics_parameter',
        'webhook_values',
        'whatsapp-custom-css',
        'whatsapp-custom-js',
        'license_key',
    );

    foreach ($keys_to_remove as $key) {
        if (isset($options[$key])) {
            unset($options[$key]);
        }
    }

    update_option('cwp_option', $options);
}

/**
 * Update old to new data.
 */
$cwp_option = get_option('cwp_option');
if ($cwp_option) {
    chat_help_convert_data_3_2_0($cwp_option);
}
