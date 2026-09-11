<?php

/**
 * Views class for Shortcode generator options.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/src/Admin/Views/License
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Views;

use ThemeAtelier\ChatHelp\Admin\Schema\SchemaRegistry;

class License
{

    /**
     * Create Option fields for the setting options.
     *
     * @param string $prefix Option setting key prefix.
     * @return void
     */
    public static function options($prefix)
    {
        SchemaRegistry::createSection($prefix, array(
            'title'       => esc_html__('License', 'chat-help'),
            'icon'        => 'icofont-key',

            'fields'      => array(
                // Intro line, rendered plain above the license card.
                array(
                    'type'    => 'page_hint',
                    'content' => esc_html__('Manage your Chat Help license key to receive updates and support.', 'chat-help'),
                ),
                array(
                    'id'   => 'license_key',
                    'type' => 'license',
                ),
            )
        ));
    }
}
