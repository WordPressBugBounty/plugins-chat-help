<?php

/**
 * Framework setup.class file.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package    chat-help
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Framework\Classes;

if (! class_exists('Chat_Help')) {
  class Chat_Help
  {

    // Default constants
    public static $premium  = true;
    public static $version  = CHAT_HELP_VERSION;
    public static $dir      = '';
    public static $url      = '';
    public static $css      = '';
    public static $file     = '';
    public static $enqueue  = false;
    public static $webfonts = array();
    public static $subsets  = array();
    public static $inited   = array();
    public static $fields   = array();
    public static $args     = array(
      'admin_options'       => array(),
      'customize_options'   => array(),
      'metabox_options'     => array(),
      'nav_menu_options'    => array(),
      'profile_options'     => array(),
      'taxonomy_options'    => array(),
      'widget_options'      => array(),
      'comment_options'     => array(),
      'shortcode_options'   => array(),
    );

    // Shortcode instances
    public static $shortcode_instances = array();

    private static $instance = null;

    public static function init($file = __FILE__, $premium = true)
    {

      // Set file constant
      self::$file = $file;

      // Set file constant
      self::$premium = $premium;

      // Set constants
      self::constants();

      // Include files
      self::includes();

      if (is_null(self::$instance)) {
        self::$instance = new self();
      }

      return self::$instance;
    }

    // Initalize
    public function __construct()
    {

      // Init action
      do_action('chat_help_init');

      add_action('after_setup_theme', array('ThemeAtelier\ChatHelp\Admin\Framework\Classes\Chat_Help', 'setup'));
      add_action('init', array('ThemeAtelier\ChatHelp\Admin\Framework\Classes\Chat_Help', 'setup'));
      add_action('switch_theme', array('ThemeAtelier\ChatHelp\Admin\Framework\Classes\Chat_Help', 'setup'));
      add_action('admin_enqueue_scripts', array('ThemeAtelier\ChatHelp\Admin\Framework\Classes\Chat_Help', 'add_admin_enqueue_scripts'));
      add_action('wp_enqueue_scripts', array('ThemeAtelier\ChatHelp\Admin\Framework\Classes\Chat_Help', 'add_typography_enqueue_styles'), 80);
      add_action('wp_head', array('ThemeAtelier\ChatHelp\Admin\Framework\Classes\Chat_Help', 'add_custom_css'), 80);
      add_filter('admin_body_class', array('ThemeAtelier\ChatHelp\Admin\Framework\Classes\Chat_Help', 'add_admin_body_class'));
    }

    // Setup frameworks
    public static function setup()
    {

      // Setup admin option framework
      $params = array();
      if (class_exists('Chat_Help_Options') && ! empty(self::$args['admin_options'])) {
        foreach (self::$args['admin_options'] as $key => $value) {
          if (! empty(self::$args['sections'][$key]) && ! isset(self::$inited[$key])) {

            $params['args']     = $value;
            $params['sections'] = self::$args['sections'][$key];
            self::$inited[$key] = true;

            \Chat_Help_Options::instance($key, $params);

            if (! empty($value['show_in_customizer'])) {
              $value['output_css'] = false;
              $value['enqueue_webfont'] = false;
              self::$args['customize_options'][$key] = $value;
              self::$inited[$key] = null;
            }
          }
        }
      }

      // Setup metabox option framework
      $params = array();
      if (class_exists('Chat_Help_Metabox') && ! empty(self::$args['metabox_options'])) {
        foreach (self::$args['metabox_options'] as $key => $value) {
          if (! empty(self::$args['sections'][$key]) && ! isset(self::$inited[$key])) {

            $params['args']     = $value;
            $params['sections'] = self::$args['sections'][$key];
            self::$inited[$key] = true;

            \Chat_Help_Metabox::instance($key, $params);
          }
        }
      }

      do_action('CHAT_HELP_loaded');
    }

    // Create options
    public static function createOptions($id, $args = array())
    {
      self::$args['admin_options'][$id] = $args;
    }

    // Create customize options
    public static function createCustomizeOptions($id, $args = array())
    {
      self::$args['customize_options'][$id] = $args;
    }

    // Create metabox options
    public static function createMetabox($id, $args = array())
    {
      self::$args['metabox_options'][$id] = $args;
    }

    // Create menu options
    public static function createNavMenuOptions($id, $args = array())
    {
      self::$args['nav_menu_options'][$id] = $args;
    }

    // Create shortcoder options
    public static function createShortcoder($id, $args = array())
    {
      self::$args['shortcode_options'][$id] = $args;
    }

    // Create taxonomy options
    public static function createTaxonomyOptions($id, $args = array())
    {
      self::$args['taxonomy_options'][$id] = $args;
    }

    // Create profile options
    public static function createProfileOptions($id, $args = array())
    {
      self::$args['profile_options'][$id] = $args;
    }

    // Create widget
    public static function createWidget($id, $args = array())
    {
      self::$args['widget_options'][$id] = $args;
      self::set_used_fields($args);
    }

    // Create comment metabox
    public static function createCommentMetabox($id, $args = array())
    {
      self::$args['comment_options'][$id] = $args;
    }

    // Create section
    public static function createSection($id, $sections)
    {
      self::$args['sections'][$id][] = $sections;
      self::set_used_fields($sections);
    }

    // Set directory constants
    public static function constants()
    {

      // We need this path-finder code for set URL of framework
      $dirname        = str_replace('//', '/', wp_normalize_path(dirname(dirname(self::$file))));
      $theme_dir      = str_replace('//', '/', wp_normalize_path(get_parent_theme_file_path()));
      $plugin_dir     = str_replace('//', '/', wp_normalize_path(WP_PLUGIN_DIR));
      $plugin_dir     = str_replace('/opt/bitnami', '/bitnami', $plugin_dir);
      $located_plugin = (preg_match('#' . self::sanitize_dirname($plugin_dir) . '#', self::sanitize_dirname($dirname))) ? true : false;
      $directory      = ($located_plugin) ? $plugin_dir : $theme_dir;
      $directory_uri  = ($located_plugin) ? WP_PLUGIN_URL : get_parent_theme_file_uri();
      $foldername     = str_replace($directory, '', $dirname);
      $protocol_uri   = (is_ssl()) ? 'https' : 'http';
      $directory_uri  = set_url_scheme($directory_uri, $protocol_uri);

      self::$dir = $dirname;
      self::$url = $directory_uri . $foldername;
    }

    // Include file helper
    public static function include_plugin_file($file, $load = true)
    {

      $path     = '';
      $file     = ltrim($file, '/');
      $override = apply_filters('chat_help_override', 'chat-help-override');

      if (file_exists(get_parent_theme_file_path($override . '/' . $file))) {
        $path = get_parent_theme_file_path($override . '/' . $file);
      } elseif (file_exists(get_theme_file_path($override . '/' . $file))) {
        $path = get_theme_file_path($override . '/' . $file);
      } elseif (file_exists(self::$dir . '/' . $override . '/' . $file)) {
        $path = self::$dir . '/' . $override . '/' . $file;
      } elseif (file_exists(self::$dir . '/' . $file)) {
        $path = self::$dir . '/' . $file;
      }

      if (! empty($path) && ! empty($file) && $load) {

        global $wp_query;

        if (is_object($wp_query) && function_exists('load_template')) {

          load_template($path, true);
        } else {

          require_once($path);
        }
      } else {

        return self::$dir . '/' . $file;
      }
    }

    // Is active plugin helper
    public static function is_active_plugin($file = '')
    {
      return in_array($file, (array) get_option('active_plugins', array()));
    }

    // Sanitize dirname
    public static function sanitize_dirname($dirname)
    {
      return preg_replace('/[^A-Za-z]/', '', $dirname);
    }

    // Set url constant
    public static function include_plugin_url($file)
    {
      return esc_url(self::$url) . '/' . ltrim($file, '/');
    }

    // Include files
    public static function includes()
    {

      // Include common functions
      self::include_plugin_file('functions/actions.php');
      self::include_plugin_file('functions/helpers.php');
      self::include_plugin_file('functions/sanitize.php');
      self::include_plugin_file('functions/validate.php');

      // Include free version classes
      self::include_plugin_file('Classes/abstract.class.php');
      self::include_plugin_file('Classes/fields.class.php');
      self::include_plugin_file('Classes/Chat_Help_Options.php');
      self::include_plugin_file('Classes/Chat_Help_Metabox.php');

      // Include all framework fields
      $fields = apply_filters('chat_help_fields', array(
        'accordion',
        'background',
        'backup',
        'border',
        'button_set',
        'callback',
        'checkbox',
        'code_editor',
        'color',
        'color_group',
        'content',
        'date',
        'datetime',
        'dimensions',
        'fieldset',
        'gallery',
        'group',
        'heading',
        'icon',
        'image_select',
        'layout_preset',
        'license',
        'link',
        'link_color',
        'map',
        'media',
        'notice',
        'number',
        'palette',
        'radio',
        'repeater',
        'select',
        'slider',
        'sortable',
        'sorter',
        'ta_help',
        'shortcode',
        'spacing',
        'spinner',
        'subheading',
        'submessage',
        'switcher',
        'section_tab',
        'tabbed',
        'text',
        'textarea',
        'typography',
        'upload',
        'wp_editor',
      ));

      if (! empty($fields)) {
        foreach ($fields as $field) {

          if (! class_exists('CHAT_HELP_Field_' . $field) && class_exists('CHAT_HELP_Fields')) {
            self::include_plugin_file('fields/' . $field . '/' . $field . '.php');
          }
        }
      }
    }

    // Set all of used fields
    public static function set_used_fields($sections)
    {

      if (! empty($sections['fields'])) {

        foreach ($sections['fields'] as $field) {

          if (! empty($field['fields'])) {
            self::set_used_fields($field);
          }

          if (! empty($field['tabs'])) {
            self::set_used_fields(array('fields' => $field['tabs']));
          }

          if (! empty($field['accordions'])) {
            self::set_used_fields(array('fields' => $field['accordions']));
          }

          if (! empty($field['elements'])) {
            self::set_used_fields(array('fields' => $field['elements']));
          }

          if (! empty($field['type'])) {
            self::$fields[$field['type']] = $field;
          }
        }
      }
    }

    // Enqueue admin and fields styles and scripts
    public static function add_admin_enqueue_scripts()
    {

      if (! self::$enqueue) {

        // Loads scripts and styles only when needed
        $wpscreen = get_current_screen();

        if (! empty(self::$args['admin_options'])) {
          foreach (self::$args['admin_options'] as $argument) {
            if (substr($wpscreen->id, -strlen($argument['menu_slug'])) === $argument['menu_slug']) {
              self::$enqueue = true;
            }
          }
        }

        if (! empty(self::$args['metabox_options'])) {
          foreach (self::$args['metabox_options'] as $argument) {
            if (in_array($wpscreen->post_type, (array) $argument['post_type'])) {
              self::$enqueue = true;
            }
          }
        }

        if (! empty(self::$args['taxonomy_options'])) {
          foreach (self::$args['taxonomy_options'] as $argument) {
            if (in_array($wpscreen->taxonomy, (array) $argument['taxonomy'])) {
              self::$enqueue = true;
            }
          }
        }

        if (! empty(self::$shortcode_instances)) {
          foreach (self::$shortcode_instances as $argument) {
            if (($argument['show_in_editor'] && $wpscreen->base === 'post') || $argument['show_in_custom']) {
              self::$enqueue = true;
            }
          }
        }

        if (! empty(self::$args['widget_options']) && ($wpscreen->id === 'widgets' || $wpscreen->id === 'customize')) {
          self::$enqueue = true;
        }

        if (! empty(self::$args['customize_options']) && $wpscreen->id === 'customize') {
          self::$enqueue = true;
        }

        if (! empty(self::$args['nav_menu_options']) && $wpscreen->id === 'nav-menus') {
          self::$enqueue = true;
        }

        if (! empty(self::$args['profile_options']) && ($wpscreen->id === 'profile' || $wpscreen->id === 'user-edit')) {
          self::$enqueue = true;
        }

        if (! empty(self::$args['comment_options']) && $wpscreen->id === 'comment') {
          self::$enqueue = true;
        }

        if ($wpscreen->id === 'tools_page_chat-help-welcome') {
          self::$enqueue = true;
        }
      }

      if (! apply_filters('chat_help_enqueue_assets', self::$enqueue)) {
        return;
      }

      // Admin utilities
      wp_enqueue_media();

      // Wp color picker
      wp_enqueue_style('wp-color-picker');
      wp_enqueue_style('ico-font');

      wp_enqueue_script('wp-color-picker');

      // Check for developer mode
      $min = (self::$premium && SCRIPT_DEBUG) ? '' : '.min';

      // Main style
      wp_enqueue_style('chat-help', self::include_plugin_url('assets/css/style' . $min . '.css'), array(), self::$version, 'all');

      // Main RTL styles
      if (is_rtl()) {
        wp_enqueue_style('chat-help-rtl', self::include_plugin_url('assets/css/style-rtl' . $min . '.css'), array(), self::$version, 'all');
      }

      // Custom style
      wp_enqueue_style('chat-help-help-page', self::include_plugin_url('assets/css/help-page' . $min . '.css'), array(), self::$version, 'all');

      // Main scripts
      wp_enqueue_script('chat-help-plugins', self::include_plugin_url('assets/js/plugins' . $min . '.js'), array(), self::$version, true);
      wp_enqueue_script('chat-help', self::include_plugin_url('assets/js/main' . $min . '.js'), array('chat-help-plugins'), self::$version, true);
      wp_enqueue_script('chat-help-help-page', self::include_plugin_url('assets/js/help-page' . $min . '.js'), array('chat-help-plugins'), self::$version, true);

      // Main variables
      wp_localize_script('chat-help', 'chat_help_vars', array(
        'color_palette'     => apply_filters('chat_help_color_palette', array()),
        'i18n'              => array(
          'confirm'         => esc_html__('Are you sure?', 'chat-help'),
          'typing_text'     => esc_html__('Please enter %s or more characters', 'chat-help'),
          'searching_text'  => esc_html__('Searching...', 'chat-help'),
          'no_results_text' => esc_html__('No results found.', 'chat-help'),
        ),
      ));

      // Enqueue fields scripts and styles
      $enqueued = array();

      if (! empty(self::$fields)) {
        foreach (self::$fields as $field) {
          if (! empty($field['type'])) {
            $classname = 'CHAT_HELP_Field_' . $field['type'];
            if (class_exists($classname) && method_exists($classname, 'enqueue')) {
              $instance = new $classname($field);
              if (method_exists($classname, 'enqueue')) {
                $instance->enqueue();
              }
              unset($instance);
            }
          }
        }
      }

      do_action('chat_help_enqueue');
    }

    // Add typography enqueue styles to front page
    public static function add_typography_enqueue_styles()
    {

      if (! empty(self::$webfonts)) {

        if (! empty(self::$webfonts['enqueue'])) {

          $query = array();
          $fonts = array();

          foreach (self::$webfonts['enqueue'] as $family => $styles) {
            $fonts[] = $family . ((! empty($styles)) ? ':' . implode(',', $styles) : '');
          }

          if (! empty($fonts)) {
            $query['family'] = implode('%7C', $fonts);
          }

          if (! empty(self::$subsets)) {
            $query['subset'] = implode(',', self::$subsets);
          }

          $query['display'] = 'swap';

          wp_enqueue_style('chat-help-google-web-fonts', esc_url(add_query_arg($query, '//fonts.googleapis.com/css')), array(), null);
        }

        if (! empty(self::$webfonts['async'])) {

          $fonts = array();

          foreach (self::$webfonts['async'] as $family => $styles) {
            $fonts[] = $family . ((! empty($styles)) ? ':' . implode(',', $styles) : '');
          }

          wp_enqueue_script('chat-help-google-web-fonts', esc_url('//ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js'), array(), null);

          wp_localize_script('chat-help-google-web-fonts', 'WebFontConfig', array('google' => array('families' => $fonts)));
        }
      }
    }

    // Add admin body class
    public static function add_admin_body_class($classes)
    {

      if (apply_filters('CHAT_HELP_fa4', false)) {
        $classes .= 'chat-help-fa5-shims';
      }

      return $classes;
    }

    // Add custom css to front page
    public static function add_custom_css()
    {

      if (! empty(self::$css)) {
        echo '<style type="text/css">' . wp_kses_post(wp_strip_all_tags(self::$css)) . '</style>';
      }
    }

    // Add a new framework field
    public static function field($field = array(), $value = '', $unique = '', $where = '', $parent = '')
    {

      // Check for unallow fields
      if (! empty($field['_notice'])) {

        $field_type = $field['type'];

        $field            = array();
        $field['content'] = esc_html__('Oops! Not allowed.', 'chat-help') . ' <strong>(' . esc_html($field_type) . ')</strong>';
        $field['type']    = 'notice';
        $field['style']   = 'danger';
      }

      $depend     = '';
      $visible    = '';
      $unique     = (! empty($unique)) ? $unique : '';
      $class      = (! empty($field['class'])) ? ' ' . esc_attr($field['class']) : '';
      $is_pseudo  = (! empty($field['pseudo'])) ? ' chat-help-pseudo-field' : '';
      $field_type = (! empty($field['type'])) ? esc_attr($field['type']) : '';

      if (! empty($field['dependency'])) {

        $dependency      = $field['dependency'];
        $depend_visible  = '';
        $data_controller = '';
        $data_condition  = '';
        $data_value      = '';
        $data_global     = '';

        if (is_array($dependency[0])) {
          $data_controller = implode('|', array_column($dependency, 0));
          $data_condition  = implode('|', array_column($dependency, 1));
          $data_value      = implode('|', array_column($dependency, 2));
          $data_global     = implode('|', array_column($dependency, 3));
          $depend_visible  = implode('|', array_column($dependency, 4));
        } else {
          $data_controller = (! empty($dependency[0])) ? $dependency[0] : '';
          $data_condition  = (! empty($dependency[1])) ? $dependency[1] : '';
          $data_value      = (! empty($dependency[2])) ? $dependency[2] : '';
          $data_global     = (! empty($dependency[3])) ? $dependency[3] : '';
          $depend_visible  = (! empty($dependency[4])) ? $dependency[4] : '';
        }

        $depend .= ' data-controller="' . esc_attr($data_controller) . '"';
        $depend .= ' data-condition="' . esc_attr($data_condition) . '"';
        $depend .= ' data-value="' . esc_attr($data_value) . '"';
        $depend .= (! empty($data_global)) ? ' data-depend-global="true"' : '';

        $visible = (! empty($depend_visible)) ? ' chat-help-depend-visible' : ' chat-help-depend-hidden';
      }

      // These attributes has been sanitized above.
      echo '<div class="chat-help-field chat-help-field-' . esc_attr($field_type . $is_pseudo . $class . $visible) . '"' . wp_kses_post($depend) . '>';

      if (! empty($field_type)) {
        if (! empty($field['title'])) {
          $title_help = '';
          if (! empty($field['title_help']) || ! empty($field['title_video'])) {
            $help_text       = ! empty($field['title_help']) ? $field['title_help'] : '';
            $icon_type       = ! empty($field['title_video']) ? 'video_info.svg' : 'info.svg';
            $video_help_attr = ! empty($field['title_video']) ? ' title-video-help' : '';
            $title_help      = sprintf('<span class="chat-help-help chat-help-title-help">
							<span class="chat-help-help-text' . esc_attr($video_help_attr) . '">%s</span>
							<span class="tooltip-icon">
								<img src="%s">
							</span>
						</span>', $help_text . (! empty($field['title_video']) ? $field['title_video'] : ''), self::include_plugin_url('assets/images/' . $icon_type));
          }

          echo '<div class="chat-help-title">';
          echo '<h4>' . wp_kses_post($field['title']) . $title_help . '</h4>'; // phpcs:ignore -- Attributes are escaped above.
          echo (! empty($field['subtitle'])) ? '<div class="chat-help-subtitle-text">' . wp_kses_post($field['subtitle']) . '</div>' : '';
          echo '</div>';
        }

        echo (! empty($field['title'])) ? '<div class="chat-help-fieldset">' : '';

        $value = (! isset($value) && isset($field['default'])) ? $field['default'] : $value;
        $value = (isset($field['value'])) ? $field['value'] : $value;
        $classname = 'CHAT_HELP_Field_' . $field_type;
        if (class_exists($classname)) {
          $instance = new $classname($field, $value, $unique, $where, $parent);
          $instance->render();
        } else {
          echo '<p>' . esc_html__('Field not found!', 'chat-help') . '</p>';
        }
      } else {
        echo '<p>' . esc_html__('Field not found!', 'chat-help') . '</p>';
      }

      echo (! empty($field['title'])) ? '</div>' : '';
      echo '<div class="clear"></div>';
      echo '</div>';
    }
  }
}

Chat_Help::init(__FILE__);
