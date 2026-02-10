<?php

/**
 * Views class for Shortcode generator options.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/src/Admin/Views/AdvancedControls
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Views;

use ThemeAtelier\ChatHelp\Admin\Framework\Classes\Chat_Help;

class AdvancedControls
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
            )
        );
    }
}
