<?php

/**
 * Onboarding REST controller for the React admin SPA.
 *
 * Serves the first-run setup wizard shown on the Global Chat page. Its single
 * route forwards the wizard's optional newsletter opt-in email to the FluentCRM
 * contact webhook server-side via wp_remote_post (the browser never calls the
 * remote site directly, so no CORS), mirroring the Better Chat Support
 * onboarding integration.
 *
 * @package    chat-help
 * @subpackage chat-help/src/Admin/Rest
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Rest;

use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;

if (! defined('ABSPATH')) {
    die;
}

class OnboardingRest extends AbstractRestController
{
    public function register_routes(): void
    {
        // Onboarding newsletter opt-in: forwards the email to the FluentCRM
        // contact webhook server-side (avoids browser CORS to the remote site).
        \register_rest_route(self::NS, '/onboarding/subscribe', [
            'methods'             => WP_REST_Server::CREATABLE,
            'callback'            => [$this, 'subscribe_newsletter'],
            'permission_callback' => [$this, 'can_manage'],
            'args'                => [
                'email' => ['required' => true, 'sanitize_callback' => 'sanitize_email'],
                // The WhatsApp number the wizard just collected (optional) —
                // forwarded to the webhook's `phone` contact field.
                'phone' => ['required' => false, 'sanitize_callback' => 'sanitize_text_field'],
            ],
        ]);
    }

    /**
     * Forward an onboarding email opt-in to the FluentCRM contact webhook.
     *
     * Runs server-side via wp_remote_post so the browser never calls the remote
     * site directly (no CORS), and the contact is added to the configured
     * FluentCRM list. The webhook URL is filterable so it can be overridden
     * without touching code.
     */
    public function subscribe_newsletter(WP_REST_Request $request)
    {
        $email = \sanitize_email($request->get_param('email'));
        if (empty($email) || ! \is_email($email)) {
            return new WP_REST_Response(['success' => false, 'message' => \__('Please enter a valid email.', 'chat-help')], 400);
        }

        $webhook = \apply_filters(
            'chat_help_fluentcrm_webhook',
            'https://wpchathelp.com/?fluentcrm=1&route=contact&hash=a30d4f2d-acf0-45df-be4a-49124ca59429'
        );

        $user       = \wp_get_current_user();
        $first_name = $user ? ($user->first_name ?: $user->display_name) : '';
        $last_name  = $user ? $user->last_name : '';
        $full_name  = \trim($first_name . ' ' . $last_name);

        // Map every webhook field the site can supply automatically. FluentCRM
        // ignores any key it doesn't recognise, so sending the full set is safe.
        $payload = [
            // Contact Fields
            'email'      => $email,
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'full_name'  => $full_name,
            'timezone'   => \wp_timezone_string(),
            // Custom Fields (site environment)
            'website'    => \home_url(),
            'status'     => 'subscribed', // user accepted terms + clicked opt-in
            'php_version' => PHP_VERSION,
            'wp_version' => \get_bloginfo('version'),
            'language'   => \get_locale(),
            'theme'      => \wp_get_theme()->get('Name'),
            'created_at' => \current_time('Y-m-d'), // FluentCRM date field expects Y-m-d
            'source'     => 'Chat Help Onboarding',
        ];

        // The WhatsApp number the wizard collected → the `phone` contact field.
        $phone = \sanitize_text_field((string) $request->get_param('phone'));
        if ($phone !== '') {
            $payload['phone'] = $phone;
        }

        // The admin's IP (this REST call comes from their browser).
        $ip = isset($_SERVER['REMOTE_ADDR']) ? \sanitize_text_field(\wp_unslash($_SERVER['REMOTE_ADDR'])) : '';
        if ($ip !== '') {
            $payload['ip'] = $ip;
        }

        // Best-effort country: the ISO 3166-1 alpha-2 code detected on
        // activation (same source the WhatsApp number field's country picker
        // pre-selects from).
        $country = \get_option('chat_help_default_country', '');
        if (\is_string($country) && \preg_match('/^[a-z]{2}$/i', $country)) {
            $payload['country'] = \strtoupper($country);
        }

        $response = \wp_remote_post($webhook, [
            'timeout' => 15,
            'headers' => ['Content-Type' => 'application/json; charset=utf-8'],
            'body'    => \wp_json_encode(\apply_filters('chat_help_fluentcrm_payload', $payload, $email)),
        ]);

        if (\is_wp_error($response)) {
            return new WP_REST_Response(['success' => false, 'message' => $response->get_error_message()], 502);
        }

        $code = (int) \wp_remote_retrieve_response_code($response);
        $ok   = $code >= 200 && $code < 300;

        return new WP_REST_Response(
            ['success' => $ok, 'code' => $code],
            $ok ? 200 : 502
        );
    }
}
