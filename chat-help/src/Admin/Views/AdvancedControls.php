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

use ThemeAtelier\ChatHelp\Admin\Schema\SchemaRegistry;

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
        SchemaRegistry::createSection(
            $prefix,
            array(
                'title' => esc_html__('WhatsApp URL', 'chat-help'),
                'icon'  => 'icofont-gears',
                'fields' => array(
                    array(
                        'id'      => 'open_in_new_tab',
                        'type'    => 'switcher',
                        'title'   => esc_html__('Open in New Tab', 'chat-help'),
                        'default' => true,
                        'title_help' =>
                        '<div class="chat-help-info-label">' . esc_html__('Enable this option to open the WhatsApp chat link in a new browser tab when clicked.', 'chat-help') . '</div>',

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
                        '<div class="chat-help-info-label">' . esc_html__('Choose how WhatsApp opens on desktop devices: "API" uses the WhatsApp application, while "Web" opens WhatsApp Web in the browser.', 'chat-help') . '</div>',
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
                        '<div class="chat-help-info-label">' . esc_html__('Choose how WhatsApp opens on mobile devices: "API" uses the standard WhatsApp API link, while "Protocol" directly triggers the WhatsApp app via protocol handler.', 'chat-help') . '</div>',
                        'default' => 'api',
                    ),
                )
            )
        );
    }
}
