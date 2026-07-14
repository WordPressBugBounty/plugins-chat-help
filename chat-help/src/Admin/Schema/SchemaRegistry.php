<?php

/**
 * Standalone field-schema registry.
 *
 * classes (src/Admin/Views/*.php) keep registering their field sections through
 * the framework's `createSection()` API, which now *also* forwards each section
 * into this lightweight registry. The REST layer (AbstractRestController and its
 * SettingsRest/MetaRest subclasses) reads from here to build the schema served
 * to the React admin — no framework rendering required.
 *
 * During the phased migration this registry runs alongside the Codestar
 * framework (which still renders any page not yet migrated to React). Once every
 * page has a React equivalent, the framework is removed and only this registry
 * plus the shim `createSection()` remain.
 *
 * @package    chat-help
 * @subpackage chat-help/src/Admin/Schema
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Schema;

if (! defined('ABSPATH')) {
    die;
}

class SchemaRegistry
{
    /**
     * Registered sections keyed by unique option id
     * (e.g. 'cwp_option', 'ch_settings', 'ch_wooCommerce', 'ch_meta').
     *
     * @var array<string,array<int,array>>
     */
    public static $sections = array();

    /**
     * Register one section config under a unique option key.
     *
     * @param string $id      The unique option key the section belongs to.
     * @param array  $section The section config (title, icon, fields, …).
     * @return void
     */
    public static function createSection($id, $section)
    {
        if (! isset(self::$sections[$id])) {
            self::$sections[$id] = array();
        }
        self::$sections[$id][] = $section;
    }

    /**
     * Compatibility no-ops. The removed Codestar framework used these to build its
     * own admin/metabox screens, which the React admin has fully replaced. They
     * are kept so the existing config classes (src/Admin/Views/*.php) keep calling
     * a stable registration API without any changes.
     *
     * @param string $id   Unique key.
     * @param array  $args Ignored page/metabox args.
     * @return void
     */
    public static function createOptions($id, $args = array()) {}

    public static function createMetabox($id, $args = array()) {}
}
