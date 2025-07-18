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

        if ($wooCommerce_button) {
            add_action("woocommerce_{$button_position}_add_to_cart_form", array($wooButton, 'woo_button'));
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
        $current_url = isset($_POST['current_url']) ? sanitize_url($_POST['current_url']) : '';

        $options = get_option('cwp_option');
        $form_editor = isset($options['form_editor']) ? $options['form_editor'] : '';
        $agent_number = isset($options['opt-number']) ? $options['opt-number'] : '';
        $url_for_desktop = isset($options['url_for_desktop']) ? $options['url_for_desktop'] : '';
        $url_for_mobile = isset($options['url_for_mobile']) ? $options['url_for_mobile'] : '';
        $template = isset($options['whatsapp_message_template']) ? $options['whatsapp_message_template'] : '';

        $fields_label = [];
        $fields_data = [];
        $field_index = 1;
        foreach ($form_editor as $field_id => $form_field) {
            $field_name = isset($form_field['field_select']) ? $form_field['field_select'] : '';

            switch ($field_name) {
                case 'text':
                    $field_label = isset($form_field['label']) ? $form_field['label'] : '';
                    $fields_label['label_' . $field_index] = $field_label;
                    $fields_data['text_' . $field_index] = sanitize_text_field($formData['chat_help_text_' . $field_id] ?? '');
                    break;
                case 'textarea':
                    $field_label = isset($form_field['label']) ? $form_field['label'] : '';
                    $fields_label['label_' . $field_index] = $field_label;
                    $fields_data['textarea_' . $field_index] = sanitize_textarea_field($formData['chat_help_textarea_' . $field_id] ?? '');
            }

            $field_index++;
        }

        $form_fields = '';
        foreach ($fields_label as $key => $label) {
            $index = str_replace('label_', '', $key);
            foreach ($fields_data as $data_key => $value) {
                if (strpos($data_key, "_$index") !== false) {
                    $form_fields .= "$label: $value, ";
                    break;
                }
            }
        }

        $form_fields = rtrim($form_fields, ', ');
        $date    = date('F j, Y, H:i (h:i A) (\G\M\T O)');
        $ip      = esc_sql(sanitize_text_field($_SERVER['REMOTE_ADDR']));
        $siteURL = get_site_url();

        $variables = array('{date}', '{ip}', '{siteURL}', '{current_url}');
        $values = array($date, $ip, $siteURL, $current_url);

        foreach ($fields_data as $key => $value) {
            $variables[] = '{' . $key . '}';
            $values[] = $value;
        }

        $text = trim(str_replace($variables, $values, $template));

        $variables[] = '{form_fields}';
        $values[] = $form_fields;

        $text = trim(str_replace($variables, $values, $template));

        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_USER_AGENT'])) : '';
        if (wp_is_mobile() || preg_match('/iPhone|Android|iPod|iPad|webOS|BlackBerry|Windows Phone|Opera Mini|IEMobile|Mobile/', $user_agent)) {
            if ($url_for_mobile == 'protocol') {
                $whatsAppURL = 'whatsapp://send?phone=' . esc_attr($agent_number) . '&text=' . urlencode($text);
            } else {
                $whatsAppURL = 'https://wa.me/' . esc_attr($agent_number) . '?text=' . urlencode($text);
            }
        } else {
            if ($url_for_desktop == 'api') {
                $whatsAppURL = 'https://wa.me/' . esc_attr($agent_number) . '?text=' . urlencode($text);
            } else {
                $whatsAppURL = 'https://web.whatsapp.com/send?phone=' . esc_attr($agent_number) . '&text=' . urlencode($text);
            }
        }

        wp_send_json_success(array('whatsAppURL' => $whatsAppURL));

        wp_die();
    }
}
