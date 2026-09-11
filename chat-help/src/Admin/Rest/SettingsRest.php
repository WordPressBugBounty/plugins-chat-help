<?php

/**
 * Settings REST controller for the React admin SPA.
 *
 * Exposes the normalized settings schema (read from the SchemaRegistry) plus the
 * current values for a given option key, and persists changes back into that
 * same option the front-end already reads. One controller serves every settings
 * page — the option key travels in the route (`/settings/{key}`) and is
 * validated against the allowlist in AbstractRestController.
 *
 * Backward compatible by design: the field ids, defaults and option keys are the
 * ones the Codestar config classes already defined, so existing saved settings
 * load and save unchanged.
 *
 * @package    chat-help
 * @subpackage chat-help/src/Admin/Rest
 */

namespace ThemeAtelier\ChatHelp\Admin\Rest;

use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;

if (! defined('ABSPATH')) {
    die;
}

class SettingsRest extends AbstractRestController
{
    public function register_routes(): void
    {
        \register_rest_route(self::NS, '/settings/(?P<key>[A-Za-z0-9_\-]+)', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [$this, 'get_settings'],
                'permission_callback' => [$this, 'can_manage'],
            ],
            [
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => [$this, 'save_settings'],
                'permission_callback' => [$this, 'can_manage'],
            ],
        ]);

        // Posts of ONE post type — backs the Assign Chats "Select Post(s)"
        // field, which must re-list its choices whenever its row's "Post Type"
        // changes. Schema options are resolved once when the page loads, so a
        // per-type lookup can't come from there; this route is what makes the
        // list follow the selection.
        \register_rest_route(self::NS, '/posts', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [$this, 'get_posts_by_type'],
                'permission_callback' => [$this, 'can_manage'],
                'args'                => [
                    'post_type' => [
                        'type'              => 'string',
                        // Not strictly required: a bare call (or an older rule
                        // with no type stored) falls back to 'post' below rather
                        // than failing, so the list still loads.
                        'required'          => false,
                        'default'           => 'post',
                        'sanitize_callback' => 'sanitize_key',
                    ],
                ],
            ],
        ]);
    }


    /**
     * Translate the old `after`/`before` button positions to the hook names the
     * Shop, Product and Checkout fields use today.
     *
     * Every WooCommerce tab once stored the position as `after` or `before`.
     * Three of them now store the WooCommerce hook to attach to, and a value
     * left over from that era matches none of the current options — the select
     * rendered blank, so the page reported no position at all when one was in
     * force. The Cart tab still uses `after`/`before`, so it is left alone.
     *
     * Display-side only: the value is corrected as it is read, and the next save
     * writes the current form back.
     *
     * @param array $values The merged option values.
     * @return array
     */
    private function normalize_woo_positions(array $values): array
    {
        $map = [
            'shop_page_button_position'     => [
                'after'  => 'woocommerce_after_shop_loop_item',
                'before' => 'woocommerce_before_shop_loop_item',
            ],
            'product_page_button_position'  => [
                'after'  => 'woocommerce_after_add_to_cart_form',
                'before' => 'woocommerce_before_add_to_cart_form',
            ],
            'checkout_page_button_position' => [
                'after'  => 'woocommerce_review_order_after_submit',
                'before' => 'woocommerce_review_order_before_submit',
            ],
        ];

        foreach ($map as $field => $legacy) {
            if (isset($values[$field]) && isset($legacy[$values[$field]])) {
                $values[$field] = $legacy[$values[$field]];
            }
        }

        return $values;
    }

    /**
     * GET /posts?post_type=<slug> — `{ id: title }` for one post type.
     *
     * Restricted to public post types (minus the excluded ones, e.g. Media), so
     * the route can't be used to enumerate private or internal content.
     */
    public function get_posts_by_type(WP_REST_Request $request): WP_REST_Response
    {
        $post_type = (string) $request->get_param('post_type');
        if ($post_type === '') {
            $post_type = 'post';
        }

        $allowed = \get_post_types(['public' => true], 'names');
        unset($allowed['attachment']);
        if (! \in_array($post_type, $allowed, true)) {
            return new WP_REST_Response(['message' => \__('Unknown post type.', 'chat-help')], 400);
        }

        $out = [];
        $posts = \get_posts([
            'post_type'      => $post_type,
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'cache_results'  => false,
            'no_found_rows'  => true,
        ]);
        foreach ($posts as $post) {
            $out[(string) $post->ID] = ($post->post_title !== '')
                ? $post->post_title
                /* translators: %d: post ID. */
                : \sprintf(\__('(no title) #%d', 'chat-help'), $post->ID);
        }

        return new WP_REST_Response($out, 200);
    }

    /**
     * GET /settings/{key} — returns the normalized schema tree and current values.
     */
    public function get_settings(WP_REST_Request $request): WP_REST_Response
    {
        $key = (string) $request->get_param('key');
        if (! $this->is_valid_settings_key($key)) {
            return new WP_REST_Response(['message' => 'Unknown settings key.'], 404);
        }

        $sections = $this->get_registered_sections($key);
        $tree     = $this->normalize_sections($sections);
        // Mark Pro-only sections/fields/options so React renders them locked.
        $tree     = $this->apply_pro_flags($tree, $key);
        // WooCommerce number/group fields inherit Global Chat values when left
        // empty (WooButton.php render fallback) — surface that in the UI.
        if ($key === 'ch_wooCommerce') {
            $tree = $this->apply_global_fallback_hints($tree);
        }
        $defaults = $this->collect_defaults($sections);

        $saved  = \get_option($key, []);
        $saved  = \is_array($saved) ? $saved : [];
        // Empty-string saved values are treated as "unset" so documented defaults
        // (e.g. Analytics toggle/params) still surface instead of a stale blank.
        $values = $this->merge_defaults($defaults, $saved);
        // Show the Global Chat number/group in empty inheriting fields (display
        // only — save_settings strips them back out, so storage stays empty and
        // the frontend keeps inheriting live).
        $values = $this->fill_global_fallback_values($values, $key);
        if ($key === 'ch_wooCommerce') {
            $values = $this->normalize_woo_positions($values);
        }

        return \rest_ensure_response([
            'key'    => $key,
            'schema' => $tree,
            'values' => $values,
        ]);
    }

    /**
     * POST /settings/{key} — sanitizes by field type and persists to the option.
     *
     * Only the keys submitted for this option are merged in; other options are
     * never touched (each settings page owns exactly one option key).
     */
    public function save_settings(WP_REST_Request $request): WP_REST_Response
    {
        $key = (string) $request->get_param('key');
        if (! $this->is_valid_settings_key($key)) {
            return new WP_REST_Response(['message' => 'Unknown settings key.'], 404);
        }

        $incoming = $request->get_param('values');
        if (! \is_array($incoming)) {
            return new WP_REST_Response(['saved' => false, 'message' => 'Invalid payload.'], 400);
        }

        $sections  = $this->get_registered_sections($key);
        $type_map  = $this->collect_field_types($sections);
        $sanitized = $this->sanitize_values($incoming, $type_map);
        // Never persist Pro-locked keys/options in the free plugin, even if a
        // crafted request submits them.
        $sanitized = $this->strip_pro_keys($sanitized, $key, $sections);
        // Assign Chats: drop any row targeting a Pro-only post type (grouped
        // repeater rows aren't reachable by the flat strip above).
        if ($key === 'assign_widget') {
            $sanitized = \ThemeAtelier\ChatHelp\Admin\Schema\ProFeatures::filter_assign_rows($sanitized);
        }
        // A number/group equal to the current global is the display fill coming
        // back, not a user override — store '' so the field keeps inheriting.
        $sanitized = $this->strip_global_fallback_values($sanitized, $key);

        $existing = \get_option($key, []);
        $existing = \is_array($existing) ? $existing : [];
        $data     = \array_merge($existing, $sanitized);

        \update_option($key, $data);

        return \rest_ensure_response([
            'saved'  => true,
            'key'    => $key,
            'values' => $this->fill_global_fallback_values($data, $key),
        ]);
    }
}
