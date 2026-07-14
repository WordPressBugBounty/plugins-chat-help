<?php

/**
 * Admin live-preview REST controller.
 *
 * Renders the REAL frontend widget — the same `Frontend::render_chat_template()`
 * dispatcher (Buttons/FormTemplate/SingleTemplate/SingleTemplateInput classes),
 * the same compiled CSS, the same jQuery script the live site uses — from inside
 * the admin SPA, so editing a setting updates a genuine iframe'd copy of the
 * widget instead of a hand-maintained re-implementation.
 *
 * The posted `values` are sanitized and merged over the real saved option / post
 * meta (same pattern as `SettingsRest::save_settings()` / `MetaRest::get_widget()`)
 * but NEVER persisted — this endpoint only ever reads, it never calls
 * `update_option()`/`update_post_meta()`.
 *
 * Ported from chat-help-pro's PreviewRest. Pro renders through one unified
 * `Template::content()` entry point; the free frontend instead dispatches per
 * chat-experience type via `Frontend::render_chat_template()` (the exact
 * function `Frontend::chat_help_content()` calls on the live site), which is
 * just as reusable here since it already takes an arbitrary `$options` array —
 * nothing about it is tied to the persisted `cwp_option`. That also means this
 * single endpoint previews both Global Chat (`cwp_option`) AND a Chat Layout
 * (`ch_meta`) with no extra branching.
 *
 * @package    chat-help
 * @subpackage chat-help/src/Admin/Rest
 */

namespace ThemeAtelier\ChatHelp\Admin\Rest;

use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;
use ThemeAtelier\ChatHelp\Frontend\Frontend;
use ThemeAtelier\ChatHelp\Frontend\Templates\items\Buttons;

if (! defined('ABSPATH')) {
    die;
}

class PreviewRest extends AbstractRestController
{
    /** Fixed instead of `wp_rand(1, 13)` so the popup animation doesn't
     *  visibly change on every unrelated field edit while previewing. */
    const PREVIEW_ANIMATION_SEED = 7;

    /** Fixed id for the preview's widget wrapper, so the JS running inside the
     *  preview iframe always targets a stable element. Mirrors the live site's
     *  own `chat_help_button_{uniqid}` naming (see Frontend::chat_help_content())
     *  though the exact prefix doesn't matter — inline_style() and the wrapper
     *  markup both key off this same string, so they always agree. */
    const PREVIEW_UNIQUE_ID = 'chat_help_button_chp_admin_preview';

    public function register_routes(): void
    {
        \register_rest_route(self::NS, '/preview/settings/(?P<key>[A-Za-z0-9_\-]+)', [
            'methods'             => WP_REST_Server::CREATABLE,
            'callback'            => [$this, 'preview_settings'],
            'permission_callback' => [$this, 'can_manage'],
        ]);

        \register_rest_route(self::NS, '/preview/widgets/(?P<id>new|\d+)', [
            'methods'             => WP_REST_Server::CREATABLE,
            'callback'            => [$this, 'preview_widget'],
            'permission_callback' => [$this, 'can_manage'],
        ]);
    }

    /**
     * POST /preview/settings/{key} — only `cwp_option` (Global Chat) renders a
     * widget; other keys are accepted but resolve to an empty body (no
     * `chat_layout`/WhatsApp number in their values for render_chat_template to
     * act on — same as the live site rendering nothing when unconfigured).
     */
    public function preview_settings(WP_REST_Request $request): WP_REST_Response
    {
        $key = (string) $request->get_param('key');
        if (! $this->is_valid_settings_key($key)) {
            return new WP_REST_Response(['message' => 'Unknown settings key.'], 404);
        }

        $incoming = $request->get_param('values');
        $incoming = \is_array($incoming) ? $incoming : [];

        $sections = $this->get_registered_sections($key);
        $type_map = $this->collect_field_types($sections);
        $sanitized = $this->sanitize_values($incoming, $type_map);

        $existing = \get_option($key, []);
        $existing = \is_array($existing) ? $existing : [];
        $merged   = \array_merge($existing, $sanitized);

        return \rest_ensure_response($this->render($merged));
    }

    /**
     * POST /preview/widgets/{id} — {id} is `new` for an unsaved Chat Layout (no
     * post meta yet) or a real post id for an existing one.
     */
    public function preview_widget(WP_REST_Request $request): WP_REST_Response
    {
        $id = (string) $request->get_param('id');

        $sections = $this->get_registered_sections(MetaRest::META_KEY);
        $type_map = $this->collect_field_types($sections);
        $defaults = $this->collect_defaults($sections);

        $saved = [];
        if ($id !== 'new') {
            $post_id = (int) $id;
            if (\get_post_type($post_id) !== MetaRest::POST_TYPE) {
                return new WP_REST_Response(['message' => 'Not found.'], 404);
            }
            $meta  = \get_post_meta($post_id, MetaRest::META_KEY, true);
            $saved = \is_array($meta) ? $meta : [];
        }

        $incoming  = $request->get_param('values');
        $incoming  = \is_array($incoming) ? $incoming : [];
        $sanitized = $this->sanitize_values($incoming, $type_map);

        // Mirrors MetaRest::get_widget()'s plain array_merge (not
        // merge_defaults()), so preview values line up with what
        // WidgetEditor.jsx already loaded into its form state.
        $merged = \array_merge($defaults, $saved, $sanitized);

        return \rest_ensure_response($this->render($merged));
    }

    /**
     * Render the widget for a merged (never persisted) options array: the
     * CSS-variable style block + widget HTML from the real `Frontend`
     * templates, plus a `<head>` fragment loading the real frontend CSS/JS
     * handles via `WP_Styles`/`WP_Scripts::do_items()` (resolves each handle's
     * actual registered src/version/deps — nothing here hardcodes a URL).
     *
     * Deliberately bypasses `Helpers::should_display_element()` (the live
     * site's page-visibility gate): a preview should always show the widget
     * regardless of the include/exclude page rules, exactly like Pro's
     * `$force_display = true`.
     *
     * @return array{head:string,body:string,foot:string}
     */
    private function render(array $options): array
    {
        $ch_settings = \get_option('ch_settings');
        $ch_settings = \is_array($ch_settings) ? $ch_settings : [];

        $chat_type = $options['chat_layout'] ?? 'form';
        $whatsapp_message_template = $options['whatsapp_message_template'] ?? '';
        $bubble_type = Buttons::buttons($options, $ch_settings);

        \ob_start();
        Frontend::render_chat_template(
            $chat_type,
            $options,
            $ch_settings,
            $bubble_type,
            self::PREVIEW_ANIMATION_SEED,
            $whatsapp_message_template,
            self::PREVIEW_UNIQUE_ID
        );
        $body = Frontend::inline_style($options, self::PREVIEW_UNIQUE_ID) . \ob_get_clean();

        [$head, $foot] = $this->render_assets($options, $ch_settings);

        return ['head' => $head, 'body' => $body, 'foot' => $foot];
    }

    /**
     * Mirrors the two `wp_localize_script()` calls in
     * `Frontend::enqueue_scripts()` (built from the merged preview options
     * instead of the real `cwp_option`/`ch_settings` — irrelevant here, the
     * preview already knows exactly which options to render), then prints the
     * real registered CSS + JS tags.
     *
     * Styles are safe to return for `<head>`, but the scripts MUST be rendered
     * separately and placed after the widget's body HTML: `chat-help-script.js`
     * queries `.wHelp-bubble` etc. at its top level (unguarded, not inside a
     * DOMContentLoaded handler), so by the time it runs the widget markup must
     * already exist in the DOM — printing it in `<head>` would silently find
     * nothing and no click handler would ever bind.
     *
     * @return array{0:string,1:string} [$headHtml, $footHtml]
     */
    private function render_assets(array $options, array $ch_settings): array
    {
        $auto_show_popup            = $options['autoshow-popup'] ?? '';
        $auto_open_popup_timeout    = $options['auto_open_popup_timeout'] ?? 0;
        $open_in_new_tab            = ! empty($ch_settings['open_in_new_tab']) ? '_blank' : '_self';
        $google_analytics           = $ch_settings['google_analytics'] ?? '';
        $event_name                 = $ch_settings['event_name'] ?? '';
        $google_analytics_parameter = \is_array($ch_settings['google_analytics_parameter'] ?? null) ? $ch_settings['google_analytics_parameter'] : [];

        $analytics_parameter = [
            'google_analytics'           => $google_analytics,
            'event_name'                 => $event_name,
            'google_analytics_parameter' => $google_analytics_parameter,
        ];

        \wp_localize_script('chat-help-script', 'chat_help_script', [
            'autoShowPopup'        => $auto_show_popup,
            'autoOpenPopupTimeout' => $auto_open_popup_timeout,
            'analytics_parameter'  => $analytics_parameter,
        ]);

        \wp_localize_script('chat-help-script', 'chat_help_frontend_scripts', [
            'ajaxurl'         => \admin_url('admin-ajax.php'),
            'nonce'           => \wp_create_nonce('chat_help_nonce'),
            'open_in_new_tab' => $open_in_new_tab,
            'ip'              => '',
        ]);

        \wp_enqueue_style('ico-font');
        \wp_enqueue_style('chat-help-style');
        // 'moment' is WP core's bundled moment.js handle — moment-timezone-with-data
        // is only the timezone-data extension and expects the `moment` global to
        // already exist (mirrors Frontend::enqueue_scripts()' real frontend call).
        \wp_enqueue_script('moment');
        \wp_enqueue_script('moment-timezone-with-data');
        \wp_enqueue_script('jquery_validate');
        \wp_enqueue_script('chat-help-script');

        // Same Typography Google Font the real frontend loads, via the one shared
        // Frontend::enqueue_google_font() — so the preview iframe and the live
        // site can never diverge on the chosen font. The returned handle ('' for
        // no/system font) is picked up by do_items() below so the <link> lands in
        // the iframe's <head>. inline_style() (in render()) applies the actual
        // font-family rule.
        $chat_help_typography = $options['chat_help_typography'] ?? [];
        $google_font_handle   = \ThemeAtelier\ChatHelp\Frontend\Frontend::enqueue_google_font(
            (string) ($chat_help_typography['font-family'] ?? '')
        );

        // Mirrors Frontend::chat_help_header_script(), normally printed on
        // `wp_head` — chat-help-script.js references this bare global
        // (unguarded, top-level) at load time, so without it the script throws
        // immediately and every click handler in it silently never gets bound.
        $alternative_bubble = $options['alternative_wHelpBubble'] ?? '';

        $style_handles = ['ico-font', 'chat-help-style'];
        if ($google_font_handle) {
            $style_handles[] = $google_font_handle;
        }

        \ob_start();
        \wp_styles()->do_items($style_handles);
        $head = \ob_get_clean();

        \ob_start();
        \wp_print_inline_script_tag(
            'var alternativeWHelpBubble = ' . \wp_json_encode((string) $alternative_bubble) . ';'
        );
        \wp_scripts()->do_items(['jquery', 'moment', 'moment-timezone-with-data', 'jquery_validate', 'chat-help-script']);
        $foot = \ob_get_clean();

        return [$head, $foot];
    }
}
