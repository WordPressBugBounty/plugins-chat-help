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
 * Class ButtonTemplate
 *
 * Handles the rendering of single templates in the plugin.
 *
 * @since 1.0.0
 */
class ButtonTemplate
{
	/**
	 * Handles single template logic.
	 *
	 * This method contains the logic to display or render single templates.
	 *
	 * @since 1.0.0
	 */
	public static function buttonTemplate($options, $bubble_type, $unique_id)
	{
		$optAvailablity = isset($options['opt-availablity']) ? $options['opt-availablity'] : '';
		$user_availability = Helpers::user_availability($optAvailablity);
		$bubble_position = isset($options['bubble-position']) ? $options['bubble-position'] : 'right_bottom';
		$bubble_style = isset($options['bubble-style']) ? $options['bubble-style'] : 'default';
		$select_timezone = isset($options['select-timezone']) ? $options['select-timezone'] : '';
		$bubble_visibility = isset($options['bubble-visibility']) ? $options['bubble-visibility'] : 'everywhere';
		$whatsapp_number = isset($options['opt-number']) ? $options['opt-number'] : '';
		$whatsapp_group = isset($options['opt-group']) ? $options['opt-group'] : '';

		echo '<div id="' . esc_attr($unique_id) . '" class="wHelp_bubble no_bubble wHelp ' . esc_attr($bubble_position) . ' wHelp-' . esc_attr($bubble_visibility) . '-only ';

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

		echo 'chat-availability" data-group="' . esc_attr($whatsapp_group) . '" data-number="' . esc_attr($whatsapp_number) . '" data-timezone="' . esc_attr($select_timezone) . '" data-availability="' . esc_attr($user_availability) . '">';
		echo wp_kses_post($bubble_type); ?>
		</div>
<?php
	}
}
