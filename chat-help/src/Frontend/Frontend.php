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
 * @package     chat-help
 * @subpackage  chat-help/src/Frontend
 * @author      ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Frontend;

use ThemeAtelier\ChatHelp\Frontend\Templates\items\Buttons;
use ThemeAtelier\ChatHelp\Frontend\Templates\ButtonTemplate;
use ThemeAtelier\ChatHelp\Frontend\Templates\FormTemplate;
use ThemeAtelier\ChatHelp\Frontend\Templates\SingleTemplate;
use ThemeAtelier\ChatHelp\Frontend\Templates\WooButton;
use ThemeAtelier\ChatHelp\Helpers\Helpers;

/**
 * The Frontend class to manage all public facing stuffs.
 *
 * @since 1.0.0
 */
class Frontend
{
    /**
     * The slug of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_slug   The slug of this plugin.
     */
    private $plugin_slug;

    /**
     * The min of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $min   The slug of this plugin.
     */
    private $min;
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name       The name of the plugin.
     * @param      string $version    The version of this plugin.
     */
    public function __construct()
    {
        $this->min = defined('WP_DEBUG') && WP_DEBUG ? '' : '.min';
        add_action('wp_footer', array($this, 'chat_help_content'));
        add_action('wp_ajax_handle_form_submission', [$this, 'handle_form_submission']);
        add_action('wp_ajax_nopriv_handle_form_submission', [$this, 'handle_form_submission']);
        $wooButton = new WooButton();
        $options = get_option('cwp_option');
        $wooCommerce_button = isset($options['wooCommerce_button']) ? $options['wooCommerce_button'] : '';
        $button_position = isset($options['wooCommerce_button_position']) ? $options['wooCommerce_button_position'] : 'after';

        $type_of_whatsapp_woo = isset($options['wooCommerce_button_type_of_whatsapp']) ? $options['wooCommerce_button_type_of_whatsapp'] : '';
        $woo_number = isset($options['wooCommerce_button_number']) ? $options['wooCommerce_button_number'] : '';
        $woo_group = isset($options['wooCommerce_button_group']) ? $options['wooCommerce_button_group'] : '';

        if ($wooCommerce_button) {
            if('number' === $type_of_whatsapp_woo && !empty($woo_number) || ('group' === $type_of_whatsapp_woo && !empty($woo_group))){
                add_action("woocommerce_{$button_position}_add_to_cart_form", array($wooButton, 'woo_button'));
            }
        }

        add_filter('kses_allowed_protocols', [$this, 'allow_whatsapp_protocol']);
        
        add_action('wp_head', array($this, 'chat_help_header_script'), 1);
        add_action('login_head', array($this, 'chat_help_header_script'), 1);
        add_action('register_head', array($this, 'chat_help_header_script'), 1);
    }

    function chat_help_header_script()
    {
        $options = get_option('cwp_option');
        $alternative_wHelpBubble = isset($options['alternative_wHelpBubble']) ? $options['alternative_wHelpBubble'] : "";
?>
        <script type="text/javascript" class="chat_help_inline_js">
            var alternativeWHelpBubble = "<?php echo esc_attr($alternative_wHelpBubble); ?>";
        </script>
<?php
    }

    public function allow_whatsapp_protocol($protocols)
    {
        $protocols[] = 'whatsapp';
        return $protocols;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public static function enqueue_scripts()
    {
        $options                 = get_option('cwp_option');
        $wa_custom_css           = isset($options['whatsapp-custom-css']) ? $options['whatsapp-custom-css'] : '';
        $wa_custom_js            = isset($options['whatsapp-custom-js']) ? $options['whatsapp-custom-js'] : '';
        $auto_show_popup         = isset($options['autoshow-popup']) ? $options['autoshow-popup'] : '';
        $auto_open_popup_timeout = isset($options['auto_open_popup_timeout']) ? $options['auto_open_popup_timeout'] : 0;
        $open_in_new_tab         = isset($options['open_in_new_tab']) ? $options['open_in_new_tab'] : '';
        $open_in_new_tab         = $open_in_new_tab ? '_blank' : '_self';
        wp_enqueue_style('ico-font');
        wp_enqueue_style('chat-help-style');
        $custom_css = '';
        include 'dynamic-css/dynamic-css.php';

        if ($wa_custom_css) {
            $custom_css .= $wa_custom_css;
        }

        wp_add_inline_style('chat-help-style', $custom_css);
        wp_enqueue_script('moment', array('jquery'), '1.0', true);
        wp_enqueue_script('moment-timezone-with-data');
        wp_enqueue_script('jquery_validate');
        wp_enqueue_script('chat-help-script');
        $frontend_scripts = array(
            'autoShowPopup'        => $auto_show_popup,
            'autoOpenPopupTimeout' => $auto_open_popup_timeout,
        );
        wp_localize_script('chat-help-script', 'whatshelp_frontend_script', $frontend_scripts);
        if (! empty($wa_custom_js)) {
            wp_add_inline_script('chat-help-script', $wa_custom_js);
        }
        wp_localize_script(
            'chat-help-script',
            'frontend_scripts',
            array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce'   => wp_create_nonce('chat_help_nonce'),
                'open_in_new_tab'   => $open_in_new_tab,
            )
        );
    }

    public function chat_help_content()
    {
        $options = get_option('cwp_option');
        $bubble_include_page = isset($options['bubble_include_page']) ? $options['bubble_include_page'] : '';
        $bubble_exclude_page = isset($options['bubble_exclude_page']) ? $options['bubble_exclude_page'] : '';
        $whatsapp_message_template = isset($options['whatsapp_message_template']) ? $options['whatsapp_message_template'] : '';
        $whatsapp_number = isset($options['opt-number']) ? $options['opt-number'] : '';
        $circle_animation = isset($options['circle-animation']) ? $options['circle-animation'] : '3';
        $chat_type = isset($options['chat_layout']) ? $options['chat_layout'] : 'form';
        $random         = wp_rand(1, 13);
        $bubble_type = Buttons::buttons($options);

        $should_display_element = Helpers::should_display_element($options);
        if ($should_display_element) {
            self::render_chat_template($chat_type, $options, $bubble_type, $random, $whatsapp_message_template);
        }
    }

    public static function render_chat_template($chat_type, $options, $bubble_type, $random, $whatsapp_message_template)
    {
        $type_of_whatsapp = isset($options['type_of_whatsapp']) ? $options['type_of_whatsapp'] : '';
        $opt_number = isset($options['opt-number']) ? $options['opt-number'] : '';
        $opt_group = isset($options['opt-group']) ? $options['opt-group'] : '';
 
        switch ($chat_type) {
            case 'off':
                break;
            case 'button':
                if (('number' === $type_of_whatsapp && !empty($opt_number) || ('group' === $type_of_whatsapp && !empty($opt_group)) )) {
                    ButtonTemplate::buttonTemplate($options, $bubble_type);
                }
                break;
            case 'agent':
      
                if ( ('number' === $type_of_whatsapp && !empty($opt_number) || ('group' === $type_of_whatsapp && !empty($opt_group)) )) {
                    SingleTemplate::singleTemplate($options, $bubble_type, $random, $whatsapp_message_template);
                }
                break;
            case 'form':
                if (!empty($opt_number)) {
                    FormTemplate::formTemplate($options, $bubble_type, $random, $whatsapp_message_template);
                }
                break;

            default:
        }
    }

    public function handle_form_submission()
    {
        // Verify the nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce(wp_unslash($_POST['nonce']), 'chat_help_nonce')) {
            wp_send_json_error('Invalid nonce');
            wp_die();
        }
        parse_str($_POST['data'], $formData);
        $product_id = isset($_POST['product_id']) ? sanitize_text_field($_POST['product_id']) : '';
        $current_url = isset($_POST['current_url']) ? sanitize_url($_POST['current_url']) : '';
        $current_title = isset($_POST['current_title']) ? sanitize_text_field($_POST['current_title']) : '';
        $options = get_option('cwp_option');
        $agent_number = isset($options['opt-number']) ? $options['opt-number'] : '';
        $url_for_desktop = isset($options['url_for_desktop']) ? $options['url_for_desktop'] : '';
        $url_for_mobile = isset($options['url_for_mobile']) ? $options['url_for_mobile'] : '';
        $template = isset($options['whatsapp_message_template']) ? $options['whatsapp_message_template'] : '';
        $form = true;         
        $message = Helpers::replacement_vars($template, $form, $formData, $product_id, $current_url, $current_title);
        $url = Helpers::whatsAppUrl( $agent_number,  $type_of_whatsapp = 'number', $whatsapp_group == '', $url_for_desktop, $url_for_mobile, $message);
        wp_send_json_success(array('whatsAppURL' => $url));
        wp_die();
    }
}
