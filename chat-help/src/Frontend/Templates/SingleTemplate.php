<?php

/**
 * Single Template Class
 *
 * This class handles the single template functionality for ChatHelp.
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

/**
 * Class SingleTemplate
 *
 * Handles the rendering of single templates in the plugin.
 *
 * @since 1.0.0
 */
class SingleTemplate
{
	/**
	 * Handles single template logic.
	 *
	 * This method contains the logic to display or render single templates.
	 *
	 * @since 1.0.0
	 */
	public static function singleTemplate($options, $bubble_type, $random, $whatsapp_message_template, $unique_id)
	{
		$optAvailablity 	= isset($options['opt-availablity']) ? $options['opt-availablity'] : '';
		$user_availability 	= Helpers::user_availability($optAvailablity);
		$agent_message 		= isset($options['agent-message']) ? $options['agent-message'] : 'Hello, Welcome to the site. Please click below button for chating me throught WhatsApp.';
		$show_current_time 	= isset($options['show_current_time']) ? $options['show_current_time'] : true;
		$gdpr_enable 		= isset($options['gdpr-enable']) ? $options['gdpr-enable'] : '';
		$gdpr_compliance_content = isset($options['gdpr-compliance-content']) ? $options['gdpr-compliance-content'] : 'Please accept our <a href="#">privacy policy</a> first to start a conversation.';
		$bubble_position 	= isset($options['bubble-position']) ? $options['bubble-position'] : 'right_bottom';
		$select_animation 	= isset($options['select-animation']) ? $options['select-animation'] : 'random';
		$bubble_style 		= isset($options['bubble-style']) ? $options['bubble-style'] : 'default';
		$select_timezone 	= isset($options['select-timezone']) ? $options['select-timezone'] : '';
		$header_content_position = isset($options['header-content-position']) ? $options['header-content-position'] : 'center';
		$before_chat_icon 	= isset($options['before-chat-icon']) ? $options['before-chat-icon'] : 'icofont-brand-whatsapp';
		$chat_button_text 	= isset($options['chat-button-text']) ? $options['chat-button-text'] : 'Send a message';
		$agent_photo 	= isset($options['agent-photo']) ? $options['agent-photo'] : '';
		$agent_name 	= isset($options['agent-name']) ? $options['agent-name'] : 'John Doe';
		$agent_subtitle = isset($options['agent-subtitle']) ? $options['agent-subtitle'] : 'Typically replies within a day';
		$bubble_visibility = isset($options['bubble-visibility']) ? $options['bubble-visibility'] : 'everywhere';
		$type_of_whatsapp = isset($options['type_of_whatsapp']) ? $options['type_of_whatsapp'] : '';
		$whatsapp_number = isset($options['opt-number']) ? $options['opt-number'] : '';
		$whatsapp_group = isset($options['opt-group']) ? $options['opt-group'] : '';
		$color_settings = isset($options['color_settings']) ? $options['color_settings'] : '';
		$primary = isset($color_settings['primary']) ? $color_settings['primary'] : '#118c7e';
		$secondary = isset($color_settings['secondary']) ? $color_settings['secondary'] : '#118c7e';
		$send_button_color = isset($options['send_button_color']) ? $options['send_button_color'] : '';
		$color = '#fff';
		$hover_color = '#fff';
		$background = $primary;
		$hover_background = $secondary;

		if ($type_of_whatsapp === 'group') {
			$gaAnalyticsAttr = 'data-group=' . $whatsapp_group . '';
		} else {
			$gaAnalyticsAttr = 'data-number=' . $whatsapp_number . '';
		}
		
		// Method implementation goes here.
		if ('random' === $select_animation) :
			$animation = $random;
		else :
			$animation = !empty($select_animation) ? $select_animation : '14';
		endif;

		echo '<div id="' . esc_attr($unique_id) . '" class="wHelp_bubble wHelp ' . esc_attr($bubble_position) . ' wHelp-' . esc_attr($bubble_visibility) . '-only ';

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
			// include Helpers::chat_help_locate_template('items/template-footer.php');
			?>
			
		</div>
		</div>
<?php
	}
}
