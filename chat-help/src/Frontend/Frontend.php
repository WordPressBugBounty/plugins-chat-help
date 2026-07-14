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
use ThemeAtelier\ChatHelp\Frontend\Helpers\Helpers;
use ThemeAtelier\ChatHelp\Frontend\Templates\SingleTemplateInput;

if (! defined('ABSPATH')) {
    die;
} // Cannot access directly.
/**
 * The Frontend class to manage all public facing stuffs.
 *
 * @since 1.0.0
 */
class Frontend
{
    /**
     * System / web-safe font families that never need a Google Font stylesheet
     * (already available locally). Mirrors chat-help-pro's list one-for-one so
     * the Typography font-family feature behaves identically across versions.
     *
     * @var array<int,string>
     */
    const SAFE_WEB_FONTS = [
        'Arial', 'Arial Black', 'Helvetica', 'Times New Roman', 'Courier New',
        'Tahoma', 'Verdana', 'Impact', 'Trebuchet MS', 'Comic Sans MS',
        'Lucida Console', 'Lucida Sans Unicode', 'Georgia', 'Palatino Linotype',
    ];

    /**
     * Enqueue a Google Font stylesheet for a resolved typography font-family
     * (the `chat_help_typography` field's `font-family` sub-option). Ported from
     * chat-help-pro so the free version loads the chosen font exactly the same
     * way: the modern `/css2` endpoint, a real `wp_enqueue_style()` handle
     * (deduped, filterable, `null` version so no cache-busting query string),
     * skipped entirely for `SAFE_WEB_FONTS` system fonts.
     *
     * Used by both the real frontend (`enqueue_scripts()`, hooked to
     * `wp_enqueue_scripts` so it prints in `<head>`) and the admin live preview
     * (`PreviewRest::render_assets()`, which needs the returned handle to
     * `wp_styles()->do_items()` it into the preview iframe's head) — one
     * function, so the two can never diverge.
     *
     * @param string $font_family The selected font family name.
     * @return string The registered style handle, or '' if nothing was enqueued.
     */
    public static function enqueue_google_font($font_family)
    {
        $font_family = trim((string) $font_family);
        if (! $font_family || in_array($font_family, self::SAFE_WEB_FONTS, true)) {
            return '';
        }
        $handle          = 'chat-help-google-font-' . sanitize_key($font_family);
        $font_url_family = str_replace(' ', '+', $font_family);
        wp_enqueue_style($handle, "https://fonts.googleapis.com/css2?family={$font_url_family}&display=swap", [], null);
        return $handle;
    }

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

    public $unique_id;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name       The name of the plugin.
     * @param      string $version    The version of this plugin.
     */
    public function __construct()
    {
        $this->unique_id = uniqid();
        $this->min = defined('WP_DEBUG') && WP_DEBUG ? '' : '.min';
        add_action('wp_footer', array($this, 'chat_help_content'));
        add_action('wp_ajax_handle_form_submission', [$this, 'handle_form_submission']);
        add_action('wp_ajax_nopriv_handle_form_submission', [$this, 'handle_form_submission']);

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
        $ch_settings = get_option('ch_settings');
        $wa_custom_css           = isset($ch_settings['whatsapp-custom-css']) ? $ch_settings['whatsapp-custom-css'] : '';
        $wa_custom_js            = isset($ch_settings['whatsapp-custom-js']) ? $ch_settings['whatsapp-custom-js'] : '';
        $auto_show_popup         = isset($options['autoshow-popup']) ? $options['autoshow-popup'] : '';
        $auto_open_popup_timeout = isset($options['auto_open_popup_timeout']) ? $options['auto_open_popup_timeout'] : 0;
        $open_in_new_tab         = isset($ch_settings['open_in_new_tab']) ? $ch_settings['open_in_new_tab'] : '';
        $open_in_new_tab         = $open_in_new_tab ? '_blank' : '_self';

        $google_analytics = isset($ch_settings['google_analytics']) ? $ch_settings['google_analytics'] : '';
        $event_name = isset($ch_settings['event_name']) ? $ch_settings['event_name'] : '';
        $google_analytics_parameter = isset($ch_settings['google_analytics_parameter']) ? $ch_settings['google_analytics_parameter'] : array();
        $analytics_parameter = [];
        $analytics_parameter['google_analytics'] = $google_analytics;
        $analytics_parameter['event_name'] = $event_name;
        $whatsapp_group = isset($options['opt-group']) ? $options['opt-group'] : '';
        $site_title      = get_bloginfo('name'); // WordPress site title
        $current_title = wp_get_document_title();
        $current_url     = home_url(add_query_arg(null, null)); // Current full URL

        if (is_array($google_analytics_parameter)) {
            foreach ($google_analytics_parameter as &$param) {
                if (isset($param['event_parameter_value']) && is_string($param['event_parameter_value'])) {
                    $value = $param['event_parameter_value'];

                    // Handle {number}, {title}, {url}
                    switch ($param['event_parameter']) {
                        case 'title':
                            $value = $site_title;
                            break;
                        case 'current_title':
                            $value = $current_title;
                            break;
                        case 'url':
                            $value = $current_url;
                            break;
                    }

                    $param['event_parameter_value'] = $value;
                }
            }
            unset($param);
        }

        $analytics_parameter['google_analytics_parameter'] = $google_analytics_parameter;

        wp_enqueue_style('ico-font');
        wp_enqueue_style('chat-help-style');

        // Load the chosen Typography Google Font in <head> (skipped for
        // system fonts). The font-family itself is applied by inline_style().
        $chat_help_typography = isset($options['chat_help_typography']) ? $options['chat_help_typography'] : array();
        self::enqueue_google_font(isset($chat_help_typography['font-family']) ? $chat_help_typography['font-family'] : '');

        $custom_css = '';
        if ($wa_custom_css) {
            $custom_css .= $wa_custom_css;
        }

        wp_add_inline_style('chat-help-style', $custom_css);
        wp_enqueue_script('moment', array('jquery'), '1.0', true);
        wp_enqueue_script('moment-timezone-with-data');
        wp_enqueue_script('jquery_validate');
        wp_enqueue_script('chat-help-script');

        $chat_help_frontend_scripts = array(
            'autoShowPopup'        => $auto_show_popup,
            'autoOpenPopupTimeout' => $auto_open_popup_timeout,
            'analytics_parameter'  => $analytics_parameter,
        );
        wp_localize_script('chat-help-script', 'chat_help_script', $chat_help_frontend_scripts);
        if (! empty($wa_custom_js)) {
            wp_add_inline_script('chat-help-script', $wa_custom_js);
        }

        wp_localize_script(
            'chat-help-script',
            'chat_help_frontend_scripts',
            array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce'   => wp_create_nonce('chat_help_nonce'),
                'open_in_new_tab'   => $open_in_new_tab,
                'ip'   => esc_sql(sanitize_text_field($_SERVER['REMOTE_ADDR'])),
            )
        );
    }

    public function chat_help_content()
    {
        $unique_id = "chat_help_button_$this->unique_id";
        $options = get_option('cwp_option');
        $ch_settings = get_option('ch_settings');
        $whatsapp_message_template = isset($options['whatsapp_message_template']) ? $options['whatsapp_message_template'] : '';
        $chat_type = isset($options['chat_layout']) ? $options['chat_layout'] : 'form';
        $random         = wp_rand(1, 13);
        $bubble_type = Buttons::buttons($options, $ch_settings);

        $should_display_element = Helpers::should_display_element($options);
        if ($should_display_element) {
            self::render_chat_template($chat_type, $options, $ch_settings, $bubble_type, $random, $whatsapp_message_template, $unique_id);
        }

        // Every value inside the block is esc_attr()'d (or charset-stripped for
        // the font name) where it's interpolated; wp_kses here validates the
        // <style> wrapper itself without re-encoding the CSS text.
        echo wp_kses(
            self::inline_style($options, $unique_id),
            array('style' => array('type' => true, 'class' => true))
        );
    }

    /**
     * The positioning/color CSS custom-property block, scoped to `#$unique_id`
     * (the widget wrapper's id — see the templates' `id="' . esc_attr($unique_id)`
     * markup). `chat-help-style.css` reads these vars globally (e.g.
     * `background: var(--wHelp-color-primary)`), so this small per-instance
     * block is what actually applies a widget's saved position/colors.
     *
     * Extracted out of chat_help_content() (same output, just returned instead
     * of echoed) so the admin Live Preview can render the identical style block
     * for an unsaved options array without duplicating this template.
     *
     * @param array  $options   The widget's options (cwp_option or ch_meta shape).
     * @param string $unique_id The id of the widget wrapper element this styles.
     * @return string
     */
    public static function inline_style($options, $unique_id)
    {
        $bubble_button_tooltip_background = isset($options['bubble_button_tooltip_background']) ? $options['bubble_button_tooltip_background'] : '#f5f7f9';
        $bubble_button_tooltip_width = isset($options['bubble_button_tooltip_width']) ? $options['bubble_button_tooltip_width'] : 190;
        // Right
        $right_bottom              = isset($options['right_bottom']) ? $options['right_bottom'] : array();
        $right_bottom_value_bottom = isset($right_bottom['bottom']) ? $right_bottom['bottom'] : '25';
        $right_bottom_value_right  = isset($right_bottom['right']) ? $right_bottom['right'] : '30';
        $right_bottom_unit         = isset($right_bottom['unit']) ? $right_bottom['unit'] : 'px';

        // Left
        $left_bottom              = isset($options['left_bottom']) ? $options['left_bottom'] : array();
        $left_bottom_value_bottom = isset($left_bottom['bottom']) ? $left_bottom['bottom'] : '25';
        $left_bottom_value_left   = isset($left_bottom['left']) ? $left_bottom['left'] : '30';
        $left_bottom_unit         = isset($left_bottom['unit']) ? $left_bottom['unit'] : 'px';

        // Right Middle
        $right_middle             = isset($options['right_middle']) ? $options['right_middle'] : array();
        $right_middle_value_right = isset($right_middle['right']) ? $right_middle['right'] : '0';
        $right_middle_unit        = isset($right_middle['unit']) ? $right_middle['unit'] : 'px';

        // Left Middle
        $left_middle            = isset($options['left_middle']) ? $options['left_middle'] : array();
        $left_middle_value_left = isset($left_middle['left']) ? $left_middle['left'] : '0';
        $left_middle_unit       = isset($left_middle['unit']) ? $left_middle['unit'] : 'px';

        // Tablet positioning
        $enable_tablet_positioning = isset($options['enable-positioning-tablet']) ? $options['enable-positioning-tablet'] : '';
        $bubble_position_tablet    = isset($options['bubble-position-tablet']) ? $options['bubble-position-tablet'] : 'right_bottom';

        $color_settings = isset($options['color_settings']) ? $options['color_settings'] : '';
        $primary = isset($color_settings['primary']) ? $color_settings['primary'] : '#118c7e';
        $secondary = isset($color_settings['secondary']) ? $color_settings['secondary'] : '#118c7e';

        // Chat bubble typography (`chat_help_typography` field) — only
        // `font-family` is enabled on that field, so that's all that's applied.
        // The selector mirrors the field's schema `output` key exactly (keep both
        // in sync). `.wHelp button` is required because browsers don't inherit
        // `font-family` into form controls, so submit buttons ("Send Message")
        // would otherwise fall back to the default UI font. The Google Font
        // stylesheet is enqueued separately (frontend: enqueue_scripts(); preview:
        // PreviewRest::render_assets()) via enqueue_google_font().
        $chat_help_typography = isset($options['chat_help_typography']) ? $options['chat_help_typography'] : array();
        $typography_font_family = isset($chat_help_typography['font-family']) ? trim($chat_help_typography['font-family']) : '';
        // Sanitized for direct output inside the raw-text <style> element below.
        // Entities aren't decoded inside <style>, so no escaping function may
        // introduce them there — instead strip everything that isn't part of a
        // real font-family name. That also makes the esc_attr() at the echo a
        // guaranteed no-op (nothing encodable survives this charset).
        $typography_font_family = preg_replace('/[^A-Za-z0-9 _\-]/', '', $typography_font_family);

        ob_start();
    ?>
        <style type="text/css" class="chat_help_inline_css">
            <?php if ($typography_font_family) : ?>
            .wHelp,.wHelp-multi,.wHelp-multi input, .advance_button, .wHelp__popup__content input, .wHelp__popup__content textarea, .wHelp button {
                font-family: "<?php echo esc_attr($typography_font_family); // a no-op: the preg_replace above leaves nothing for esc_attr to encode, so no entities can reach the <style> text ?>";
            }
            <?php endif; ?>
            #<?php echo esc_attr($unique_id); ?> {
                --right_bottom_value_bottom: <?php echo esc_attr($right_bottom_value_bottom . $right_bottom_unit) ?>;
                --right_bottom_value_right: <?php echo esc_attr($right_bottom_value_right . $right_bottom_unit) ?>;
                --left_bottom_value_bottom: <?php echo esc_attr($left_bottom_value_bottom . $left_bottom_unit) ?>;
                --left_bottom_value_left: <?php echo esc_attr($left_bottom_value_left . $left_bottom_unit) ?>;
                --right_middle_value_right: <?php echo esc_attr($right_middle_value_right . $right_middle_unit) ?>;
                --left_middle_value_left: <?php echo esc_attr($left_middle_value_left . $left_middle_unit) ?>;
                --enable_tablet_positioning: <?php echo esc_attr($enable_tablet_positioning . $bubble_position_tablet) ?>;
                --bubble_button_tooltip_background: <?php echo esc_attr($bubble_button_tooltip_background) ?>;
                --bubble_button_tooltip_width: <?php echo esc_attr($bubble_button_tooltip_width) ?>px;

                --wHelp-color-primary: <?php echo esc_attr($primary); ?>;
                --wHelp-color-secondary: <?php echo esc_attr($secondary); ?>;
            }
        </style>
<?php
        return ob_get_clean();
    }

    public static function render_chat_template($chat_type, $options, $ch_settings, $bubble_type, $random, $whatsapp_message_template, $unique_id)
    {
        $type_of_whatsapp = isset($options['type_of_whatsapp']) ? $options['type_of_whatsapp'] : '';
        $opt_number = isset($options['opt-number']) ? $options['opt-number'] : '';
        $opt_group = isset($options['opt-group']) ? $options['opt-group'] : '';

        switch ($chat_type) {
            case 'off':
                break;
            case 'button':
                if (('number' === $type_of_whatsapp && !empty($opt_number) || ('group' === $type_of_whatsapp && !empty($opt_group)))) {
                    ButtonTemplate::buttonTemplate($options, $ch_settings, $bubble_type, $unique_id);
                }
                break;
            case 'agent':
                if (('number' === $type_of_whatsapp && !empty($opt_number) || ('group' === $type_of_whatsapp && !empty($opt_group)))) {
                    SingleTemplate::singleTemplate($options, $ch_settings, $bubble_type, $random, $whatsapp_message_template, $unique_id, $chat_type);
                }
                break;
            case 'agent_input':
                if (('number' === $type_of_whatsapp && !empty($opt_number) || ('group' === $type_of_whatsapp && !empty($opt_group)))) {
                    SingleTemplateInput::singleTemplateInput($options, $ch_settings, $bubble_type, $random, $whatsapp_message_template, $unique_id, $chat_type);
                }
                break;
            case 'form':
                if (('number' === $type_of_whatsapp && !empty($opt_number)) || ('group' === $type_of_whatsapp && !empty($opt_group))) {
                    FormTemplate::formTemplate($options, $ch_settings, $bubble_type, $random, $whatsapp_message_template, $unique_id);
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
        $agentName = isset($_POST['agentName']) ? sanitize_text_field($_POST['agentName']) : '';
        $options = get_option('cwp_option');
        $ch_settings = get_option('ch_settings');
        $agent_number = isset($_POST['number']) && $_POST['number'] !== ''
            ? sanitize_text_field(wp_unslash($_POST['number']))
            : (isset($options['opt-number']) ? $options['opt-number'] : '');
        $whatsapp_group = isset($_POST['group']) && $_POST['group'] !== ''
            ? esc_url_raw(wp_unslash($_POST['group']))
            : (isset($options['opt-group']) ? $options['opt-group'] : '');
        $type_of_whatsapp = isset($_POST['type']) && $_POST['type'] === 'group' ? 'group' : 'number';
        $url_for_desktop = isset($ch_settings['url_for_desktop']) ? $ch_settings['url_for_desktop'] : '';
        $url_for_mobile = isset($ch_settings['url_for_mobile']) ? $ch_settings['url_for_mobile'] : '';
        $chat_layout = isset($options['chat_layout']) ? $options['chat_layout'] : '';
        if ('agent_input' ===  $chat_layout) {
            $template = isset($options['agent_with_input_prefilled_message']) ? $options['agent_with_input_prefilled_message'] : '';
        } else {
            $template = isset($options['whatsapp_message_template']) ? $options['whatsapp_message_template'] : '';
        }
        $chat_help_leads = isset($options['chat_help_leads']) ? $options['chat_help_leads'] : true;

        $form = true;
        $message = Helpers::replacement_vars($template, $form, $formData, $product_id, $current_url, $current_title);
        $url = Helpers::whatsAppUrl($agent_number, $type_of_whatsapp, $whatsapp_group, $url_for_desktop, $url_for_mobile, $message);

        if ($chat_help_leads) {
            $userInfo = isset($_POST['userInfo']) && is_array($_POST['userInfo']) ? array_map('sanitize_text_field', $_POST['userInfo']) : [];

            $current_user_id    = get_current_user_id();
            if ($current_user_id) {
                $current_user = get_userdata($current_user_id);
                if ($current_user) {
                    $extraUserData = [
                        'wp_user_id'    => $current_user->ID,
                        'wp_username'   => $current_user->user_login,
                        'wp_first_name' => get_user_meta($current_user->ID, 'first_name', true),
                        'wp_last_name'  => get_user_meta($current_user->ID, 'last_name', true),
                        'wp_email'      => $current_user->user_email,
                    ];
                    $userInfo = array_merge($userInfo, $extraUserData);
                }
            }

            global $wpdb;
            $tableUsers = $wpdb->prefix . 'chat_help_leads';
            $wpdb->insert(
                $tableUsers,
                [
                    'field'     => maybe_serialize($formData),
                    'meta'      => maybe_serialize($userInfo),
                    'agent_name'  => $agentName,
                ],
                ['%s', '%s', '%s']
            );
        }

        wp_send_json_success(array(
            'whatsAppURL' => $url,
            'type'        => $type_of_whatsapp,
            'message'     => $message,
        ));
        wp_die();
    }
}
