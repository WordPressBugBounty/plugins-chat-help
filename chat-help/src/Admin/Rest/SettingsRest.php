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
        // Assign Layouts: drop any row targeting a Pro-only post type (grouped
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
