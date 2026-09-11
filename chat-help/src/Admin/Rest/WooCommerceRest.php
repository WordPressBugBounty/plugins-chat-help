<?php

/**
 * WooCommerce status + installer for the React admin SPA.
 *
 * The WooCommerce settings page configures buttons on shop, product, cart,
 * checkout and thank-you pages — none of which exist without WooCommerce. This
 * controller tells the SPA whether the plugin is there, and installs/activates
 * it from the .org directory on request so the page can offer that in place of
 * a form that would do nothing.
 *
 * @package    chat-help
 * @subpackage chat-help/src/Admin/Rest
 */

namespace ThemeAtelier\ChatHelp\Admin\Rest;

use Plugin_Upgrader;
use WP_Ajax_Upgrader_Skin;
use WP_REST_Server;
use WP_REST_Response;

if (! defined('ABSPATH')) {
    die;
}

class WooCommerceRest extends AbstractRestController
{
    /** The one plugin this controller will ever touch. Never taken from input. */
    const SLUG = 'woocommerce';
    const FILE = 'woocommerce/woocommerce.php';

    public function register_routes(): void
    {
        \register_rest_route(self::NS, '/woocommerce/status', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [$this, 'get_status'],
                'permission_callback' => [$this, 'can_manage'],
            ],
        ]);

        \register_rest_route(self::NS, '/woocommerce/install', [
            [
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => [$this, 'install'],
                // Installing a plugin is a bigger privilege than managing this
                // plugin's settings, so it is gated on WordPress's own caps
                // rather than the dashboard capability used everywhere else.
                'permission_callback' => function () {
                    return \current_user_can('install_plugins') && \current_user_can('activate_plugins');
                },
            ],
        ]);
    }

    /**
     * GET /woocommerce/status — what the SPA needs to decide what to render.
     */
    public function get_status(): WP_REST_Response
    {
        return \rest_ensure_response($this->status());
    }

    /**
     * POST /woocommerce/install — install (if missing) and activate WooCommerce.
     */
    public function install(): WP_REST_Response
    {
        if ($this->is_active()) {
            return \rest_ensure_response($this->status());
        }

        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/misc.php';
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

        if (! $this->is_installed()) {
            $api = \plugins_api('plugin_information', [
                'slug'   => self::SLUG,
                'fields' => ['sections' => false],
            ]);

            if (\is_wp_error($api)) {
                return new WP_REST_Response([
                    'installed' => false,
                    'active'    => false,
                    'message'   => $api->get_error_message(),
                ], 500);
            }

            $skin     = new WP_Ajax_Upgrader_Skin();
            $upgrader = new Plugin_Upgrader($skin);
            $result   = $upgrader->install($api->download_link);

            if (\is_wp_error($result)) {
                return new WP_REST_Response([
                    'installed' => false,
                    'active'    => false,
                    'message'   => $result->get_error_message(),
                ], 500);
            }

            if ($result === false || $skin->get_errors()->has_errors()) {
                return new WP_REST_Response([
                    'installed' => false,
                    'active'    => false,
                    'message'   => \__('WooCommerce could not be downloaded. Install it from Plugins → Add New.', 'chat-help'),
                ], 500);
            }
        }

        $activated = \activate_plugin(self::FILE);
        if (\is_wp_error($activated)) {
            return new WP_REST_Response([
                'installed' => true,
                'active'    => false,
                'message'   => $activated->get_error_message(),
            ], 500);
        }

        return \rest_ensure_response($this->status());
    }

    private function status(): array
    {
        return [
            'installed'  => $this->is_installed(),
            'active'     => $this->is_active(),
            // Whether THIS user may run the install, so the SPA can offer the
            // button or send them to an administrator instead.
            'canInstall' => \current_user_can('install_plugins') && \current_user_can('activate_plugins'),
        ];
    }

    private function is_active(): bool
    {
        return \class_exists('WooCommerce');
    }

    private function is_installed(): bool
    {
        if (! \function_exists('get_plugins')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        return \array_key_exists(self::FILE, \get_plugins());
    }
}
