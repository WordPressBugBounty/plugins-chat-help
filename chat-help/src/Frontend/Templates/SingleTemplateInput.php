<?php

/**
 * Single Template Class
 *
 * This class handles the single template functionality for Chat WhatsApp Pro.
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
 * Class SingleTemplate
 *
 * Handles the rendering of single templates in the plugin.
 *
 * @since 1.0.0
 */
class SingleTemplateInput
{
	/**
	 * Handles single template logic.
	 *
	 * This method contains the logic to display or render single templates.
	 *
	 * @since 1.0.0
	 */
	public static function singleTemplateInput($options, $ch_settings, $bubble_type, $random, $whatsapp_message_template, $unique_id, $chat_type)
	{
		$optAvailablity = isset($options['opt-availablity']) ? $options['opt-availablity'] : '';
		$user_availability = Helpers::user_availability($optAvailablity);
		$agent_message = isset($options['agent_with_input_message']) ? $options['agent_with_input_message'] : 'Hello and Welcome. Is there anything I can help you with?';
		$show_current_time = isset($options['show_current_time']) ? $options['show_current_time'] : true;
		$gdpr_enable = isset($options['gdpr-enable']) ? $options['gdpr-enable'] : '';
		$gdpr_compliance_content = isset($options['gdpr-compliance-content']) ? $options['gdpr-compliance-content'] : 'Please accept our <a href="#">privacy policy</a> first to start a conversation.';
		$bubble_position = isset($options['bubble-position']) ? $options['bubble-position'] : 'right_bottom';
		$enable_positioning_tablet = isset($options['enable-positioning-tablet']) ? $options['enable-positioning-tablet'] : '';
		$bubble_position_tablet = isset($options['bubble-position-tablet']) ? $options['bubble-position-tablet'] : 'right_bottom';
		$enable_positioning_mobile = isset($options['enable-positioning-mobile']) ? $options['enable-positioning-mobile'] : '';
		$bubble_position_mobile = isset($options['bubble-position-mobile']) ? $options['bubble-position-mobile'] : 'right_bottom';
		$select_animation = isset($options['select-animation']) ? $options['select-animation'] : 'random';
		$bubble_style = isset($options['bubble-style']) ? $options['bubble-style'] : 'default';
		$select_timezone = isset($options['select-timezone']) ? $options['select-timezone'] : '';
		$header_content_position = isset($options['header-content-position']) ? $options['header-content-position'] : 'center';
		$before_chat_icon = isset($options['before-chat-icon']) ? $options['before-chat-icon'] : 'icofont-brand-whatsapp';
		$before_chat_icon_native = isset($options['before-chat-icon-native']) ? $options['before-chat-icon-native'] : 'icofont-brand-whatsapp';
		$before_chat_icon_custom = isset($options['before-chat-icon-custom']['url']) ? $options['before-chat-icon-custom']['url'] : '';
		$chat_button_text = isset($options['chat-button-text']) ? $options['chat-button-text'] : 'Send Message';
		$agent_photo = isset($options['agent-photo']) ? $options['agent-photo'] : '';
		$agent_photo_type = isset($options['agent_photo_type']) ? $options['agent_photo_type'] : 'default';
		$agent_photo_url = isset($agent_photo['url']) ? $agent_photo['url'] : '';

		if ($agent_photo_type === 'default') {
			$agent_photo_url = CHAT_HELP_DIR_URL . 'src/Frontend/assets/image/user.webp';
		} elseif ($agent_photo_type === 'custom' && $agent_photo_url) {
			$agent_photo_url;
		} elseif ($agent_photo_type === 'none') {
			$agent_photo_url = '';
		}
		$agent_name = isset($options['agent-name']) ? $options['agent-name'] : 'John Doe';
		$agent_subtitle = isset($options['agent-subtitle']) ? $options['agent-subtitle'] : 'Typically replies within a day';
		$offline_agent_subtitle = !empty($options['offline_agent_subtitle']) ? $options['offline_agent_subtitle'] : $agent_subtitle;
		$type_of_whatsapp = isset($options['type_of_whatsapp']) ? $options['type_of_whatsapp'] : '';
		$whatsapp_number = isset($options['opt-number']) ? $options['opt-number'] : '';
		$whatsapp_group = isset($options['opt-group']) ? $options['opt-group'] : '';
		$color_settings = isset($options['color_settings']) ? $options['color_settings'] : '';
		$primary = isset($color_settings['primary']) ? $color_settings['primary'] : '';
		$secondary = isset($color_settings['secondary']) ? $color_settings['secondary'] : '';
		$send_button_color = isset($options['send_button_color']) ? $options['send_button_color'] : '';
		$color = !empty($send_button_color['color']) ? $send_button_color['color'] : '#fff';
		$hover_color = !empty($send_button_color['hover_color']) ? $send_button_color['hover_color'] : '#fff';
		$background = !empty($send_button_color['background']) ? $send_button_color['background'] : $primary;
		$hover_background = !empty($send_button_color['hover_background']) ? $send_button_color['hover_background'] : $secondary;
		$floating_button_style = isset($options['opt-button-style']) ? $options['opt-button-style'] : '1';

		if ($type_of_whatsapp === 'group') {
			$gaAnalyticsAttr = 'data-group=' . $whatsapp_group . '';
		} else {
			$gaAnalyticsAttr = 'data-number=' . $whatsapp_number . '';
		}

		$bubble_visibility = isset($options['bubble-visibility']) ? $options['bubble-visibility'] : 'everywhere';
		// Method implementation goes here.
		if ('random' === $select_animation) :
			$animation = $random;
		else :
			$animation = !empty($select_animation) ? $select_animation : '14';
		endif;

		if ($enable_positioning_tablet) {
			$bubble_position_tablet = 'tablet_' . $bubble_position_tablet;
		} else {
			$bubble_position_tablet = '';
		}
		if ($enable_positioning_mobile) {
			$bubble_position_mobile = 'mobile_' . $bubble_position_mobile;
		} else {
			$bubble_position_mobile = '';
		}

		$button_style = '';
		if ($floating_button_style === '10') {
			$button_style = 'button_advance';
		}

		echo '<div id="' . esc_attr($unique_id) . '" class="wHelp_bubble wHelp ' . esc_attr($bubble_position . ' ' . $bubble_position_tablet . ' ' . $bubble_position_mobile . ' ' . $button_style) . ' wHelp-' . esc_attr($bubble_visibility) . '-only ';

		// Add bubble style classes based on the 'bubble-style' option.
		if ($bubble_style === 'dark') {
			echo 'dark-mode ';
		} elseif ($bubble_style === 'night') {
			echo 'night-mode ';
		}

		// Add position-specific class if position is 'left'.
		if ('left' === $bubble_position) {
			echo 'wHelp-left';
		}

		echo 'chat-availability" data-timezone="' . esc_attr($select_timezone) . '" data-availability="' . esc_attr($user_availability) . '">';
		echo wp_kses_post($bubble_type); ?>
		<div class="wHelp__popup animation<?php echo esc_attr($animation) ?> ">
			<?php
			include Helpers::chat_help_locate_template('items/single-template-header.php');
			include Helpers::chat_help_locate_template('items/agent-message.php');
			?>
		</div>
		</div>
<?php
	}
}
