<?php

/**
 * Dashboard admin page — analytics overview.
 *
 * @package chat-help
 */

namespace ThemeAtelier\ChatHelp\Admin;

if (! defined('ABSPATH')) {
    die;
}

class Dashboard
{

    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts'], 100);
        add_action('admin_head', [$this, 'suppress_notices_and_fix_layout']);
    }

    public function suppress_notices_and_fix_layout(): void
    {
        $screen = get_current_screen();
        if (!$screen || $screen->id !== 'toplevel_page_chat-help') {
            return;
        }

        remove_all_actions('admin_notices');
        remove_all_actions('all_admin_notices');
        remove_all_actions('user_admin_notices');
        remove_all_actions('network_admin_notices');
    }

    public function enqueue_scripts(string $hook): void
    {
        if ($hook !== 'toplevel_page_chat-help') {
            return;
        }

        wp_dequeue_style('common');
        wp_deregister_style('common-css');

        $widgets         = $this->get_floating_widgets();
        $has_global_chat = $this->is_global_chat_active();

        // The React bundle itself is enqueued once by Assets (single owner) to
        // avoid mounting the SPA twice on #chat_help_pro_react. Here we only
        // inject the Dashboard's own runtime data the SPA reads.
        add_action('admin_print_scripts', function () use ($widgets, $has_global_chat) {
            $data = [
                'restUrl'       => esc_url_raw(rest_url('chat-help/v1')),
                'nonce'         => wp_create_nonce('wp_rest'),
                'version'       => CHAT_HELP_VERSION,
                'widgets'       => $widgets,
                'hasGlobalChat' => $has_global_chat,
            ];
            // wp_print_inline_script_tag() prints (and escapes) itself — no echo.
            wp_print_inline_script_tag(
                'window.chatHelpDashboard = ' . wp_json_encode($data) . ';' .
                'window.chatHelp = { restUrl: ' . wp_json_encode(esc_url_raw(rest_url('chat-help/v1'))) . ', nonce: ' . wp_json_encode(wp_create_nonce('wp_rest')) . ' };'
            );
        });
    }

    private function is_global_chat_active(): bool
    {
        $options    = get_option('cwp_option', []);
        $opt_number = isset($options['opt-number']) ? $options['opt-number'] : '';
        $opt_group  = isset($options['opt-group']) ? $options['opt-group'] : '';

        return !empty($opt_number) || !empty($opt_group);
    }

    private function get_floating_widgets(): array
    {
        $posts = get_posts([
            'post_type'      => 'floating_widget',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
        ]);

        $widgets = [];
        foreach ($posts as $post) {
            $widgets[] = [
                'id'    => $post->ID,
                'title' => get_the_title($post),
            ];
        }

        return $widgets;
    }
}
