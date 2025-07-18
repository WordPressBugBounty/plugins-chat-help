<?php

/**
 * Single Template Class
 *
 * This class handles the single template functionality for Chat Help.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package    chat-help
 * @subpackage chat-help/src/Frontend
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Frontend\Templates;

use ThemeAtelier\ChatHelp\Helpers\Helpers;

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
	public static function buttonTemplate($options, $bubble_type)
	{
		$optAvailablity = isset($options['opt-availablity']) ? $options['opt-availablity'] : '';
		$user_availability = Helpers::user_availability($optAvailablity);
		$bubble_position = isset($options['bubble-position']) ? $options['bubble-position'] : 'right_bottom';
		$bubble_style = isset($options['bubble-style']) ? $options['bubble-style'] : 'default';
		$select_timezone = isset($options['select-timezone']) ? $options['select-timezone'] : '';
		$bubble_visibility = isset($options['bubble-visibility']) ? $options['bubble-visibility'] : 'everywhere';

		echo '<div class="wHelp ' . esc_attr($bubble_position) . ' wHelp-' . esc_attr($bubble_visibility) . '-only ';

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
		</div>
<?php
	}
}
