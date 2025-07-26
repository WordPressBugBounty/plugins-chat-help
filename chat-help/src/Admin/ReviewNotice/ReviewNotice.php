<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/src/Helpers
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\ReviewNotice;

/**
 * The Helpers class to manage all public facing stuffs.
 *
 * @since 1.0.0
 */
class ReviewNotice
{
    public function __construct()
    {
        add_action('admin_notices', [$this, 'display_admin_notice']);
        add_action('wp_ajax_chat-help-never-show-review-notice', [$this, 'dismiss_review_notice']);
    }
    public function display_admin_notice()
    {
        // Show only to Admins.
        if (! current_user_can('manage_options')) {
            return;
        }

        // Variable default value.
        $review = get_option('chat_help_review_notice_dismiss');
        $time   = time();
        $load   = false;

        if (! $review) {
            $review = array(
                'time'      => $time,
                'dismissed' => false,
            );
            add_option('chat_help_review_notice_dismiss', $review);
        } else {
            // Check if it has been dismissed or not.
            if ((isset($review['dismissed']) && ! $review['dismissed']) && (isset($review['time']) && (($review['time'] + (DAY_IN_SECONDS * 3)) <= $time))) {
                $load = true;
            }
        }

        // If we cannot load, return early.
        if (! $load) {
            return;
        }
?>
        <div id="chat-help-review-notice" class="chat-help-review-notice">
            <div class="chat-help-plugin-icon">
                <img src="<?php echo esc_url(CHAT_HELP_DIR_URL . 'src/Admin/HelpPage/assets/images/chat-logo.png'); ?>" alt="Chat Help">
            </div>
            <div class="chat-help-notice-text">
                <h3>Enjoying <strong>WhatsApp Chat Help</strong>?</h3>
                <p>We hope you had a wonderful experience using <strong>WhatsApp Chat Help</strong>. Please take a moment to leave a review on <a href="https://wordpress.org/support/plugin/chat-help/reviews/?filter=5#new-post" target="_blank"><strong>WordPress.org</strong></a>.
                    Your positive review will help us improve. Thank you! 😊</p>

                <p class="chat-help-review-actions">
                    <a href="https://wordpress.org/support/plugin/chat-help/reviews/?filter=5#new-post" target="_blank" class="button button-primary notice-dismissed rate-chat-help">Ok, you deserve ★★★★★</a>
                    <a href="#" class="notice-dismissed remind-me-later"><span class="dashicons dashicons-clock"></span>Nope, maybe later
                    </a>
                    <a href="#" class="notice-dismissed never-show-again"><span class="dashicons dashicons-dismiss"></span>Never show again</a>
                </p>
            </div>
        </div>

        <script type='text/javascript'>
            jQuery(document).ready(function($) {
                $(document).on('click', '#chat-help-review-notice.chat-help-review-notice .notice-dismissed', function(event) {
                    if ($(this).hasClass('rate-chat-help')) {
                        var notice_dismissed_value = "1";
                    }
                    if ($(this).hasClass('remind-me-later')) {
                        var notice_dismissed_value = "2";
                        event.preventDefault();
                    }
                    if ($(this).hasClass('never-show-again')) {
                        var notice_dismissed_value = "3";
                        event.preventDefault();
                    }

                    $.post(ajaxurl, {
                        action: 'chat-help-never-show-review-notice',
                        notice_dismissed_data: notice_dismissed_value,
                        nonce: '<?php echo esc_attr(wp_create_nonce('chat_help_review_notice')); ?>'
                    });

                    $('#chat-help-review-notice.chat-help-review-notice').hide();
                });
            });
        </script>
<?php
    }

    /**
     * Dismiss review notice
     *
     * @since  2.0.4
     *
     * @return void
     **/
    public function dismiss_review_notice()
    {
        $post_data = wp_unslash($_POST);
        $review    = get_option('chat_help_review_notice_dismiss');

        if (! isset($post_data['nonce']) || ! wp_verify_nonce(sanitize_key($post_data['nonce']), 'chat_help_review_notice')) {
            return;
        }

        if (! $review) {
            $review = array();
        }
        switch (isset($post_data['notice_dismissed_data']) ? $post_data['notice_dismissed_data'] : '') {
            case '1':
                $review['time']      = time();
                $review['dismissed'] = true;
                break;
            case '2':
                $review['time']      = time();
                $review['dismissed'] = false;
                break;
            case '3':
                $review['time']      = time();
                $review['dismissed'] = true;
                break;
        }
        update_option('chat_help_review_notice_dismiss', $review);
        die;
    }
}
