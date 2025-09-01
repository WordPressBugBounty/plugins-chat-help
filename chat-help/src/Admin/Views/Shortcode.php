<?php

/**
 * Views class for Shortcode generator options.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/src/Admin/Views/Shortcode
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Views;

use ThemeAtelier\ChatHelp\Admin\Framework\Classes\Chat_Help;

class Shortcode
{
	/**
	 * Create Option fields for the setting options.
	 *
	 * @param string $prefix Option setting key prefix.
	 * @return void
	 */
	public static function options($prefix)
	{
		//
		// Field: shortcodes
		//
		Chat_Help::createSection(
			$prefix,
			array(
				'title'  => esc_html__('SHORTCODES', 'chat-help'),
				'icon'   => 'icofont-code-alt',
				'fields' => array(
					array(
                        'id'      => 'opt-shortcode-select',
                        'type'    => 'layout_preset',
                        'title'     => esc_html__('Select Button Style', 'chat-help'),
                        'title_help' =>
                        '<div class="chat-help-info-label">' .
                            esc_html__('Choose between Simple or Advanced button styles for the shortcode. The Advanced style supports agent details (photo, name, designation), while the Simple style is a basic WhatsApp button.', 'chat-help') .
                            '</div>' .
                            ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'button-shortcode/?ref=1') . '">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/shortcodes/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                        'options' => array(
                            '1' => array(
                                'image'           => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/button-with-info.svg',
                                'text'            => esc_html__('Advance Button', 'chat-help'),
                                'option_demo_url' => CHAT_HELP_DEMO_URL . 'button-shortcode#btn_demo',
                            ),
                            '2' => array(
                                'image'           => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/button2.svg',
                                'text'            => esc_html__('Simple Button', 'chat-help'),
                                'option_demo_url' => CHAT_HELP_DEMO_URL . 'button-shortcode#simple-button',
                            ),
                        ),
                        'default' => '1',
                    ),

                    array(
                        'id'    => 'advance_button_shortcode',
                        'type'  => 'shortcode',
                        'title' => esc_html__('Shortcode', 'chat-help'),
                        'title_help' =>
                        '<div class="chat-help-info-label">' .
                            esc_html__('Copy this shortcode and paste it into any page, post, or widget area. You can also edit its attributes to customize the output.', 'chat-help') .
                            '</div>' .
                            ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'button-shortcode/?ref=1') . '">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/shortcodes/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                        'dependency' => array('opt-shortcode-select', 'any', '1'),
                        'shortcode_text'    => '[chat_help style="1" primary_color="#118c7e" secondary_color="#0b5a51" padding="10px 18px 10px 18px" type_of_whatsapp="number" number="+880123456789" group="" message="Hi! I have a question about your service." timezone="Asia/Dhaka" photo="' . CHAT_HELP_DIR_URL . 'src/assets/image/user.webp" name="Jhon" designation="Techinical support" label="How can I help you?" online="I am online" offline="I am offline" visibility="wHelp-show-everywhere" sizes="wHelp-btn-lg" sunday="00:00-23:59" monday="00:00-23:59" tuesday="00:00-23:59" wednesday="00:00-23:59" thursday="00:00-23:59" friday="00:00-23:59" saturday="00:00-23:59"]',
                    ),
                    array(
                        'id'    => 'simple_button_shortcode',
                        'type'  => 'shortcode',
                        'title' => esc_html__('Shortcode', 'chat-help'),
                        'title_help' =>
                        '<div class="chat-help-info-label">' .
                            esc_html__('Copy this shortcode and paste it into any page, post, or widget area. You can also edit its attributes to customize the output.', 'chat-help') .
                            '</div>' .
                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/simple-shortcode/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                        'dependency' => array('opt-shortcode-select', 'any', '2'),
                        'shortcode_text'    => '[chat_help style="2" primary_color="#118c7e" secondary_color="#0b5a51" padding="10px 18px 10px 18px" type_of_whatsapp="number" number="+880123456789" group="" message="Hi! I have a question about your service." label="How can I help you?" visibility="wHelp-show-everywhere" sizes="wHelp-btn-lg"]',
                    ),
				)

			)
		);
	}
}
