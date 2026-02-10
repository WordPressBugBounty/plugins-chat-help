<?php

/**
 * The admin-facing functionality of the plugin.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/Admin
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin;

use WP_REST_Server;
use WP_REST_Request;

if (! defined('ABSPATH')) {
    die;
} // Cannot access directly.
/**
 * The admin class
 */
class Leads
{
    /**
     * Constructor.
     *
     * Hooks into WordPress actions and initializes required methods.
     *
     * @since 3.1.0
     */
    function __construct()
    {
        $options = get_option('cwp_option');
        $chat_help_leads    = isset($options['chat_help_leads']) ? $options['chat_help_leads'] : true;
        if ($chat_help_leads) {
            add_action('chat_help_recommended_page_menu', [$this, 'register_chat_help_leads_submenu']);
            add_action('admin_head', array($this, 'chat_help_localize_script'));
            add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'), 100);
            add_action('rest_api_init', [$this, 'register_rest_routes']);

            $this->create_chat_help_leads_table();
        }
    }

    /**
     * Registers the "Leads" submenu page under DFS Templates.
     *
     * @since 3.1.0
     */
    public function register_chat_help_leads_submenu()
    {
        add_submenu_page(
            'chat-help',
            esc_html__('Leads', 'chat-help'),
            __('Leads <span class="update-plugins" style="background:#d63638;color:#fff;border-radius:3px;padding:1px 4px;font-size:10px;vertical-align:middle;float:right;">NEW</span>', 'chat-help'),
            'manage_options',
            'chat-help-leads',
            [$this, 'chat_help_leads_admin']
        );
    }

    /**
     * Renders the Leads admin page container.
     *
     * @since 3.1.0
     */
    public function chat_help_leads_admin()
    {
?>
        <div id="chat_help_leads"></div>
    <?php
    }

    /**
     * Localizes frontend strings for use in JavaScript.
     *
     * @since 3.1.0
     */
    public function chat_help_localize_script()
    {
    ?>
        <script>
            window.chatHelpString = <?php echo json_encode(self::chat_help_string()); ?>;
        </script>
<?php
    }

    /**
     * Creates the Leads database table if it doesn't exist.
     *
     * @since 3.1.0
     */
    public function create_chat_help_leads_table()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'chat_help_leads';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        field LONGTEXT NOT NULL,
        meta LONGTEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    /**
     * Enqueues scripts and injects localized variables for the Leads page.
     *
     * @param string $hook Current admin page hook.
     *
     * @since 3.1.0
     */
    public static function enqueue_scripts($hook)
    {
        if ($hook === 'whatsapp-chat_page_chat-help-leads') {

            wp_dequeue_style('common');
            wp_deregister_style('common-css');

            add_action('admin_print_scripts', function () {
                echo wp_print_inline_script_tag(
                    'window.chatHelp = ' . wp_json_encode([
                        'restUrl' => esc_url_raw(rest_url('chat-help/v1')),
                        'nonce'   => wp_create_nonce('wp_rest'),
                    ]) . ';'
                );
            });

            wp_enqueue_script(
                'chat-help-leads',
                plugin_dir_url(__FILE__) . 'assets/js/chat-help-leads.js',
                array(),
                time(),
                true
            );
        }
    }

    public function register_rest_routes()
    {
        register_rest_route(
            'chat-help/v1',
            '/leads',
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [$this, 'chat_help_leads'],
                'permission_callback' => [$this, 'ch_can_manage_leads'],
            ]
        );

        // Delete leads by ID
        register_rest_route(
            'chat-help/v1',
            '/leads/(?P<id>\d+)',
            [
                'methods'             => WP_REST_Server::DELETABLE,
                'callback'            => [$this, 'delete_chat_help_leads'],
                'permission_callback' => [$this, 'ch_can_manage_leads'],
                'args'                => [
                    'id' => [
                        'validate_callback' => fn($param) => is_numeric($param),
                    ],
                ],
            ]
        );
    }

    /** Write/delete access. */
    public function ch_can_manage_leads(WP_REST_Request $request): bool
    {
        return is_user_logged_in() && current_user_can(apply_filters('chat_help_leads_capability', 'manage_options'));
    }

    // Chat helo leads callback
    public function chat_help_leads(\WP_REST_Request $request)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'chat_help_leads'; // table name
        $results = $wpdb->get_results("SELECT * FROM {$table_name}", ARRAY_A);

        foreach ($results as &$row) {
            if (!empty($row['field'])) {
                $unserialized = @unserialize($row['field']);
                if ($unserialized !== false) {
                    $row['field'] = $unserialized; // now it's an array
                }
            }
            if (!empty($row['meta'])) {
                $unserialized = @unserialize($row['meta']);
                if ($unserialized !== false) {
                    $row['meta'] = $unserialized; // now it's an array
                }
            }
        }
        return new \WP_REST_Response($results, 200);
    }

    // Delete leads call back

    public function delete_chat_help_leads(\WP_REST_Request $request)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'chat_help_leads';
        $id = intval($request['id']);

        $deleted = $wpdb->delete($table_name, ['id' => $id], ['%d']);

        if ($deleted === false) {
            return new \WP_Error('db_error', 'Failed to delete leads', ['status' => 500]);
        }

        if ($deleted === 0) {
            return new \WP_Error('not_found', 'Leads not found', ['status' => 404]);
        }

        return new \WP_REST_Response(['deleted' => true, 'id' => $id], 200);
    }




    /**
     * Returns localized strings for the Leads admin UI.
     *
     * @return array
     *
     * @since 3.1.0
     */
    public static function chat_help_string()
    {
        return [

            'leads' => esc_html__('Leads', 'chat-help'),
            'all_email' => esc_html__('All Email', 'chat-help'),
            'pending_verification' => esc_html__('Pending Verification', 'chat-help'),
            'verified' => esc_html__('Verified', 'chat-help'),
            'resend' => esc_html__('Resend', 'chat-help'),
            'you_can_resend_again_within' => esc_html__('You can resend again within', 'chat-help'),
            'all_domain' => esc_html__('All Domain', 'chat-help'),
            'all_extension' => esc_html__('All Extension', 'chat-help'),
            'search' => esc_html__('Search', 'chat-help'),
            'loading' => esc_html__('Loading...', 'chat-help'),
            'delete_lead' => esc_html__('Delete Lead', 'chat-help'),
            'are_you_sure_you_want_to_delete_this_lead' => esc_html__('Are you sure you want to delete this lead?', 'chat-help'),
            'cancel' => esc_html__('Cancel', 'chat-help'),
            'yes_delete' => esc_html__('Yes, Delete', 'chat-help'),
            'leads_deleted_successful' => esc_html__('Lead(s) deleted successfully!', 'chat-help'),
            'delete_failed' => esc_html__('Delete failed!', 'chat-help'),
            'failed_to_delete_lead' => esc_html__('Failed to delete lead', 'chat-help'),
            'export' => esc_html__('Export', 'chat-help'),
            'action' => esc_html__('Action', 'chat-help'),
            'date' => esc_html__('Date', 'chat-help'),
            'showing' => esc_html__('Showing', 'chat-help'),
            'per_page' => esc_html__('Per page', 'chat-help'),
            'page' => esc_html__('Page', 'chat-help'),
            'others_information' => esc_html__('Others Information', 'chat-help'),
            'form_submitted_data' => esc_html__('Form Submitted Data', 'chat-help'),
            'show_more' => esc_html__('Show More', 'chat-help'),
            'show_less' => esc_html__('Show Less', 'chat-help'),
            'all' => esc_html__('All', 'chat-help'),
            'of' => esc_html__('of', 'chat-help'),
            'copied' => esc_html__('Copied!', 'chat-help'),
            'no_leads_to_export' => esc_html__('No leads to export', 'chat-help'),
            'no_leads_found' => esc_html__('No leads found.', 'chat-help'),
        ];
    }
}
