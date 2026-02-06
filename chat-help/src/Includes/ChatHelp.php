<?php

/**
 * The file of the ChatHelp class.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package ChatHelp
 */

namespace ThemeAtelier\ChatHelp\Includes;

use ThemeAtelier\ChatHelp\Admin\ReviewNotice\ReviewNotice;
use ThemeAtelier\ChatHelp\Includes\Loader;
use ThemeAtelier\ChatHelp\Frontend\Helpers\Helpers;
use ThemeAtelier\ChatHelp\Admin\Admin;
use ThemeAtelier\ChatHelp\Frontend\Frontend;
use ThemeAtelier\ChatHelp\Frontend\Shortcode\CustomShortcode;

// don't call the file directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * The main class of the plugin.
 *
 * Handle all the class and methods of the plugin.
 *
 * @author     ThemeAtelier <themeatelierbd@gmail.com>
 */
class ChatHelp
{
    /**
     * Plugin version
     *
     * @since    1.0.0
     * @access   protected
     * @var string
     */
    protected $version;

    /**
     * Plugin slug
     *
     * @since    1.0.0
     * @access   protected
     * @var string
     */
    protected $plugin_slug;

    /**
     * Main Loader.
     *
     * The loader that's responsible for maintaining and registering all hooks that empowers
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var object
     */
    protected $loader;
    /**
     * Constructor for the ChatHelp class.
     *
     * Sets up all the appropriate hooks and actions within the plugin.
     */
    public function __construct()
    {
        $this->version     = CHAT_HELP_VERSION;
        $this->plugin_slug = 'chat-help';
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        add_action('plugins_loaded', array($this, 'chat_help_load_textdomain'));
        add_action('plugin_loaded', array($this, 'init_plugin'));
        add_action('activated_plugin', [$this, 'chat_help_redirect_to']);

        add_action('elementor/widgets/register', array($this, 'register_ctw_widget'));

        new ReviewNotice();
    }

    public function chat_help_redirect_to($plugin)
    {
        if (CHAT_HELP_BASENAME === $plugin) {
            $redirect_url = esc_url(admin_url('admin.php?page=chat-help#tab=help#get-start'));
            exit(wp_kses_post(wp_safe_redirect($redirect_url)));
        }
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The slug of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_slug()
    {
        return $this->plugin_slug;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

    // load text domain from plugin folder
    function chat_help_load_textdomain()
    {
        load_plugin_textdomain('chat-help', false, CHAT_HELP_DIRNAME . "/languages");
    }

    function register_ctw_widget($widgets_manager)
    {
        require_once CHAT_HELP_DIR_PATH . 'src/Frontend/elementor-widgets/elementor-widget.php';
        $widgets_manager->register(new \Elementor_Ctw_Buttons());
    }

    /**
     * Load the plugin after all plugins are loaded.
     *
     * @return void
     */
    public function init_plugin()
    {
        do_action('CHAT_HELP_loaded');
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Loader. Orchestrates the hooks of the plugin.
     * - Teamproi18n. Defines internationalization functionality.
     * - Admin. Defines all hooks for the admin area.
     * - Frontend. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        $this->loader = new Loader();
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {
        $plugin_public = new Frontend($this->get_plugin_slug(), $this->get_version());
        $plugin_helpers = new Helpers($this->get_plugin_slug(), $this->get_version());
        $button_shortcode = new CustomShortcode();
        $this->loader->add_action('wp_loaded', $plugin_helpers, 'register_all_scripts');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        $this->loader->add_shortcode('ctw', $button_shortcode, 'ctw_custom_buttons_shortcode');
        $this->loader->add_shortcode('chat_help', $button_shortcode, 'ctw_custom_buttons_shortcode');
    }

    /**
     * Register all of the hooks related to the admin dashboard functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Admin($this->get_plugin_slug(), $this->get_version());
        $plugin_helpers = new Helpers($this->get_plugin_slug(), $this->get_version());
        $this->loader->add_action('wp_loaded', $plugin_helpers, 'register_all_scripts');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
    }
}
