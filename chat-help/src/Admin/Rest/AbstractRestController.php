<?php

/**
 * Base controller for the React admin SPA REST endpoints.
 *
 * Holds the shared namespace, capability gate and the schema/sanitization
 * helpers that read the standalone SchemaRegistry (the single source of truth
 * the Codestar config classes register into) and normalize it for React. The
 * concrete controllers (SettingsRest, LicenseRest, …) extend this and register
 * their own routes.
 *
 * so a single settings controller can serve every option key the plugin uses
 * (cwp_option, ch_wooCommerce, ch_shortcode, ch_settings, ch_help,
 * assign_widget) rather than a single hard-coded key.
 *
 * @package    chat-help
 * @subpackage chat-help/src/Admin/Rest
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Rest;

use ThemeAtelier\ChatHelp\Admin\Schema\SchemaRegistry;
use ThemeAtelier\ChatHelp\Admin\Schema\ProFeatures;
use ThemeAtelier\ChatHelp\Frontend\Helpers\Helpers;

if (! defined('ABSPATH')) {
    die;
}

abstract class AbstractRestController
{
    /**
     * REST namespace shared with the rest of the plugin.
     */
    const NS = 'chat-help/v1';

    /**
     * Option keys the settings API is allowed to read/write. Each maps to a WP
     * option that stores that page's flat field values. `ch_meta` is per-post
     * (metabox) and handled by its own controller, so it is not listed here.
     */
    const SETTINGS_KEYS = [
        'cwp_option',
        'ch_wooCommerce',
        'ch_shortcode',
        'ch_settings',
        'ch_help',
        'assign_widget',
    ];

    /**
     * Keys whose values React renders as raw HTML (via dangerouslySetInnerHTML)
     * and must NOT be entity-decoded.
     */
    const HTML_LABEL_KEYS = ['desc', 'help', 'title_help', 'content', 'before', 'after'];

    public function __construct()
    {
        \add_action('rest_api_init', [$this, 'register_routes']);
    }

    /**
     * Register this controller's routes. Called on `rest_api_init`.
     */
    abstract public function register_routes(): void;

    /**
     * Permission gate for every admin route.
     *
     * @return bool
     */
    public function can_manage(): bool
    {
        return \current_user_can(Helpers::chat_help_dashboard_capability());
    }

    /**
     * Whether an option key is one the settings API may touch.
     */
    protected function is_valid_settings_key(string $key): bool
    {
        return \in_array($key, self::SETTINGS_KEYS, true);
    }

    // ─── Schema helpers ─────────────────────────────────────────────────────────

    /**
     * Returns the raw registered section arrays for an option key.
     *
     * Registration normally happens on `after_setup_theme` (Admin::initialize_options
     * / assign_widget_configs), which runs on every request including REST — so
     * the registry is already populated here. The guard is a safety net only.
     */
    public function get_registered_sections(string $unique): array
    {
        $sections = SchemaRegistry::$sections[$unique] ?? [];
        return \is_array($sections) ? $sections : [];
    }

    /**
     * Normalizes the flat section list into a tab tree:
     * top-level sections become tabs; sections with `parent` become sub-tabs.
     *
     * @return array<int,array>
     */
    public function normalize_sections(array $sections): array
    {
        $tabs  = [];
        $index = [];

        foreach ($sections as $section) {
            if (! empty($section['parent'])) {
                continue;
            }
            $id   = $section['id'] ?? \sanitize_title($section['title'] ?? \uniqid('sec_'));
            $node = [
                'id'     => $id,
                'title'  => $section['title'] ?? '',
                'icon'   => $section['icon'] ?? '',
                'fields' => $this->clean_fields($section['fields'] ?? []),
                'subs'   => [],
            ];
            $tabs[]     = $node;
            $index[$id] = count($tabs) - 1;
        }

        foreach ($sections as $section) {
            if (empty($section['parent'])) {
                continue;
            }
            $parent = $section['parent'];
            $sub    = [
                'id'     => $section['id'] ?? \sanitize_title($section['title'] ?? \uniqid('sub_')),
                'title'  => $section['title'] ?? '',
                'icon'   => $section['icon'] ?? '',
                'fields' => $this->clean_fields($section['fields'] ?? []),
            ];
            if (isset($index[$parent])) {
                $tabs[$index[$parent]]['subs'][] = $sub;
            } else {
                // Orphan child — promote to a top-level tab so it isn't lost.
                $tabs[] = [
                    'id'     => $sub['id'],
                    'title'  => $sub['title'],
                    'icon'   => $sub['icon'],
                    'fields' => $sub['fields'],
                    'subs'   => [],
                ];
            }
        }

        return $this->decode_labels($tabs);
    }

    /**
     * Recursively HTML-entity-decode plain-text label strings in a config tree,
     * skipping keys that hold trusted HTML markup. The configs come from PHP
     * (trusted source) and React escapes text nodes on render, so decoding here
     * introduces no XSS surface.
     *
     * @param mixed  $value The value to process.
     * @param string $key   The array key $value was found under.
     * @return mixed
     */
    protected function decode_labels($value, string $key = '')
    {
        if (\is_array($value)) {
            $out = [];
            foreach ($value as $k => $v) {
                $out[$k] = $this->decode_labels($v, (string) $k);
            }
            return $out;
        }

        if (\is_string($value) && ! \in_array($key, self::HTML_LABEL_KEYS, true)) {
            return \html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }

        return $value;
    }

    /**
     * Strips non-serializable bits from field configs (callbacks etc.) and keeps
     * the presentation/behavior keys React needs.
     */
    protected function clean_fields(array $fields): array
    {
        $keep = [
            'id', 'type', 'title', 'subtitle', 'desc', 'help', 'title_help', 'default',
            'options', 'placeholder', 'dependency', 'text_on', 'text_off', 'text_width',
            'inline', 'content', 'style', 'attributes', 'unit', 'min', 'max', 'step',
            'class', 'library', 'preview', 'multiple', 'fields', 'button_title',
            'add_button', 'settings', 'before', 'after', 'prepend', 'append',
            'all', 'units', 'accordion_title_prefix', 'accordion_title_number',
            'max_items', 'min_items', 'columns', 'chosen', 'from_to',
            // Typography sub-option flags (control which controls render).
            'color', 'hover_color', 'text_align', 'letter_spacing', 'subset',
            'font_size', 'line_height', 'font_style', 'text_transform', 'text_color',
        ];

        $out = [];
        foreach ($fields as $field) {
            if (! \is_array($field)) {
                continue;
            }
            $clean = [];
            foreach ($keep as $k) {
                if (\array_key_exists($k, $field)) {
                    $clean[$k] = $field[$k];
                }
            }
            // Resolve dynamic option sources (e.g. 'posts', 'pages') into a real
            // {value => label} map so React can render the choices.
            if (isset($clean['options']) && \is_string($clean['options'])) {
                $clean['options'] = $this->resolve_options($field);
            }
            // Recurse into nested fields (repeater/group/accordion/column).
            if (! empty($field['fields']) && \is_array($field['fields'])) {
                $clean['fields'] = $this->clean_fields($field['fields']);
            }
            // Recurse into section_tab / tabbed sub-sections. Each tab is a
            // {title, icon, fields} group; its fields keep their own top-level
            // ids (so they save flat).
            if (! empty($field['tabs']) && \is_array($field['tabs'])) {
                $clean['tabs'] = \array_map(function ($tab) {
                    return [
                        'id'         => $tab['id'] ?? \sanitize_title($tab['title'] ?? \uniqid('tab_')),
                        'title'      => $tab['title'] ?? '',
                        'icon'       => $tab['icon'] ?? '',
                        'fields'     => $this->clean_fields($tab['fields'] ?? []),
                        // Lets a whole tab (not just an individual field) hide
                        // conditionally — e.g. "Disable Chat" hides every tab
                        // except General, so its layout-experience picker
                        // always stays reachable.
                        'dependency' => $tab['dependency'] ?? null,
                    ];
                }, \array_values($field['tabs']));
            }
            // Recurse into accordion sub-sections (Codestar "accordions").
            if (! empty($field['accordions']) && \is_array($field['accordions'])) {
                $clean['accordions'] = \array_map(function ($acc) {
                    return [
                        'id'     => $acc['id'] ?? \sanitize_title($acc['title'] ?? \uniqid('acc_')),
                        'title'  => $acc['title'] ?? '',
                        'icon'   => $acc['icon'] ?? '',
                        'fields' => $this->clean_fields($acc['fields'] ?? []),
                    ];
                }, \array_values($field['accordions']));
            }
            $out[] = $clean;
        }
        return $out;
    }

    /**
     * Resolve a dynamic-options token (string) into an id => label map.
     * Unknown tokens resolve to an empty list rather than leaking the token.
     *
     * @param array $field The raw field config (may carry `query_args`).
     * @return array<string,string>
     */
    protected function resolve_options(array $field): array
    {
        $token = $field['options'];
        $out   = [];

        switch ($token) {
            case 'posts': {
                $args = (isset($field['query_args']) && \is_array($field['query_args']))
                    ? $field['query_args']
                    : ['post_type' => 'post'];
                $args['posts_per_page'] = $args['posts_per_page'] ?? -1;
                $args['post_status']    = $args['post_status'] ?? 'publish';
                foreach (\get_posts($args) as $post) {
                    $out[(string) $post->ID] = ($post->post_title !== '')
                        ? $post->post_title
                        : \sprintf(\__('(no title) #%d', 'chat-help'), $post->ID);
                }
                break;
            }

            case 'pages': {
                foreach (\get_pages(['post_status' => 'publish']) as $page) {
                    $out[(string) $page->ID] = ($page->post_title !== '')
                        ? $page->post_title
                        : \sprintf(\__('(no title) #%d', 'chat-help'), $page->ID);
                }
                break;
            }

            case 'post_type': {
                $post_types = \get_post_types(['public' => true], 'objects');
                foreach ($post_types as $slug => $obj) {
                    // Media (attachment) isn't a browsable content type users assign
                    // a chat widget to — exclude it from the Assign Layouts picker.
                    if ($slug === 'attachment') {
                        continue;
                    }
                    $out[(string) $slug] = isset($obj->labels->singular_name)
                        ? $obj->labels->singular_name
                        : $slug;
                }
                break;
            }

            case 'chat_help_get_taxonomy_terms':
            case 'taxonomies': {
                $taxonomies = \get_taxonomies(['public' => true], 'objects');
                foreach ($taxonomies as $tax) {
                    $terms = \get_terms(['taxonomy' => $tax->name, 'hide_empty' => false]);
                    if (\is_wp_error($terms)) {
                        continue;
                    }
                    foreach ($terms as $term) {
                        $out[(string) $term->term_id] = $tax->labels->singular_name . ': ' . $term->name;
                    }
                }
                break;
            }
        }

        return $out;
    }

    /**
     * Flatten all field defaults (id => default) across a section list.
     */
    public function collect_defaults(array $sections): array
    {
        $defaults = [];
        $this->walk_fields($sections, function ($field) use (&$defaults) {
            if (! empty($field['id']) && \array_key_exists('default', $field)) {
                $defaults[$field['id']] = $this->decode_labels($field['default']);
            }
        });
        return $defaults;
    }

    /**
     * Merge saved values over schema defaults.
     *
     * Unlike a plain `array_merge($defaults, $saved)`, an empty-string saved
     * value does NOT clobber a non-empty default. In this data model there is no
     * null — an empty string is the "never meaningfully set" marker (it is what a
     * partial/legacy save leaves behind for fields the form never submitted, e.g.
     * a switcher, button_set or repeater that was hidden by a dependency). Letting
     * `''` win means a documented default (Google Analytics ON, event name
     * "Chat Help", the default parameter rows, etc.) would silently render blank.
     *
     * Real user choices are preserved: `'0'`/`false` (switcher off), a selected
     * option string, an explicit empty array `[]` (an intentionally-cleared
     * repeater), and any non-empty string all override the default as before.
     * Only the ambiguous empty string yields to a non-empty default.
     */
    public function merge_defaults(array $defaults, array $saved): array
    {
        $values = $defaults;
        foreach ($saved as $key => $value) {
            if (
                $value === ''
                && \array_key_exists($key, $defaults)
                && $defaults[$key] !== ''
                && $defaults[$key] !== null
            ) {
                continue; // keep the non-empty default
            }
            $values[$key] = $value;
        }
        return $values;
    }

    /**
     * Flatten id => type across a section list.
     */
    public function collect_field_types(array $sections): array
    {
        $types = [];
        $this->walk_fields($sections, function ($field) use (&$types) {
            if (! empty($field['id']) && ! empty($field['type'])) {
                $types[$field['id']] = $field['type'];
            }
        });
        return $types;
    }

    /**
     * Recursively visit every field across sections (incl. nested fields, tabs
     * and accordions).
     */
    protected function walk_fields(array $sections, callable $cb): void
    {
        foreach ($sections as $section) {
            if (empty($section['fields']) || ! \is_array($section['fields'])) {
                continue;
            }
            foreach ($section['fields'] as $field) {
                if (! \is_array($field)) {
                    continue;
                }
                $cb($field);
                if (! empty($field['fields']) && \is_array($field['fields'])) {
                    $this->walk_fields([['fields' => $field['fields']]], $cb);
                }
                if (! empty($field['tabs']) && \is_array($field['tabs'])) {
                    foreach ($field['tabs'] as $tab) {
                        if (! empty($tab['fields']) && \is_array($tab['fields'])) {
                            $this->walk_fields([['fields' => $tab['fields']]], $cb);
                        }
                    }
                }
                if (! empty($field['accordions']) && \is_array($field['accordions'])) {
                    foreach ($field['accordions'] as $acc) {
                        if (! empty($acc['fields']) && \is_array($acc['fields'])) {
                            $this->walk_fields([['fields' => $acc['fields']]], $cb);
                        }
                    }
                }
            }
        }
    }

    /**
     * Type-aware sanitization of an incoming values map.
     */
    public function sanitize_values(array $values, array $type_map): array
    {
        $clean = [];
        foreach ($values as $key => $value) {
            $type        = $type_map[$key] ?? '';
            $clean[$key] = $this->sanitize_value($value, $type);
        }
        return $clean;
    }

    protected function sanitize_value($value, string $type = '')
    {
        // Preserved as-is (not stringified to ""): a cleared "media" field
        // (MediaField's remove button) sends null for "no image selected",
        // and casting that to a string here would put "" back into the
        // option — which every frontend template's `$value['url']` lookup
        // then treats as fatal (see Helpers::media_url()'s docblock).
        if ($value === null) {
            return null;
        }

        if (\is_array($value)) {
            $out = [];
            foreach ($value as $k => $v) {
                $out[\sanitize_text_field((string) $k)] = $this->sanitize_value($v, '');
            }
            return $out;
        }

        switch ($type) {
            case 'textarea':
                return \sanitize_textarea_field((string) $value);
            case 'wp_editor':
            case 'code_editor':
                return \wp_kses_post((string) $value);
            case 'switcher':
            case 'checkbox':
                return $value; // booleans / arrays handled above
            case 'number':
            case 'slider':
            case 'spinner':
                return \is_numeric($value) ? $value + 0 : \sanitize_text_field((string) $value);
            default:
                return \sanitize_text_field((string) $value);
        }
    }

    // ─── Pro-feature locking (free plugin) ──────────────────────────────────────

    /**
     * Stamp `pro`/`pro_options` flags onto a normalized schema tree so the React
     * admin can render Pro-only sections/fields/options as locked previews.
     *
     * Adds `pro: true` to a top-level tab whose id is Pro-locked, and (recursively)
     * to any Pro-locked field; fields with locked choices get a `pro_options`
     * array. Everything else is untouched, so free fields render normally.
     *
     * @param array  $tree The tree from normalize_sections().
     * @param string $key  The option key the tree belongs to.
     * @return array
     */
    public function apply_pro_flags(array $tree, string $key): array
    {
        foreach ($tree as &$tab) {
            $tab_id  = (string) ($tab['id'] ?? '');
            $tab_pro = $tab_id !== '' && ProFeatures::is_section_pro($key, $tab_id);
            if ($tab_pro) {
                $tab['pro'] = true;
            }
            if (! empty($tab['fields']) && \is_array($tab['fields'])) {
                $tab['fields'] = $this->mark_pro_fields($tab['fields'], $key, $tab_pro);
            }
            if (! empty($tab['subs']) && \is_array($tab['subs'])) {
                foreach ($tab['subs'] as &$sub) {
                    $sub_id  = (string) ($sub['id'] ?? '');
                    $sub_pro = $tab_pro || ($sub_id !== '' && ProFeatures::is_section_pro($key, $sub_id));
                    if ($sub_pro) {
                        $sub['pro'] = true;
                    }
                    if (! empty($sub['fields']) && \is_array($sub['fields'])) {
                        $sub['fields'] = $this->mark_pro_fields($sub['fields'], $key, $sub_pro);
                    }
                }
                unset($sub);
            }
        }
        unset($tab);
        return $tree;
    }

    /**
     * Recursively add `pro`/`pro_options` flags to a field list (incl. nested
     * fields, section_tab tabs and accordions).
     *
     * @param array  $fields
     * @param string $key
     * @param bool   $force Inherit a Pro lock from an enclosing section/tab.
     * @return array
     */
    protected function mark_pro_fields(array $fields, string $key, bool $force = false): array
    {
        foreach ($fields as &$field) {
            if (! \is_array($field)) {
                continue;
            }
            $id = (string) ($field['id'] ?? '');

            $field_pro = $force || ($id !== '' && ProFeatures::is_field_pro($key, $id));
            if ($field_pro) {
                $field['pro'] = true;
            }
            if ($id !== '') {
                $locked = ProFeatures::locked_options($key, $id);
                if (! empty($locked)) {
                    $field['pro_options'] = $locked;
                }
                $limit = ProFeatures::row_limit($key, $id);
                if ($limit > 0) {
                    $field['pro_limit'] = $limit;
                }
            }

            if (! empty($field['fields']) && \is_array($field['fields'])) {
                $field['fields'] = $this->mark_pro_fields($field['fields'], $key, $field_pro);
            }
            if (! empty($field['tabs']) && \is_array($field['tabs'])) {
                foreach ($field['tabs'] as &$tab) {
                    $tab_id  = (string) ($tab['id'] ?? '');
                    $tab_pro = $force || ($tab_id !== '' && ProFeatures::is_section_pro($key, $tab_id));
                    if ($tab_pro) {
                        $tab['pro'] = true;
                    }
                    if (! empty($tab['fields']) && \is_array($tab['fields'])) {
                        $tab['fields'] = $this->mark_pro_fields($tab['fields'], $key, $tab_pro);
                    }
                }
                unset($tab);
            }
            if (! empty($field['accordions']) && \is_array($field['accordions'])) {
                foreach ($field['accordions'] as &$acc) {
                    if (! empty($acc['fields']) && \is_array($acc['fields'])) {
                        $acc['fields'] = $this->mark_pro_fields($acc['fields'], $key, $field_pro);
                    }
                }
                unset($acc);
            }
        }
        unset($field);
        return $fields;
    }

    /**
     * Drop Pro-locked keys from an incoming values map before persisting, so a
     * crafted request can never write a Pro-only feature in the free plugin.
     *
     * Removes any Pro-locked field key outright, and reverts a field whose
     * submitted value is a locked option (the key is dropped so the existing/
     * default value is kept by the caller's array_merge).
     *
     * @param array  $values   Sanitized incoming values.
     * @param string $key      Option key.
     * @param array  $sections The registered sections for the key.
     * @return array
     */
    public function strip_pro_keys(array $values, string $key, array $sections): array
    {
        if (ProFeatures::is_all($key)) {
            return [];
        }

        // Derive the locked ids from the SAME flagged tree the React admin gets,
        // so a field locked via its enclosing section is stripped too (not just
        // fields listed individually in the map).
        $tree        = $this->apply_pro_flags($this->normalize_sections($sections), $key);
        $pro_ids     = [];
        $locked_opts = [];
        $this->collect_pro_ids($tree, $pro_ids, $locked_opts);

        foreach ($pro_ids as $id) {
            unset($values[$id]);
        }

        foreach ($locked_opts as $id => $locked) {
            if (! isset($values[$id])) {
                continue;
            }
            if (\is_array($values[$id])) {
                // Multi-value field (checkbox group / multi-select): drop only the
                // Pro-locked entries, keep the free ones — e.g. Visibility's
                // ['theme_page','posts'] survives a crafted request that also
                // sends the Pro-only 'product' key.
                $values[$id] = \array_values(\array_filter(
                    $values[$id],
                    static function ($v) use ($locked) {
                        return ! \in_array((string) $v, $locked, true);
                    }
                ));
                continue;
            }
            if (\is_scalar($values[$id]) && \in_array((string) $values[$id], $locked, true)) {
                unset($values[$id]);
            }
        }

        // Clamp capped repeaters/groups (e.g. Form Fields) so a crafted request
        // can't persist more rows than the free plan allows.
        foreach (ProFeatures::row_limits($key) as $id => $limit) {
            if ($limit > 0 && isset($values[$id]) && \is_array($values[$id])) {
                $values[$id] = \array_slice(\array_values($values[$id]), 0, $limit);
            }
        }

        return $values;
    }

    /**
     * Recursively gather Pro-locked field ids and per-field locked option keys
     * from a flagged schema tree (sections → fields → nested fields/tabs/accordions).
     *
     * @param array $nodes       Tree or field list.
     * @param array $pro_ids     Out: ids of fully-locked fields.
     * @param array $locked_opts Out: field id => locked option keys.
     * @return void
     */
    protected function collect_pro_ids(array $nodes, array &$pro_ids, array &$locked_opts): void
    {
        foreach ($nodes as $node) {
            if (! \is_array($node)) {
                continue;
            }

            $id = (string) ($node['id'] ?? '');
            if ($id !== '' && ! empty($node['pro']) && isset($node['type'])) {
                $pro_ids[] = $id;
            }
            if ($id !== '' && ! empty($node['pro_options']) && \is_array($node['pro_options'])) {
                $locked_opts[$id] = \array_map('strval', $node['pro_options']);
            }

            // Group/repeater sub-fields never save as flat option keys — their
            // values nest inside the parent's own array (which is stripped by
            // the parent's id when locked). Collecting their ids here would
            // wrongly strip an unrelated FREE top-level field that happens to
            // share the id (e.g. `agent-name` exists both inside the Pro
            // `opt-chat-agents` group and as the free Header & Footer field,
            // whose saved value was being silently dropped).
            $nests_values = isset($node['type']) && \in_array($node['type'], ['group', 'repeater'], true);

            foreach (['fields', 'subs', 'tabs', 'accordions'] as $child_key) {
                if ($child_key === 'fields' && $nests_values) {
                    continue;
                }
                if (! empty($node[$child_key]) && \is_array($node[$child_key])) {
                    $this->collect_pro_ids($node[$child_key], $pro_ids, $locked_opts);
                }
            }
        }
    }

    // ─── Global WhatsApp fallback (shared) ──────────────────────────────────────

    /**
     * Field ids (per option key) whose empty value inherits the Global Chat
     * WhatsApp number/group, mapped to which global each one inherits.
     *
     * @return array<string,'number'|'group'>
     */
    protected function global_fallback_fields(string $key): array
    {
        if ($key === 'ch_wooCommerce') {
            $out = [];
            foreach (['shop', 'product', 'cart', 'checkout', 'thank_you'] as $page) {
                $out[$page . '_page_button_number'] = 'number';
                $out[$page . '_page_button_group']  = 'group';
            }
            return $out;
        }
        if ($key === 'ch_meta') {
            return [
                'opt-number' => 'number',
                'opt-group'  => 'group',
            ];
        }
        return [];
    }

    /**
     * Display-side half of the inherit contract: fill empty inheriting fields
     * with the current global values so the admin UI shows what will actually
     * be used. Pairs with strip_global_fallback_values(), which prevents these
     * filled values from being persisted on save — storage stays empty, and the
     * frontend keeps resolving the global at render time (live fallback).
     */
    protected function fill_global_fallback_values(array $values, string $key): array
    {
        $map = $this->global_fallback_fields($key);
        if (! $map) {
            return $values;
        }
        $global = Helpers::global_whatsapp_defaults();
        foreach ($map as $id => $which) {
            $current = isset($values[$id]) && \is_scalar($values[$id]) ? \trim((string) $values[$id]) : '';
            if ($current === '' && $global[$which] !== '') {
                $values[$id] = $global[$which];
            }
        }
        return $values;
    }

    /**
     * Save-side half: a submitted value identical to the current global is the
     * display fill coming back, not a user override — store '' instead so the
     * field keeps inheriting (a real local override is anything different).
     */
    protected function strip_global_fallback_values(array $values, string $key): array
    {
        $map = $this->global_fallback_fields($key);
        if (! $map) {
            return $values;
        }
        $global = Helpers::global_whatsapp_defaults();
        foreach ($map as $id => $which) {
            if (
                isset($values[$id]) && \is_scalar($values[$id])
                && $global[$which] !== ''
                && \trim((string) $values[$id]) === $global[$which]
            ) {
                $values[$id] = '';
            }
        }
        return $values;
    }

    // ─── Global WhatsApp fallback hints ─────────────────────────────────────────

    /**
     * Append a "leave empty to inherit from Global Chat" note to the fields
     * whose empty value falls back to the Global Chat number/group at render
     * time (see Helpers::global_whatsapp_defaults()). Injected here — not in
     * the Views config files — so those stay byte-identical to Pro.
     *
     * @param array $tree The normalized (and possibly pro-flagged) schema tree.
     * @return array
     */
    protected function apply_global_fallback_hints(array $tree): array
    {
        $number_hint = \__('Leave empty to use the WhatsApp Number from Global Chat settings.', 'chat-help');
        $group_hint  = \__('Leave empty to use the WhatsApp Group from Global Chat settings.', 'chat-help');

        $walk = function (array $nodes) use (&$walk, $number_hint, $group_hint): array {
            foreach ($nodes as &$node) {
                if (! \is_array($node)) {
                    continue;
                }
                $id = (string) ($node['id'] ?? '');
                if (\preg_match('/_page_button_(number|group)$/', $id, $m)) {
                    $hint = $m[1] === 'number' ? $number_hint : $group_hint;
                    $desc = isset($node['desc']) && \is_string($node['desc']) ? $node['desc'] : '';
                    $node['desc'] = ($desc !== '' ? $desc . '<br>' : '') . \esc_html($hint);
                }
                foreach (['fields', 'subs', 'tabs', 'accordions'] as $child_key) {
                    if (! empty($node[$child_key]) && \is_array($node[$child_key])) {
                        $node[$child_key] = $walk($node[$child_key]);
                    }
                }
            }
            unset($node);
            return $nodes;
        };

        return $walk($tree);
    }
}
