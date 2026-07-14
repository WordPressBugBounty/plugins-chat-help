<?php

/**
 * General options for chat help.
 *
 * The "FLOATING CHAT" section's tabs (General / Header & Footer / Button /
 * Style, plus the Global-only Others / Backup tabs) are defined once in
 * FloatingChatFields — shared with WidgetOptions (the per-layout editor) so
 * both pages stay in sync. See FloatingChatFields' docblock for details.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/src/Admin/Views/GlobalOptions
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Views;

use ThemeAtelier\ChatHelp\Admin\Schema\SchemaRegistry;
use ThemeAtelier\ChatHelp\Admin\Views\Fields\FloatingChatFields;

class GlobalOptions
{

    /**
     * Create Option fields for the setting options.
     *
     * @param string $prefix Option setting key prefix.
     * @return void
     */
    public static function options($prefix, $timezones)
    {
        SchemaRegistry::createSection(
            $prefix,
            array(
                'title' => esc_html__('FLOATING CHAT', 'chat-help'),
                'icon' => 'icofont-brand-whatsapp',
                'class' => 'floating_chat',
                'fields' => array(
                    array(
                        'type' => 'section_tab',
                        'class' => 'chathelp-mt-0',
                        'tabs' => FloatingChatFields::tabs($timezones, true),
                    ),
                ),
            )
        );
    }
}
