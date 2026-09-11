<?php

/**
 * Views class for the Import/Export settings section.
 *
 * One field, rendered entirely by the SPA (see `import_export` in
 * FieldRenderer): the section is a pair of tools, not a set of stored values,
 * so it saves nothing of its own.
 *
 * @link       https://themeatelier.net
 * @since      3.5.8
 *
 * @package chat-help
 * @subpackage chat-help/src/Admin/Views/ImportExport
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Views;

use ThemeAtelier\ChatHelp\Admin\Schema\SchemaRegistry;

class ImportExport
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
                'title'  => esc_html__('Import/Export', 'chat-help'),
                'icon'   => 'icofont-exchange',
                'fields' => array(
                    array(
                        'id'   => 'chat_help_import_export',
                        'type' => 'import_export',
                    ),
                ),
            )
        );
    }
}
