<?php

/**
 *
 * @package    Whatsapp chat support
 * @version    1.0
 * @author     ThemeAtelier
 * @Websites: https://themeatelier.net/
 */

namespace ThemeAtelier\ChatHelp\Frontend\Shortcode;

use ThemeAtelier\ChatHelp\Frontend\CustomButtonsTemplates;

class CustomShortcode
{
	public function ctw_custom_buttons_shortcode($atts)
	{
		$atts = shortcode_atts(
			array(
				'style'       => '1',
				'photo'       => CHAT_HELP_DIR_URL . 'src/assets/image/user.webp',
				'primary_color'       => '#118c7e',
				'secondary_color'       => '#0b5a51',
				'padding'       => '7px 18px 7px 10px',
				'name'        => esc_html__('Robert', 'chat-help'),
				'designation' => esc_html__('Sales Support', 'chat-help'),
				'label'       => esc_html__('How can I help you?', 'chat-help'),
				'online'      => esc_html__('I\'m avaiable', 'chat-help'),
				'offline'     => esc_html__('I\'m offline', 'chat-help'),
				'number'      => esc_html__('+8801813381520', 'chat-help'),
				'visibility'  => 'wHelp-show-everywhere',
				'sizes'       => 'wHelp-btn-md',
				'rounded'     => 'wHelp-btn-rounded',
				'timezone'    => '',
				'sunday'      => esc_html__('00:00-23:59', 'chat-help'),
				'monday'      => esc_html__('00:00-23:59', 'chat-help'),
				'tuesday'     => esc_html__('00:00-23:59', 'chat-help'),
				'wednesday'   => esc_html__('00:00-23:59', 'chat-help'),
				'thursday'    => esc_html__('00:00-23:59', 'chat-help'),
				'friday'      => esc_html__('00:00-23:59', 'chat-help'),
				'saturday'    => esc_html__('00:00-23:59', 'chat-help'),
				'bg_color' 	  => true,
			),
			$atts
		);

		ob_start();

		$button_obj = new CustomButtonsTemplates($atts);

		if (! empty($atts['style'])) {

			// Style Switch
			switch ($atts['style']) {
				case '1':
					$button_obj->ctw_button_s1();
					break;
				case '2':
					$button_obj->ctw_button_s2();
					break;
				default:
					$button_obj->ctw_button_s1();
					break;
			}
		}

		return ob_get_clean();
	}
}
