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

use ThemeAtelier\ChatHelp\Admin\Schema\SchemaRegistry;

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
        SchemaRegistry::createSection(
            $prefix,
            array(
                'title' => esc_html__('Advanced', 'chat-help'),
                'icon'  => 'icofont-code-alt',
                'fields' => array(
                    array(
                        'id'       => 'whatsapp_custom_css',
                        'type'     => 'code_editor',
                        'title' => esc_html__('Custom CSS', 'chat-help'),
                        'title_help' => '<div class="chat-help-info-label">' .  esc_html__('Add your own custom CSS to override or extend the default styling of the chat box.', 'chat-help') . '</div>',
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
                        '<div class="chat-help-info-label">' . esc_html__('Add your own custom JavaScript to extend or customize chat box behavior.', 'chat-help') . '</div>',
                        'settings' => array(
                            'theme'  => 'mbo',
                            'mode'   => 'js',
                        ),
                    ),
                    // Last, under its own heading: it is a site-wide switch
                    // about the plugin itself (not about a chat), and it is
                    // destructive — it belongs after the everyday fields.
                    array(
                        'type' => 'heading',
                        'content' => esc_html__('Plugin Data', 'chat-help'),
                    ),
                    array(
                        'id'      => 'cleanup_data_deletion',
                        'type'    => 'checkbox',
                        'title' => esc_html__('Clean-up Data on Deletion', 'chat-help'),
                        'title_help' =>
                        '<div class="chat-help-info-label">' . esc_html__('Enable this option to completely remove all Chat Help plugin data when the plugin is deleted from your site.', 'chat-help') . '</div>',

                    ),
                )
            )
        );
    }
}
