<?php

/**
 * Central Pro-feature lock map for the free plugin.
 *
 * The free `chat-help` admin ports the full `chat-help-pro` field schema so its
 * UI mirrors Pro one-for-one, but Pro-only features are shown as locked previews
 * (disabled + a "PRO" badge in React) and are never persisted (the REST layer
 * strips them on save). This class is the SINGLE source of truth for that free/
 * Pro boundary, so the ported `Views/*` field-config files stay byte-identical
 * to Pro and a future Pro->free sync is a diff of this map only.
 *
 * Granularity (all optional per option key):
 *   - 'all'      => true                            every field for this key is locked
 *   - 'sections' => [ section_id, ... ]             whole tab/section locked
 *   - 'tabs'     => [ tab_id, ... ]                 whole section_tab sub-tab locked
 *   - 'fields'   => [ field_id, ... ]               whole field locked
 *   - 'options'  => [ field_id => [ opt_key, ... ]] specific choices within a field locked
 *   - 'limits'   => [ field_id => N ]               repeater/group capped at N rows in free
 *
 * The REST read path stamps `pro: true` on locked sections/tabs/fields (inherited
 * by their descendants) and adds `pro_options: [...]` to fields with locked
 * choices; the save path (`AbstractRestController::strip_pro_keys`) drops any
 * locked field key and any field whose submitted value is a locked option.
 *
 * ── HOW THIS MAP WAS DERIVED (do not hand-edit without re-deriving) ───────────
 * Two authoritative sources, both taken from the plugin as it shipped BEFORE the
 * React migration, so no existing free user loses a setting:
 *
 *  1. The old free Codestar configs declared their own boundary inline, via
 *     `'pro_only' => true` on individual options and a `switcher_pro_only` class
 *     on whole fields. Those became the `options` entries (and 4 of the
 *     `cwp_option` fields). The old UI's placeholder option keys `multi_pro` /
 *     `multi_agent_form_pro` map onto Pro's real `multi` / `multi_agent_form`.
 *
 *  2. Every field present in Pro's schema but absent from the old free schema is
 *     Pro-only by definition. Those free templates that *read* such a key (e.g.
 *     `before-chat-icon-native`) always fell back to their default because the
 *     free admin never rendered a control for it — so locking them is a no-op
 *     for existing installs.
 *
 * The single exception is `chat-button-loading-text`: a genuine free field that
 * Pro does not have. It is re-added in `Views/Fields/FloatingChatFields.php` and
 * is NOT locked.
 *
 * `ch_settings.webhooks` is a second, deliberate exception: unlike the rest of
 * this map, it is NOT restoring parity with the pre-migration free plugin (that
 * version shipped Webhooks unlocked). It is a later product decision to make the
 * whole Webhooks tab Pro-only going forward, added the same way every other
 * locked section is.
 *
 * @package    chat-help
 * @subpackage chat-help/src/Admin/Schema
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Schema;

if (! defined('ABSPATH')) {
    die;
}

class ProFeatures
{
    /**
     * Option key => lock config.
     *
     * @var array<string,array>
     */
    const MAP = array(
        // ── cwp_option ──
        'cwp_option' => array(
            'fields' => array(
                'agent-designation',
                'agent-group',
                'agent-number',
                'agent-offline-text',
                'agent-online-text',
                'agent-timezone',
                'agent_avatar',
                'agent_avatar_type',
                'agent_type_of_whatsapp',
                'agent_view',
                'before-chat-icon-custom',
                'before-chat-icon-native',
                'bubble-position-mobile',
                'bubble-position-tablet',
                'bubble-search',
                'button-close-custom',
                'button-close-native',
                'button-icon-custom',
                'button-icon-native',
                'button_size_custom',
                'button_top_label',
                'category',
                'category_all',
                'category_target',
                'chat_button_image',
                'chat_button_image_type',
                'chat_button_text',
                'chat_button_top_label',
                'circle-button-close-custom',
                'circle-button-close-native',
                'circle-button-icon-custom',
                'circle-button-icon-native',
                'enable-positioning-mobile',
                'enable-positioning-tablet',
                'footer_content',
                'footer_content_text',
                'left_bottom_mobile',
                'left_bottom_tablet',
                'left_middle_mobile',
                'left_middle_tablet',
                'offline_text',
                'online_text',
                'opt-chat-agents',
                'product',
                'product_all',
                'product_category',
                'product_category_all',
                'product_category_target',
                'product_tags',
                'product_tags_all',
                'product_tags_target',
                'product_target',
                'right_bottom_mobile',
                'right_bottom_tablet',
                'right_middle_mobile',
                'right_middle_tablet',
                'send_button_color',
                'submit_button_icon',
                'submit_button_icon_custom',
                'submit_button_icon_native',
                'submit_button_text',
                'tags',
                'tags_all',
                'tags_target',
                // Visibility: only "Theme Pages" and "Posts" are free (see the
                // 'visibility' options lock below); every other content-type
                // visibility rule — including its whole accordion panel, which
                // cascades the lock down to its target/all/list sub-fields — is
                // Pro. "Pages" was free pre-migration but is now Pro per an
                // explicit product decision (2026-07-11), overriding the usual
                // "already free" rule this map otherwise follows.
                'visibility_by_page',
                'visibility_by_category',
                'visibility_by_product',
                'visibility_by_product_category',
                'visibility_by_product_tags',
                'visibility_by_tags',
            ),
            // The old free Codestar config capped Form Fields at 2 rows via
            // `'max' => 2` + `add_more_text`; the ported Pro schema has no max,
            // so the cap moves here (stamped as `pro_limit` on the REST read
            // path, clamped by strip_pro_keys on save).
            'limits' => array(
                'form_editor' => 2,
            ),
            'options' => array(
                'before-chat-icon' => array('custom', 'native'),
                'bubble-position' => array('left_middle', 'right_middle'),
                'bubble-style' => array('dark', 'night'),
                'button_size' => array('custom'),
                'chat_layout' => array('multi', 'multi_agent_form'),
                'circle-button-close' => array('custom', 'native'),
                'circle-button-close-1' => array('custom', 'native'),
                'circle-button-icon' => array('custom', 'native'),
                'circle-button-icon-1' => array('custom', 'native'),
                'opt-button-style' => array('10'),
                // Visibility rules: only Theme Pages + Posts are free; Pages,
                // Products, Post/Product Categories and Post/Product Tags are Pro.
                'visibility' => array('page', 'product', 'category', 'tags', 'product_category', 'product_tags'),
            ),
        ),
        // ── ch_wooCommerce ──
        'ch_wooCommerce' => array(
            'fields' => array(
                'cart_page_agent_photo',
                'cart_page_agent_photo_type',
                'cart_page_button_icon_custom',
                'cart_page_button_icon_native',
                'cart_page_button_size_custom',
                'cart_page_button_top_label',
                'cart_page_circle_button_icon_custom',
                'cart_page_circle_button_icon_native',
                'checkout_page_agent_photo',
                'checkout_page_agent_photo_type',
                'checkout_page_button_icon_custom',
                'checkout_page_button_icon_native',
                'checkout_page_button_size_custom',
                'checkout_page_button_top_label',
                'checkout_page_circle_button_icon_custom',
                'checkout_page_circle_button_icon_native',
                'product_page_agent_photo',
                'product_page_agent_photo_type',
                'product_page_button_icon_custom',
                'product_page_button_icon_native',
                'product_page_button_size_custom',
                'product_page_button_top_label',
                'product_page_circle_button_icon_custom',
                'product_page_circle_button_icon_native',
                'shop_page_agent_photo',
                'shop_page_agent_photo_type',
                'shop_page_button_icon_custom',
                'shop_page_button_icon_native',
                'shop_page_button_size_custom',
                'shop_page_button_top_label',
                'shop_page_circle_button_icon_custom',
                'shop_page_circle_button_icon_native',
            ),
            'options' => array(
                'cart_page_button_icon_open' => array('custom', 'native'),
                'cart_page_button_size' => array('custom'),
                'cart_page_button_style' => array('10'),
                'cart_page_circle_button_icon' => array('custom', 'native'),
                'checkout_page_button_icon_open' => array('custom', 'native'),
                'checkout_page_button_size' => array('custom'),
                'checkout_page_button_style' => array('10'),
                'checkout_page_circle_button_icon' => array('custom', 'native'),
                'product_page_button_icon_open' => array('custom', 'native'),
                'product_page_button_size' => array('custom'),
                'product_page_button_style' => array('10'),
                'product_page_circle_button_icon' => array('custom', 'native'),
                'shop_page_button_icon_open' => array('custom', 'native'),
                'shop_page_button_size' => array('custom'),
                'shop_page_button_style' => array('10'),
                'shop_page_circle_button_icon' => array('custom', 'native'),
                'thank_you_page_button_icon_open' => array('custom', 'native'),
                'thank_you_page_button_size' => array('custom'),
                'thank_you_page_button_style' => array('10'),
                'thank_you_page_circle_button_icon' => array('custom', 'native'),
            ),
        ),
        // ── ch_settings ──
        // Webhooks is the one Pro-only tab on this page (see the class docblock);
        // Advanced Controls, Analytics and Additional CSS & JS remain fully free.
        'ch_settings' => array(
            'sections' => array(
                'webhooks',
            ),
        ),
        // ch_shortcode / ch_help have no Pro-only fields: the free plugin already
        // shipped every field these pages register (verified by diffing the
        // pre-migration schema against Pro's).
        //
        // ch_meta (Chat Layouts) and assign_widget (Assign Layouts) are NOT listed
        // here — Chat Layouts inherits Global Chat's boundary via SHARES below, and
        // Assign Layouts has no Pro-only fields, so it is fully free.
    );

    /**
     * Option keys that reuse another key's lock config.
     *
     * Chat Layouts (`ch_meta`) renders the exact same FloatingChatFields schema as
     * Global Chat (`cwp_option`) — only per-widget instead of global — so the
     * free/Pro boundary is identical: any field/option Pro-locked in Global Chat
     * is Pro-locked in a Chat Layout too. Aliasing keeps that guarantee in one
     * place (requirement: "Any field marked Pro in Global Chat should also be
     * marked Pro in Chat Layouts").
     *
     * @var array<string,string>
     */
    const SHARES = array(
        'ch_meta' => 'cwp_option',
    );

    /**
     * The lock config for an option key (empty array when nothing is locked).
     * Keys in SHARES resolve to their source key's config.
     */
    public static function for(string $key): array
    {
        if (isset(self::SHARES[$key])) {
            $key = self::SHARES[$key];
        }
        return self::MAP[$key] ?? array();
    }

    /**
     * Whether every field for this option key is Pro-locked.
     */
    public static function is_all(string $key): bool
    {
        return ! empty(self::MAP[$key]['all']);
    }

    /**
     * Whether a top-level section / section_tab id is Pro-locked.
     */
    public static function is_section_pro(string $key, string $section_id): bool
    {
        $cfg = self::for($key);
        if (! empty($cfg['all'])) {
            return true;
        }
        return \in_array($section_id, $cfg['sections'] ?? array(), true)
            || \in_array($section_id, $cfg['tabs'] ?? array(), true);
    }

    /**
     * Whether a field id is Pro-locked (the whole field).
     */
    public static function is_field_pro(string $key, string $field_id): bool
    {
        $cfg = self::for($key);
        if (! empty($cfg['all'])) {
            return true;
        }
        return \in_array($field_id, $cfg['fields'] ?? array(), true);
    }

    /**
     * The locked option keys for a field (empty array when none).
     *
     * Handles both the static MAP options and DYNAMIC ones (options whose set
     * depends on the site, like registered post types) so new custom post types
     * from themes/plugins are covered automatically with no code changes.
     *
     * @return array<int,string>
     */
    public static function locked_options(string $key, string $field_id): array
    {
        $cfg    = self::for($key);
        $opts   = $cfg['options'][$field_id] ?? array();
        $static = \is_array($opts) ? \array_map('strval', $opts) : array();

        // Assign Layouts post-type picker: only Posts and Pages are free; every
        // other registered public post type is Pro. Detected at runtime, so it
        // adapts to whatever CPTs a given site has.
        if ($key === 'assign_widget' && $field_id === 'widget_post_type') {
            return \array_values(\array_unique(\array_merge($static, self::pro_post_types())));
        }

        // Assign Layouts taxonomy/term picker: only terms of taxonomies attached
        // to the Posts post type are free; every other taxonomy's terms (WooCommerce,
        // CPTs, other plugins) are Pro. Option keys here are term ids.
        if ($key === 'assign_widget' && $field_id === 'widget_taxonomy_terms') {
            return \array_values(\array_unique(\array_merge($static, self::pro_taxonomy_term_ids())));
        }

        return $static;
    }

    /**
     * Public post type slugs that are Pro-only in Assign Layouts — i.e. every
     * public post type except Posts and Pages (and the non-selectable
     * `attachment` media type, which the picker never lists). Auto-detected.
     *
     * @return array<int,string>
     */
    public static function pro_post_types(): array
    {
        $free   = array('post', 'page');
        $locked = array();
        foreach (\get_post_types(array('public' => true)) as $slug) {
            $slug = (string) $slug;
            if (\in_array($slug, $free, true) || $slug === 'attachment') {
                continue;
            }
            $locked[] = $slug;
        }
        return $locked;
    }

    /**
     * Whether a post type slug is usable in the free Assign Layouts feature.
     */
    public static function is_free_post_type(string $slug): bool
    {
        return \in_array($slug, array('post', 'page'), true);
    }

    /**
     * Term ids that are Pro-only in the Assign Layouts taxonomy picker — every
     * term whose taxonomy is NOT attached to the Posts post type (WooCommerce,
     * CPT and other-plugin taxonomies). Only public taxonomies are considered,
     * matching AbstractRestController::resolve_options()'s term list. Detected at
     * runtime, so new custom taxonomies are covered with no code changes.
     *
     * @return array<int,string>
     */
    public static function pro_taxonomy_term_ids(): array
    {
        $free_tax = \get_object_taxonomies('post'); // category, post_tag, post_format, …
        $locked   = array();
        foreach (\get_taxonomies(array('public' => true), 'objects') as $tax) {
            if (\in_array($tax->name, $free_tax, true)) {
                continue;
            }
            $terms = \get_terms(array('taxonomy' => $tax->name, 'hide_empty' => false));
            if (\is_wp_error($terms)) {
                continue;
            }
            foreach ($terms as $term) {
                $locked[] = (string) $term->term_id;
            }
        }
        return $locked;
    }

    /**
     * Whether a taxonomy is usable in the free Assign Layouts feature — i.e. it
     * is attached to the Posts post type.
     */
    public static function is_free_taxonomy(string $taxonomy): bool
    {
        return \in_array($taxonomy, \get_object_taxonomies('post'), true);
    }

    /**
     * Drop any Assign Layouts rows that target a Pro-only post type, so a crafted
     * request can never persist (or later apply) a layout assignment to a
     * Pro post type. Rows with no post type set (e.g. taxonomy-based rows, which
     * default the hidden post-type field) are kept.
     *
     * @param array $values The sanitized `assign_widget` values.
     * @return array
     */
    public static function filter_assign_rows(array $values): array
    {
        if (empty($values['assign_widget_data']) || ! \is_array($values['assign_widget_data'])) {
            return $values;
        }

        // Computed once (each helper enumerates registered types/terms).
        $pro_terms = null;

        $rows = array();
        foreach ($values['assign_widget_data'] as $row) {
            $pt = (\is_array($row) && isset($row['widget_post_type'])) ? (string) $row['widget_post_type'] : '';
            if ($pt !== '' && ! self::is_free_post_type($pt)) {
                continue; // Pro-only post-type assignment — never saved in free.
            }

            // Strip any Pro-only taxonomy terms from the row's term list, keeping
            // the free (Posts) terms. The row survives with only its free terms.
            if (\is_array($row) && ! empty($row['widget_taxonomy_terms']) && \is_array($row['widget_taxonomy_terms'])) {
                if ($pro_terms === null) {
                    $pro_terms = self::pro_taxonomy_term_ids();
                }
                $row['widget_taxonomy_terms'] = \array_values(\array_filter(
                    $row['widget_taxonomy_terms'],
                    static function ($term) use ($pro_terms) {
                        return ! \in_array((string) $term, $pro_terms, true);
                    }
                ));
            }

            $rows[] = $row;
        }
        $values['assign_widget_data'] = \array_values($rows);

        return $values;
    }

    /**
     * The free-plan row cap for a repeater/group field (0 = unlimited).
     */
    public static function row_limit(string $key, string $field_id): int
    {
        $cfg = self::for($key);
        return (int) ($cfg['limits'][$field_id] ?? 0);
    }

    /**
     * All row caps for an option key, as field id => max rows.
     *
     * @return array<string,int>
     */
    public static function row_limits(string $key): array
    {
        $cfg = self::for($key);
        return \array_map('intval', $cfg['limits'] ?? array());
    }
}
