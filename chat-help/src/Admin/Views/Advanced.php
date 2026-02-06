<?php

/**
 * Views class for Shortcode generator options.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/src/Admin/Views/Advanced
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Views;

use ThemeAtelier\ChatHelp\Admin\Framework\Classes\Chat_Help;

class Advanced
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
		// Field: advance
		//
		Chat_Help::createSection(
			$prefix,
			array(
				'title'  => esc_html__('ADVANCED', 'chat-help'),
				'icon'   => 'icofont-ui-settings',
				'fields'      => array(
					array(
						'type' => 'section_tab',
						'tabs' => array(
							array(
								'title' => esc_html__('Advanced Controls', 'chat-help'),
								'icon'  => 'icofont-gears',
								'fields' => array(
									array(
										'id'      => 'cleanup_data_deletion',
										'type'    => 'checkbox',
										'title' => esc_html__('Clean-up Data on Deletion', 'chat-help'),
										'title_help' =>
										'<div class="chat-help-info-label">' .
											esc_html__('Enable this option to completely remove all Chat Help plugin data when the plugin is deleted from your site.', 'chat-help') .
											'</div>' .
											' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/advanced-controls/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

									),
									array(
										'type' => 'heading',
										'content' => esc_html__('WhatsApp URL', 'chat-help'),
									),

									array(
										'id'      => 'open_in_new_tab',
										'type'    => 'switcher',
										'title'   => esc_html__('Open in New Tab', 'chat-help'),
										'default' => true,
										'title_help' =>
										'<div class="chat-help-info-label">' .
											esc_html__('Enable this option to open the WhatsApp chat link in a new browser tab when clicked.', 'chat-help') .
											'</div>' .
											' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/advanced-controls/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

									),
									array(
										'id' => 'url_for_desktop',
										'type' => 'button_set',
										'title'   => esc_html__('URL for Desktop', 'chat-help'),
										'options' => array(
											'api' => esc_html__('API', 'chat-help'),
											'web' => esc_html__('Web', 'chat-help'),
										),
										'title_help' =>
										'<div class="chat-help-info-label">' .
											esc_html__('Choose how WhatsApp opens on desktop devices: "API" uses the WhatsApp application, while "Web" opens WhatsApp Web in the browser.', 'chat-help') .
											'</div>' .
											' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/advanced-controls/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

										'default' => 'api',
									),
									array(
										'id'      => 'url_for_mobile',
										'type'    => 'button_set',
										'title'   => esc_html__('URL for Mobile', 'chat-help'),
										'options' => array(
											'api'      => esc_html__('API', 'chat-help'),
											'protocol' => esc_html__('Protocol', 'chat-help'),
										),
										'title_help' =>
										'<div class="chat-help-info-label">' .
											esc_html__('Choose how WhatsApp opens on mobile devices: "API" uses the standard WhatsApp API link, while "Protocol" directly triggers the WhatsApp app via protocol handler.', 'chat-help') .
											'</div>' .
											' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/advanced-controls/?ref=3') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

										'default' => 'api',
									),
								)
							),
							array(
								'title' => esc_html__('Analytics', 'chat-help'),
								'icon'  => 'icofont-chart-bar-graph',
								'fields' => array(
									array(
										'id'      => 'google_analytics',
										'type'    => 'switcher',
										'title'   => esc_html__('Google Analytics', 'chat-help'),
										'default' => true,
										'title_help' =>
										'<div class="chat-help-info-label">' .
											esc_html__('Enable tracking of WhatsApp button clicks and interactions in Google Analytics.', 'chat-help') .
											'</div>' .
											' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/analytics/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

									),
									array(
										'id'      => 'event_name',
										'type'    => 'text',
										'title'   => esc_html__('Event Name', 'chat-help'),
										'default' => esc_html__('Chat Help', 'chat-help'),
										'title_help' =>
										'<div class="chat-help-info-label">' .
											esc_html__('Set a custom event name for tracking in Google Analytics..', 'chat-help') .
											'</div>' .
											' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/analytics/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

										'dependency' =>  array('google_analytics',   '==', 'true'),
									),
									array(
										'id'      => 'google_analytics_parameter',
										'type'    => 'repeater',
										'class'   => 'google_analytics_repeater',
										'clone'   => false,
										'title'   => esc_html__('Google Analytics Parameter(s)', 'chat-help'),
										'title_help' =>
										'<div class="chat-help-info-label">' .
											esc_html__('Define additional parameters to send with your Google Analytics events. Supports variables, URL parameters, and cookies.', 'chat-help') .
											'</div>' .
											' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/analytics/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',
										'desc' => '<div style="margin-bottom: 10px;"><b>' . esc_html__('Variables:', 'chat-help') . '</b> ' . esc_html__('Use {number}, {group}, {title}, {currentTitle}, {url} to insert the assigned number/group, page title, current title, or current URL.', 'chat-help') . '</div><h4 class="chat-help-info-label" style="margin-bottom: 10px;">' . esc_html__('Retrieving Cookies & URL Parameters', 'chat-help') . '</h4><div style="margin-bottom: 10px;"><b>' . esc_html__('URL Parameters:', 'chat-help') . '</b> ' . esc_html__('Wrap the parameter name in single square brackets [ ] to insert its value. Missing parameters return blank.', 'chat-help') . '</div><div style="margin-bottom: 10px;"><b>' . esc_html__('Example:', 'chat-help') . '</b> [gclid], [utm_source]</div><div style="margin-bottom: 10px;"><b>' . esc_html__('Cookies:', 'chat-help') . '</b> ' . esc_html__('Wrap the cookie name in double square brackets [[ ]] to insert its value. Missing cookies return blank.', 'chat-help') . '</div><div style="margin-bottom: 10px;"><b>' . esc_html__('Example:', 'chat-help') . '</b> [[_ga]]</div>',
										'fields'  => array(
											array(
												'id'    => 'parameter_label',
												'type'  => 'text',
												'title' => esc_html__('Event Parameter', 'chat-help'),
											),
											array(
												'id'    => 'parameter_value',
												'type'  => 'text',
												'title' => esc_html__('Value', 'chat-help'),
											),
										),
										'default' => array(
											array(
												'parameter_label' => esc_html('number', 'chat-help'),
												'parameter_value' => esc_html('{number}', 'chat-help'),
											),
											array(
												'parameter_label' => esc_html('title', 'chat-help'),
												'parameter_value' => esc_html('{title}', 'chat-help'),
											),
											array(
												'parameter_label' => esc_html('url', 'chat-help'),
												'parameter_value' => esc_html('{url}', 'chat-help'),
											),
										),
										'dependency' =>  array('google_analytics',   '==', 'true'),
									),
								)
							),

							array(
								'title' => esc_html__('Webhooks', 'chat-help'),
								'icon'  => 'icofont-connection',
								'fields' => array(
									// A Submessage
									array(
										'type'    => 'notice',
										'style'   => 'normal',
										'content' => esc_html__('Webhooks are available in the', 'chat-help') . ' <strong>' . esc_html__('Pro version', 'chat-help') . '</strong>.' . esc_html__(' Upgrade to unlock real-time integrations and automate workflows.', 'chat-help') . '<a href="' . CHAT_HELP_DEMO_URL . 'pricing" target="_blank"><b>' . esc_html__('Upgrade to Pro', 'chat-help') . '</b></a>',
									),
									array(
										'type'    => 'subheading',
										'content' => esc_html__('Webhooks are automated HTTP POST requests that send data to a specified URL whenever certain events occur. They enable applications to communicate in real time, without the need for manual action. ', 'chat-help') . '<a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/floating-chat-webhooks/">' . esc_html__('Check WebHooks Documentation', 'chat-help') . '</a>',
									),
									array(
										'id' => 'webhook_url',
										'type' => 'text',
										'class' => 'only-for-pro',
										'title' => esc_html__('Webhook URL', 'chat-help'),
										'title_help' =>
										'<div class="chat-help-info-label">' .
											esc_html__('Enter the Webhook URL that will be triggered when users click the WhatsApp floating button or interact with multi-agents.', 'chat-help') .
											'</div>' .
											' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/webhooks/#1-webhook-url') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

									),
									array(
										'id' => 'webhook_values',
										'type' => 'repeater',
										'title' => esc_html__('Webhook Values', 'chat-help'),
										'class'   => 'google_analytics_repeater only-for-pro',
										'title_help' =>
										'<div class="chat-help-info-label">' .
											esc_html__('Add custom values to be sent with your Webhook request. You can use dynamic variables, URL parameters, or cookie values.', 'chat-help') .

											'</div>' .
											' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/webhooks/#2-webhook-values') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

										'fields'  => array(
											array(
												'id'    => 'parameter_label',
												'type'  => 'text',
												'title' => esc_html__('Event Parameter', 'chat-help'),
											),
											array(
												'id'    => 'parameter_value',
												'type'  => 'text',
												'title' => esc_html__('Value', 'chat-help'),
											),
										),
										'default' => array(
											array(
												'parameter_label' => esc_html('Number', 'chat-help'),
												'parameter_value' => esc_html('{number}', 'chat-help'),
											),
											array(
												'parameter_label' => esc_html('Title', 'chat-help'),
												'parameter_value' => esc_html('{title}', 'chat-help'),
											),
											array(
												'parameter_label' => esc_html('Url', 'chat-help'),
												'parameter_value' => esc_html('{url}', 'chat-help'),
											),
										),
										'desc'  => __('<p><b>Dynamic Variables:</b> {number}, {group}, {title}, {currentTitle}, {url}, {date}, {ip}</p>
                                    <h4>Retrieving Values from Cookies and URL Parameters</h4>
                        
                                    <p><b>Fetch URL Parameter Values: </b>To extract values from URL parameters, enclose the parameter name in single square brackets [ ]. If the parameter is missing, a blank value is returned.</p>
                                    <p><b>Example:</b> [gclid], [utm_source]</p>

                                    <p><b>Fetch Cookie Values:</b>To extract values from cookies, enclose the cookie name in double square brackets [[ ]]. If the cookie is missing, a blank value is returned.</p>
                                    <p><b>Example:</b> [[ _ga ]]</p>', 'chat-help'),
									),
								)
							),
							array(
								'title' => esc_html__('Additional CSS & JS', 'chat-help'),
								'icon'  => 'icofont-code-alt',
								'fields' => array(
									array(
										'id'       => 'whatsapp-custom-css',
										'type'     => 'code_editor',
										'title' => esc_html__('Custom CSS', 'chat-help'),
										'title_help' =>
										'<div class="chat-help-info-label">' .
											esc_html__('Add your own custom CSS to override or extend the default styling of the chat box.', 'chat-help') .
											'</div>' .
											' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/additional-css-js/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

										'settings' => array(
											'theme'  => 'mbo',
											'mode'   => 'css',
										),
									),

									array(
										'id'       => 'whatsapp-custom-js',
										'type'     => 'code_editor',
										'title' => esc_html__('Custom JavaScript', 'chat-help'),
										'title_help' =>
										'<div class="chat-help-info-label">' .
											esc_html__('Add your own custom JavaScript to extend or customize chat box behavior.', 'chat-help') .
											'</div>' .
											' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/additional-css-js/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

										'settings' => array(
											'theme'  => 'mbo',
											'mode'   => 'js',
										),
									),
								)
							),
							array(
								'title' => esc_html__('Backup', 'chat-help'),
								'icon'  => 'icofont-shield',
								'fields' => array(
									array(
										'title'    => esc_html__('Backup', 'chat-help'),
										'title_help' =>
										'<div class="chat-help-info-label">' .
											esc_html__('Export or import plugin settings for backup or migration purposes.', 'chat-help') .
											'</div>' .
											' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/backup/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',
										'type' => 'backup',
									),
								)
							),
						)
					),
				)
			)
		);
	}
}
