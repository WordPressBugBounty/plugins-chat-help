<?php

/**
 * Views class for Shortcode generator options.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/src/Admin/Views/Webhooks
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Views;

use ThemeAtelier\ChatHelp\Admin\Framework\Classes\Chat_Help;

class Webhooks
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
        // Field: backup
        //
        Chat_Help::createSection(
            $prefix,
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
            )
        );
    }
}
