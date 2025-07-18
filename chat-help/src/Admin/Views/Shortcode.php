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
						'type' => 'section_tab',
						'tabs' => array(
							array(
								'title' => esc_html__('Pick Shortcodes', 'chat-help'),
								'icon'  => 'icofont-code-alt',
								'fields' => array(
									array(
										'id'      => 'opt-shortcode-select',
										'type'    => 'image_select',
										'title'   => esc_html__('Select Button Style', 'chat-help'),
										'options' => array(
											'1' => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/button-with-info.svg',
											'2' => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/button2.svg',
										),
										'default' => '1',
									),
									array(
										'id'    => 'advance_button_shortcode',
										'type'    => 'shortcode',
										'shortcode_text'    => '[ctw style="1" primary_color="#118c7e" secondary_color="#0b5a51" padding="7px 18px 7px 10px" number="+8801849687969" timezone="Asia/Dhaka" photo="' . CHAT_HELP_DIR_URL . 'src/assets/image/user.webp" name="Jhon" designation="Techinical support" label="How can I help you?" online="I am online" offline="I am offline" visibility="wHelp-show-everywhere" sizes="wHelp-btn-lg" sunday="00:00-23:59" monday="23:00-23:59" tuesday="00:00-23:59" wednesday="00:00-23:59" thursday="00:00-23:59" friday="00:00-23:59" saturday="00:00-23:59"]',
										'title' => esc_html__('Shortcode', 'chat-help'),
										'title_help'       => '<div class="chat-help-info-label">' . __('Copy This Shortcode and Paste it in Any Pages/Posts/Widget. Edit Values as You Need.', 'chat-help') . '</div>',
										'dependency' => array('opt-shortcode-select', 'any', '1'),
									),

									array(
										'id'    => 'simple_button_shortcode',
										'type'    => 'shortcode',
										'shortcode_text'    => '[ctw style="2" primary_color="#118c7e" secondary_color="#0b5a51" padding="7px 18px 7px 10px" number="+8801849687969" label="How can I help you?" visibility="wHelp-show-everywhere" sizes="wHelp-btn-lg"]',
										'title' => esc_html__('Shortcode', 'chat-help'),
										'title_help'       => '<div class="chat-help-info-label">' . __('Copy This Shortcode and Paste it in Any Pages/Posts/Widget. Edit Values as You Need.', 'chat-help') . '</div>',
										'dependency' => array('opt-shortcode-select', 'any', '2'),
									),

								),
							),


							array(
								'title' => esc_html__('Webhooks', 'chat-help'),
								'icon'  => 'icofont-connection',
								'fields' => array(
									array(
										'type'    => 'subheading',
										'content' => 'Webhooks are automated HTTP POST requests that instantly transmit data to a specified URL when triggered by specific events. This allows applications to communicate in real time without requiring manual input. <a target="_blank" href="https://docs.themeatelier.net/docs/whatsapp-chat-help/shortcode/">Check WebHooks Documentation</a>',
									),
									array(
										'id' => 'shortcode_webhook_url',
										'type' => 'text',
										'title' => esc_html__('Webhook URL', 'chat-help'),
										'title_help' => '<div class="chat-help-info-label">' . esc_html__('Clicking on the WhatsApp shortcode buttons triggers this Webhook URL.', 'chat-help') . '</div>',
										'class'      => 'only-for-pro',
									),

									array(
										'id' => 'shortcode_webhook_values',
										'type' => 'repeater',
										'title' => esc_html__('Add Values', 'chat-help'),
										'class'      => 'only-for-pro',
										'fields' => array(
											array(
												'id'    => 'webhook_value',
												'type'  => 'text',
												'title' => esc_html__('Add Value', 'chat-help'),
											),
										),
										'desc'  => __('<p><b>Dynamic Variables:</b> {title}, {number}, {site_url}, {current_url}, {date}, {ip}</p>
										<h4>Retrieving Values from Cookies and URL Parameters</h4>
							   
										<p><b>Fetch URL Parameter Values: </b>To extract values from URL parameters, enclose the parameter name in single square brackets [ ]. If the parameter is missing, a blank value is returned.</p>
										<p><b>Example:</b> [gclid], [utm_source]</p>
					
										<p><b>Fetch Cookie Values:</b>To extract values from cookies, enclose the cookie name in double square brackets [[ ]]. If the cookie is missing, a blank value is returned.</p>
										<p><b>Example:</b> [[ _ga ]]</p>', 'chat-help'),
									),


								),
							),

						),
					),

				)

			)
		);
	}
}
