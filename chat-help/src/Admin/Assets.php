<?php

/**
 * Centralized admin asset loader for the React SPA.
 *
 * Single owner of the React admin bundle (CSS + JS), the media library and the
 * `window.chatHelpAdmin` runtime config the SPA reads (REST url, nonce, version,
 * plugin dir url). The settings pages, dashboard and leads all live in one SPA
 * mounted on `#chat_help_react`, so this loads on every Chat Help admin page.
 *
 *
 * @package    chat-help
 * @subpackage chat-help/src/Admin
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin;

if (! defined('ABSPATH')) {
    die;
}

class Assets
{
    /**
     * The React admin bundle handle (shared with Dashboard/Leads).
     */
    const HANDLE = 'chat-help-admin';

    /**
     * Admin page slugs that host (or redirect into) the React SPA.
     */
    const SPA_SLUGS = [
        'chat-help',
        'chat-help-floating',
        'floating-chat',
        'chat-help-leads',
        'chat-help-woo',
        'chat-help-shortcode',
        'chat-help-settings',
        'chat-help-help',
        'assign-widget',
    ];

    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue'], 100);
    }

    /**
     * Whether the current admin screen is one of the Chat Help SPA pages.
     */
    public function is_chat_help_admin_page(): bool
    {
        $page = isset($_GET['page']) ? sanitize_key(wp_unslash($_GET['page'])) : '';
        return in_array($page, self::SPA_SLUGS, true);
    }

    /**
     * Enqueue the React bundle (CSS + JS) and inject the SPA runtime config.
     *
     * @return void
     */
    public function enqueue(): void
    {
        if (! $this->is_chat_help_admin_page()) {
            return;
        }

        // Print the runtime config independently of the bundle handle so it is
        // available in both the production bundle and the Vite dev server.
        add_action('admin_print_scripts', function () {
            echo '<script>window.chatHelpAdmin = ' . wp_json_encode($this->config()) . ';</script>';
        });

        // Needed by the React media (image) fields.
        wp_enqueue_media();

        // Thickbox for the Help page's recommended-plugin detail modals
        // (the "More Details" links open plugin-install.php in a TB_iframe).
        add_thickbox();

        // Icofont glyphs so the React icon-picker field can preview icons.
        wp_enqueue_style('ico-font');

        // Dev mode: the Vite Dev Helper plugin serves the app (JS + CSS) from
        // the Vite dev server with HMR. The built bundle must NOT load as well:
        // two copies of the app mount on the same root node, and the invisible
        // copy intercepts the wp-admin menu clicks first — the URL updates but
        // the visible app never re-renders. (If the dev server is not running,
        // deactivate the Vite Dev Helper plugin to fall back to this bundle.)
        if (defined('VITE_DEV_URL')) {
            return;
        }

        $base_url = CHAT_HELP_DIR_URL . 'src/Admin/assets/js/';

        // Styles in <head> so they apply before first paint (no flicker once the
        // footer JS runs).
        wp_enqueue_style(
            self::HANDLE,
            $base_url . self::HANDLE . '.css',
            [],
            CHAT_HELP_VERSION
        );

        wp_enqueue_script(
            self::HANDLE,
            $base_url . self::HANDLE . '.js',
            ['wp-i18n'],
            CHAT_HELP_VERSION,
            true
        );

        wp_set_script_translations(self::HANDLE, 'chat-help', CHAT_HELP_DIR_PATH . 'languages');
    }

    /**
     * The SPA runtime config global (window.chatHelpAdmin).
     *
     * @return array<string,mixed>
     */
    private function config(): array
    {
        return [
            'restUrl' => esc_url_raw(rest_url(\ThemeAtelier\ChatHelp\Admin\Rest\AbstractRestController::NS)),
            'nonce'   => wp_create_nonce('wp_rest'),
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'dirUrl'  => CHAT_HELP_DIR_URL,
            'version' => CHAT_HELP_VERSION,
            'adminUrl' => admin_url('admin.php?page=chat-help#/global?section=general'),
            'defaultCountry' => $this->detect_default_country(),
            // Help page: the plugin site + a friendly name for the greeting
            // (mirrors the domain-for-sale reference's `domainForSaleHelp` global).
            'demoUrl'  => CHAT_HELP_DEMO_URL,
            'userName' => $this->current_user_first_name(),
            // Prefill the onboarding newsletter opt-in with the admin's email.
            'adminEmail' => sanitize_email(wp_get_current_user()->user_email),
            // First-run setup wizard signal: true until a WhatsApp number (or
            // group link) is saved. The React Global Chat page shows the
            // animated onboarding overlay when this is true (and the user has
            // not dismissed it locally).
            'onboarding' => $this->needs_onboarding(),
            // Option keys that are Pro-locked in their entirety (Chat Layouts /
            // Assign Layouts). The SPA reads this to disable the create/save/bulk
            // actions on those pages; the REST layer enforces it regardless.
            'proLockedKeys' => $this->pro_locked_keys(),
            // PreviewRest renders the real widget via
            // Frontend::render_chat_template() (Pro's equivalent reuses one
            // Template::content() entry point instead — same idea, different
            // dispatcher) for both Global Chat and Chat Layouts, so the SPA's
            // Live Preview toggle/column are shown just like Pro.
            'livePreview' => true,
        ];
    }

    /**
     * Whether the first-run setup wizard should show: a fresh install with no
     * WhatsApp destination saved yet (mirrors Dashboard::is_global_chat_active).
     */
    private function needs_onboarding(): bool
    {
        $options    = get_option('cwp_option', []);
        $opt_number = isset($options['opt-number']) ? $options['opt-number'] : '';
        $opt_group  = isset($options['opt-group']) ? $options['opt-group'] : '';

        return empty($opt_number) && empty($opt_group);
    }

    /**
     * A friendly name for the Help page greeting: the current user's first
     * name, falling back to display name then login (mirrors the
     * domain-for-sale reference).
     */
    private function current_user_first_name(): string
    {
        $user = wp_get_current_user();
        if (! $user || ! $user->exists()) {
            return '';
        }
        if (! empty($user->first_name)) {
            return $user->first_name;
        }
        return ! empty($user->display_name) ? $user->display_name : $user->user_login;
    }

    /**
     * The option keys ProFeatures locks in full (`'all' => true`).
     *
     * @return array<int,string>
     */
    private function pro_locked_keys(): array
    {
        $keys = [];
        foreach (\array_keys(\ThemeAtelier\ChatHelp\Admin\Schema\ProFeatures::MAP) as $key) {
            if (\ThemeAtelier\ChatHelp\Admin\Schema\ProFeatures::is_all($key)) {
                $keys[] = $key;
            }
        }
        return $keys;
    }

    /**
     * Best-effort ISO 3166-1 alpha-2 country guess used only to pre-select a
     * sensible country/dial-code in the WhatsApp number field's country
     * picker on a fresh install. Never overrides a saved number — the field
     * only falls back to this when it has no value yet.
     *
     * Prefers `chat_help_default_country`, set once on activation (see
     * `chat_help_activate()` in the plugin bootstrap) by geo header / IP
     * lookup / locale, in that order of preference. Falls back to the same
     * site-locale guess directly for installs that were already active
     * before that option existed (the activation hook never re-fires on
     * update, only on a fresh activation).
     */
    private function detect_default_country(): string
    {
        $stored = get_option('chat_help_default_country');
        if (is_string($stored) && preg_match('/^[a-z]{2}$/', $stored)) {
            return $stored;
        }

        $locale = get_locale();
        if (preg_match('/_([A-Za-z]{2})$/', $locale, $matches)) {
            return strtolower($matches[1]);
        }

        return 'us';
    }
}
