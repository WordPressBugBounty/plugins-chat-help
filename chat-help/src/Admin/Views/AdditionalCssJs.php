<?php

/**
 * Views class for Shortcode generator options.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/src/Admin/Views/AdditionalCssJs
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Views;

use ThemeAtelier\ChatHelp\Admin\Framework\Classes\Chat_Help;

class AdditionalCssJs
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
                'title' => esc_html__('Additional CSS & JS', 'chat-help'),
                'icon'  => 'icofont-code-alt',
                'fields' => array(
                    array(
                        'id'       => 'whatsapp_custom_css',
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
                        'id'       => 'whatsapp_custom_js',
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
            )
        );
    }
}
