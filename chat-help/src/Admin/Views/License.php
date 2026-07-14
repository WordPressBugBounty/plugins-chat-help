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
            'title'       => esc_html__('LICENSE', 'chat-help'),
            'icon'        => 'icofont-key',

            'fields'      => array(
                array(
                    'id'   => 'license_key',
                    'type' => 'license',
                ),
            )
        ));
    }
}
