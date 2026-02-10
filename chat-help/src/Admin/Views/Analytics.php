<?php

/**
 * Views class for Shortcode generator options.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/src/Admin/Views/Analytics
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Views;

use ThemeAtelier\ChatHelp\Admin\Framework\Classes\Chat_Help;

class Analytics
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
            )
        );
    }
}
