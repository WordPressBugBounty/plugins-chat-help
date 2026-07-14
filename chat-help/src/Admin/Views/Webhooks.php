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

use ThemeAtelier\ChatHelp\Admin\Schema\SchemaRegistry;

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
        SchemaRegistry::createSection(
            $prefix,
            array(
                'title' => esc_html__('Webhooks', 'chat-help'),
                'icon'  => 'icofont-connection',
                'fields' => array(
                    array(
                        'type'    => 'subheading',
                        'content' => sprintf(
                            /* translators: %s: Documentation link */
                            __('Webhooks are automated HTTP POST requests that send data to a specified URL whenever certain events occur. They enable applications to communicate in real time, without the need for manual action. <a target="_blank" href="%s">Check WebHooks Documentation</a>', 'chat-help'),
                            esc_url(CHAT_HELP_DEMO_URL . 'docs/webhooks/#1-webhook-url')
                        ),

                    ),
                    array(
                        'id' => 'webhook_url',
                        'type' => 'text',
                        'title' => esc_html__('Webhook URL', 'chat-help'),
                        'title_help' =>
                        '<div class="chat-help-info-label">' . esc_html__('Enter the Webhook URL that will be triggered when users click the WhatsApp floating button or interact with multi-agents.', 'chat-help') . '</div>' . ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/webhooks/#1-webhook-url') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    ),
                    array(
                        'id' => 'webhook_values',
                        'type' => 'repeater',
                        'title' => esc_html__('Webhook Values', 'chat-help'),
                        'class'   => 'google_analytics_repeater',
                        'title_help' =>
                        '<div class="chat-help-info-label">' . esc_html__('Add custom values to be sent with your Webhook request. You can use dynamic variables, URL parameters, or cookie values.', 'chat-help') . '</div>' . ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/webhooks/#2-webhook-values') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',
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
                                'parameter_label' => 'Number',
                                'parameter_value' => '{number}',
                            ),
                            array(
                                'parameter_label' => 'Title',
                                'parameter_value' => '{title}',
                            ),
                            array(
                                'parameter_label' => 'Url',
                                'parameter_value' => '{url}',
                            ),
                            array(
                                'parameter_label' => 'Time',
                                'parameter_value' => '{date}',
                            ),
                        ),
                        'desc'  =>  '<p><b>' . esc_html__('Dynamic Variables:', 'chat-help') . '</b> {number}, {group}, {title}, {currentTitle}, {url}, {date}, {ip}</p> <h4>' . esc_html__('Retrieving Values from Cookies and URL Parameters', 'chat-help') . '</h4> <p><b>' . esc_html__('Fetch URL Parameter Values:', 'chat-help') . ' </b>' . esc_html__('To extract values from URL parameters, enclose the parameter name in single square brackets [ ]. If the parameter is missing, a blank value is returned.', 'chat-help') . '</p> <p><b>' . esc_html__('Example:', 'chat-help') . '</b> [gclid], [utm_source]</p> <p><b>' . esc_html__('Fetch Cookie Values:', 'chat-help') . '</b>' . esc_html__('To extract values from cookies, enclose the cookie name in double square brackets [[ ]]. If the cookie is missing, a blank value is returned.', 'chat-help') . '</p> <p><b>' . esc_html__('Example:', 'chat-help') . '</b> [[ _ga ]]</p>',
                    ),
                )
            )
        );
    }
}
