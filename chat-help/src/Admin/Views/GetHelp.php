<?php

/**
 * Views class for Shortcode generator options.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/src/Admin/Views/Advance
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Views;

use ThemeAtelier\ChatHelp\Admin\Framework\Classes\Chat_Help;

class GetHelp
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
        // Field: advance
        //
        Chat_Help::createSection($prefix, array(
            'title'       => esc_html__('HELP', 'chat-help'),
            'icon'        => 'icofont-life-buoy',

            'fields'      => array(
                array(
                    'id'   => 'ta_help',
                    'type' => 'ta_help',
                ),
            )
        ));
    }
}
