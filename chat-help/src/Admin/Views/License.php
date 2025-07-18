<?php

/**
 * License field
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/src/Admin/Views/Control
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Views;

use ThemeAtelier\ChatHelp\Admin\Framework\Classes\Chat_Help;

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
        Chat_Help::createSection(
            $prefix,
            array(
                'title'       => esc_html__('LICENSE', 'chat-help'),
                'icon'        => 'icofont-key',
                'fields'      => array(
                    array(
                        'id'   => 'license_key',
                        'type' => 'license',
                        ),
                ),
            ),
        );
    }
}
