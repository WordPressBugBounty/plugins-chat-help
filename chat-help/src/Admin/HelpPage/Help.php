<?php

namespace ThemeAtelier\ChatHelp\Admin\HelpPage;

if (! defined('ABSPATH')) {
    exit;
}  // if direct access.

/**
 * The help class for the Testimonial Free
 */
class Help
{

    /**
     * Single instance of the class
     *
     * @var null
     */
    protected static $_instance = null;

    /**
     * Plugins Path variable.
     *
     * @var array
     */
    protected static $plugins = array(
        'greet-bubble'              => 'greet-bubble.php',
        'domain-for-sale'           => 'domain-for-sale.php',
        'ask-faq'                   => 'ask-faq.php',
        'attentive-security'        => 'attentive-security.php',
        'better-chat-support'       => 'messenger-chat-support.php',
        'bizreview'                 => 'bizreview.php',
        'booklet-booking-system'    => 'booklet.php',
        'skype-chat'                => 'skype-chat.php',
        'chat-help'                 => 'chat-whatsapp.php',
        'chat-telegram'             => 'telegram-chat.php',
        'chat-viber'                => 'chat-viber-lite.php',
        'click-to-dial'             => 'click-to-dial.php',
        'click-to-mail'             => 'click-to-mail.php',
        'darkify'                   => 'darkify.php',
        'eventful'                  => 'eventful.php',
        'eventful-for-elementor'    => 'eventful-for-elementor.php',
        'postify'                   => 'postify.php',
    );


    /**
     * Welcome pages
     *
     * @var array
     */
    public $pages = array(
        'chat-help',
    );

    /**
     * Not show this plugin list.
     *
     * @var array
     */
    protected static $not_show_plugin_list = array('chat-help','better-chat-support',
        'bizreview',    
        'chat-help',
        'chat-viber',
        'chat-telegram',
        'click-to-dial',
        'chat-skype',
        'click-to-mail',
        'ask-faq',
        'attentive-security',
        'booklet-booking-system',
        'postify');

    /**
     * Help page construct function.
     */
    public function __construct()
    {
       
        $page   = isset($_GET['page']) ? sanitize_text_field(wp_unslash($_GET['page'])) : '';
        if ('chat-help' !== $page) {
            return;
        }

    }

    /**
     * Main Help page Instance
     *
     * @static
     * @return self Main instance
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }



    /**
     * Sprtf_plugins_info_api_help_page function.
     *
     * @return void
     */
    public function themeatelier_plugins_info_api_help_page()
    {
        $plugins_arr = get_transient('themeatelier_plugins');
        if (false === $plugins_arr) {
            $args    = (object) array(
                'author'   => 'themeatelier',
                'per_page' => '120',
                'page'     => '1',
                'fields'   => array(
                    'slug',
                    'name',
                    'version',
                    'downloaded',
                    'active_installs',
                    'last_updated',
                    'rating',
                    'num_ratings',
                    'short_description',
                    'author',
                ),
            );
            $request = array(
                'action'  => 'query_plugins',
                'timeout' => 0,
                'request' => serialize($args),
            );
            // https://codex.wordpress.org/WordPress.org_API.
            $url      = 'http://api.wordpress.org/plugins/info/1.0/';
            $response = wp_remote_post($url, array('body' => $request));


            if (! is_wp_error($response)) {

                $plugins_arr = array();
                $plugins     = unserialize($response['body']);

                if (isset($plugins->plugins) && (count($plugins->plugins) > 0)) {
                    foreach ($plugins->plugins as $pl) {
                        if (! in_array($pl->slug, self::$not_show_plugin_list, true)) {
                            $plugins_arr[] = array(
                                'slug'              => $pl->slug,
                                'name'              => $pl->name,
                                'version'           => $pl->version,
                                'downloaded'        => $pl->downloaded,
                                'active_installs'   => $pl->active_installs,
                                'last_updated'      => strtotime($pl->last_updated),
                                'rating'            => $pl->rating,
                                'num_ratings'       => $pl->num_ratings,
                                'short_description' => $pl->short_description,
                            );
                        }
                    }
                }

                set_transient('themeatelier_plugins', $plugins_arr, 24 * HOUR_IN_SECONDS);
            }
        }

        if (is_array($plugins_arr) && (count($plugins_arr) > 0)) {
            array_multisort(array_column($plugins_arr, 'active_installs'), SORT_DESC, $plugins_arr);


            foreach ($plugins_arr as $plugin) {
                $plugin_slug = $plugin['slug'];
                $image_type  = 'png';
                if (isset(self::$plugins[$plugin_slug])) {
                    $plugin_file = self::$plugins[$plugin_slug];
                } else {
                    $plugin_file = $plugin_slug . '.php';
                }

                switch ($plugin_slug) {
                    case 'postify':
                        $image_type = 'jpg';
                        break;
                    case 'chat-help':
                        $image_type = 'gif';
                        break;
                    case 'darkify':
                        $image_type = 'gif?rev=3301202';
                        break;
                }

             
                $details_link = network_admin_url('plugin-install.php?tab=plugin-information&amp;plugin=' . $plugin['slug'] . '&amp;TB_iframe=true&amp;width=600&amp;height=550');
?>
                <div class="plugin-card <?php echo esc_attr($plugin_slug); ?>" id="<?php echo esc_attr($plugin_slug); ?>">
                    <div class="plugin-card-top">
                        <div class="name column-name">
                            <h3>
                                
                                <a class="thickbox" title="<?php echo esc_attr($plugin['name']); ?>"
                                    href="<?php echo esc_url($details_link); ?>">
                                    <?php echo esc_html($plugin['name']); ?>
                                    <img src="<?php echo esc_url('https://ps.w.org/' . $plugin_slug . '/assets/icon-256x256.' . $image_type); ?>"
                                        class="plugin-icon" />
                                </a>
                            </h3>
                        </div>
                        <div class="action-links">
                            <ul class="plugin-action-buttons">
                                <li>
                                    <?php
                                    if ($this->is_plugin_installed($plugin_slug, $plugin_file)) {
                                        if ($this->is_plugin_active($plugin_slug, $plugin_file)) {
                                    ?>
                                            <button type="button" class="button button-disabled" disabled="disabled">Active</button>
                                        <?php
                                        } else {
                                        ?>
                                            <a href="<?php echo esc_url($this->activate_plugin_link($plugin_slug, $plugin_file)); ?>"
                                                class="button button-primary activate-now">
                                                <?php esc_html_e('Activate', 'chat-help'); ?>
                                            </a>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <a href="<?php echo esc_url($this->install_plugin_link($plugin_slug)); ?>"
                                            class="button install-now">
                                            <?php esc_html_e('Install Now', 'chat-help'); ?>
                                        </a>
                                    <?php } ?>
                                </li>
                                <li>
                                    <a href="<?php echo esc_url($details_link); ?>" class="thickbox open-plugin-details-modal"
                                        aria-label="<?php echo esc_html('More information about ' . $plugin['name']); ?>"
                                        title="<?php echo esc_attr($plugin['name']); ?>">
                                        <?php esc_html_e('More Details', 'chat-help'); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="desc column-description">
                            <p><?php echo esc_html(isset($plugin['short_description']) ? $plugin['short_description'] : ''); ?></p>
                            <p class="authors"> <cite>By <a href="https://themeatelier.com/">Themeatelier</a></cite></p>
                        </div>
                    </div>
                    <?php
                    echo '<div class="plugin-card-bottom">';

                    if (isset($plugin['rating'], $plugin['num_ratings'])) {
                    ?>
                        <div class="vers column-rating">
                            <?php
                            wp_star_rating(
                                array(
                                    'rating' => $plugin['rating'],
                                    'type'   => 'percent',
                                    'number' => $plugin['num_ratings'],
                                )
                            );
                            ?>
                            <span class="num-ratings">(<?php echo esc_html(number_format_i18n($plugin['num_ratings'])); ?>)</span>
                        </div>
                    <?php
                    }
                    if (isset($plugin['version'])) {
                    ?>
                        <div class="column-updated">
                            <strong><?php esc_html_e('Version:', 'chat-help'); ?></strong>
                            <span><?php echo esc_html($plugin['version']); ?></span>
                        </div>
                    <?php
                    }

                    if (isset($plugin['active_installs'])) {
                    ?>
                        <div class="column-downloaded">
                            <?php echo esc_html(number_format_i18n($plugin['active_installs'])) . esc_html__('+ Active Installations', 'chat-help'); ?>
                        </div>
                    <?php
                    }

                    if (isset($plugin['last_updated'])) {
                    ?>
                        <div class="column-compatibility">
                            <strong><?php esc_html_e('Last Updated:', 'chat-help'); ?></strong>
                            <span><?php echo esc_html(human_time_diff($plugin['last_updated'])) . ' ' . esc_html__('ago', 'chat-help'); ?></span>
                        </div>
                    <?php
                    }

                    echo '</div>';
                    ?>
                </div>
        <?php
            }
        }
    }

    /**
     * Check plugins installed function.
     *
     * @param string $plugin_slug Plugin slug.
     * @param string $plugin_file Plugin file.
     * @return boolean
     */
    public function is_plugin_installed($plugin_slug, $plugin_file)
    {
        return file_exists(WP_PLUGIN_DIR . '/' . $plugin_slug . '/' . $plugin_file);
    }

    /**
     * Check active plugin function
     *
     * @param string $plugin_slug Plugin slug.
     * @param string $plugin_file Plugin file.
     * @return boolean
     */
    public function is_plugin_active($plugin_slug, $plugin_file)
    {
        return is_plugin_active($plugin_slug . '/' . $plugin_file);
    }

    /**
     * Install plugin link.
     *
     * @param string $plugin_slug Plugin slug.
     * @return string
     */
    public function install_plugin_link($plugin_slug)
    {
        return wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=' . $plugin_slug), 'install-plugin_' . $plugin_slug);
    }

    /**
     * Active Plugin Link function
     *
     * @param string $plugin_slug Plugin slug.
     * @param string $plugin_file Plugin file.
     * @return string
     */
    public function activate_plugin_link($plugin_slug, $plugin_file)
    {
        return wp_nonce_url( admin_url( 'admin.php?page=chat-help&action=activate&plugin=' . $plugin_slug . '/' . $plugin_file . '#tab=help#recommended' ), 'activate-plugin_' . $plugin_slug . '/' . $plugin_file );
    }

   

    /**
     * The Chat Help Help Callback.
     *
     * @return void
     */
    public function help_page_callback()
    {
        add_thickbox();

        $action   = isset($_GET['action']) ? sanitize_text_field(wp_unslash($_GET['action'])) : '';
        $plugin   = isset($_GET['plugin']) ? sanitize_text_field(wp_unslash($_GET['plugin'])) : '';
        $_wpnonce = isset($_GET['_wpnonce']) ? sanitize_text_field(wp_unslash($_GET['_wpnonce'])) : '';

        if (isset($action, $plugin) && ('activate' === $action) && wp_verify_nonce($_wpnonce, 'activate-plugin_' . $plugin)) {
            activate_plugin($plugin, '', false, true);
        }

        if (isset($action, $plugin) && ('deactivate' === $action) && wp_verify_nonce($_wpnonce, 'deactivate-plugin_' . $plugin)) {
            deactivate_plugins($plugin, '', false, true);
        }

        ?>
        <div class="chat-help">
            <!-- Header section start -->
            <section class="themeatelier__help header themeatelier-container">
                <div class="themeatelier-container">
                    <div class="header_nav">
                        <div class="header_nav_left">

                            <div class="header_nav_menu">
                                <ul>
                                    <li>
                                        <a href="<?php echo esc_url(home_url('') . '/wp-admin/admin.php?page=chat-help#tab=help#get-start'); ?>" data-id="get-start-tab" class="active">
                                            <i class="icofont-play-alt-2"></i>
                                            <?php echo esc_html__('Get Started', 'chat-help') ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo esc_url(home_url('') . '/wp-admin/admin.php?page=chat-help#tab=help#recommended'); ?>" data-id="recommended-tab">
                                            <i class="icofont-thumbs-up"></i>
                                            <?php echo esc_html__('Recommended', 'chat-help') ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo esc_url(home_url('') . '/wp-admin/admin.php?page=chat-help#tab=help#lite-to-pro'); ?>" data-id="lite-to-pro-tab">
                                            <i class="icofont-badge"></i>
                                            <?php echo esc_html__('Lite Vs Pro', 'chat-help') ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo esc_url(home_url('') . '/wp-admin/admin.php?page=chat-help#tab=help#pro-plugins'); ?>" data-id="pro-plugins-tab">
                                            <i class="icofont-info-circle"></i>
                                            <?php echo esc_html__('Pro Plugins', 'chat-help') ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="header_nav_right">
                            <div class="header_nav_right_menu">
                                <a target="_blank" href="<?php echo esc_url(CHAT_HELP_DEMO_URL) ?>pricing/"><?php echo esc_html__('🚀 Upgrading To Pro!', 'chat-help') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--header section end -->

            <!-- Start Page -->
            <section class="start_page tab-content active" id="get-start-tab">
                <div class="themeatelier-container">
                    <div class="start_page_wrapper">
                        <div class="start_page_nav">
                            <div class="nav_left">
                                <h2 class="section_title"><?php echo esc_html('Welcome to Whatsapp Chat Help!', 'chat-help') ?><span class="version__badge"><?php echo esc_html(CHAT_HELP_VERSION) ?></span></h2>
                                <span class="section_subtitle">
                                    <?php echo esc_html__('Thank you for installing Whatsapp Chat Help! This playlist will help you get started with the
                                    plugin. Enjoy!', 'chat-help') ?>
                                </span>
                            </div>
                            <div class="nev_right">
                                <i class="icofont-youtube-play"></i>
                                <a target="_blank" href="https://www.youtube.com/@themeatelier">Themeatelier</a>
                            </div>
                        </div>
                        <div class="section_video">
                            <div class="video">
                                <iframe width="724" height="405" src="https://www.youtube.com/embed/RNwVAoGQssI"
                                    title="WhatsApp Chat Help - Overview" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>
                            <div class="section_video_play_list">
                                <div class="play_list_item active" data-video_id="RNwVAoGQssI">
                                    <div class="play_list_item_title">
                                        <h3>Overview</h3>
                                    </div>
                                    <div class="play_list_item_content">
                                        <div class="title">WhatsApp Chat Help - Overview</div>
                                        <span>3.19</span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <ul class="section_buttons">
                            <li>
                                <a class="chat_btn_primary"
                                    href="<?php echo esc_url(home_url('') . '/wp-admin/admin.php?page=chat-help'); ?>"><?php echo esc_html__('Plugin Settings', 'chat-help') ?></a>
                            </li>
                            <li>
                                <a target="_blank" class="chat_btn_secondary"
                                    href="<?php echo esc_url(CHAT_HELP_DEMO_URL) ?>"><?php echo esc_html__('Live Demo', 'chat-help') ?></a>
                            </li>
                            <li>
                                <a target="_blank" class="chat_btn_secondary arrow-btn"
                                    href="<?php echo esc_url(CHAT_HELP_DEMO_URL) ?>pricing/"><?php echo esc_html__('Upgrade To Pro', 'chat-help') ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="section_quick_help">
                        <div class="quick_help_wrapper">
                            <a target="_blank" href="https://wpchathelp.com/docs/" class="quick_help_item">
                                <div class="quick_help_item_icon"><i class="icofont-file-alt"></i></div>
                                <div class="quick_help_item_content">
                                    <h4 class="quick_help_item_title">
                                        <?php echo esc_html__('Documentation', 'chat-help') ?>
                                    </h4>
                                    <div class="content"><?php echo esc_html__('Explore Whatsapp Chat Help plugin capabilities in our enriched documentation.', 'chat-help') ?></div>
                                </div>
                            </a>
                            <a target="_blank" href="https://wordpress.org/support/plugin/chat-help/" class="quick_help_item">
                                <div class="quick_help_item_icon"><i class="icofont-support"></i></div>
                                <div class="quick_help_item_content">
                                    <h4 class="quick_help_item_title">
                                        <?php echo esc_html__('Technical Support', 'chat-help') ?>
                                    </h4>
                                    <div class="content"><?php echo esc_html__('For personalized assistance, reach out to our skilled support team for prompt help.', 'chat-help') ?></div>
                                </div>
                            </a>
                            <a target="_blank" href="https://www.themeatelier.net/contact/" class="quick_help_item">
                                <div class="quick_help_item_icon"><i class="icofont-users"></i></div>
                                <div class="quick_help_item_content">
                                    <h4 class="quick_help_item_title">
                                        <?php echo esc_html__('Hire Us!', 'chat-help') ?>
                                    </h4>
                                    <div class="content"><?php echo esc_html__('We are available for freelance work for any WordPress, React, NextJS projects. Click to contact us.', 'chat-help') ?></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Recommended Page -->
            <section id="recommended-tab" class="recommended_page tab-content">
                <div class="themeatelier-container">
                    <h2 class="help_page_title">Enhance your Website with our Free Robust Plugins</h2>
                    <div class="themeatelier-wp-list-table plugin-install-php">
                        <div class="recommended_plugins" id="the-list">
                            <?php
                            $this->themeatelier_plugins_info_api_help_page();
                            ?>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Lite To Pro Page -->
            <section class="themeatelier__help lite_vs_pro_page tab-content" id="lite-to-pro-tab">
                <div class="themeatelier-container">
                        <h2 class="help_page_title">Lite Vs Pro Comparison</h2>
                        <div class="themeatelier-features">
                            <ul>
                                <li class="themeatelier-header">
                                    <span class="themeatelier-title"><?php echo esc_html__('FEATURES', 'chat-help'); ?></span>
                                    <span class="themeatelier-free"><?php echo esc_html__('Lite', 'chat-help'); ?></span>
                                    <span class="themeatelier-pro">🚀<?php echo esc_html__('PRO', 'chat-help'); ?></span>
                                </li>
                                <li class="themeatelier-body">
                                    <span class="themeatelier-title"><?php echo esc_html__('All Free Version Features', 'chat-help'); ?></span>
                                    <span class="themeatelier-free themeatelier-check-icon"></span>
                                    <span class="themeatelier-pro themeatelier-check-icon"></span>
                                </li>
                                <li class="themeatelier-body">
                                    <span class="themeatelier-title">
                                        <?php echo esc_html__('Amazing Floating Chat Layouts.', 'chat-help'); ?>
                                        <i class="themeatelier-hot"><?php echo esc_html__('Hot', 'chat-help'); ?></i>
                                    </span>
                                    <span class="themeatelier-free"><b>3</b></span>
                                    <span class="themeatelier-pro"><b>5</b></span>
                                </li>
                                <li class="themeatelier-body">
                                    <span class="themeatelier-title">
                                        <?php echo esc_html__('Multi-agents layout.', 'chat-help'); ?>
                                        <i class="themeatelier-hot"><?php echo esc_html__('Hot', 'chat-help'); ?></i>
                                    </span>
                                    <span class="themeatelier-free"><span class="themeatelier-free themeatelier-close-icon"></span></span>
                                    <span class="themeatelier-pro"><span class="themeatelier-free themeatelier-check-icon"></span></span>
                                </li>
                                <li class="themeatelier-body">
                                    <span class="themeatelier-title">
                                        <?php echo esc_html__('Advanced button layout.', 'chat-help'); ?>
                                        <i class="themeatelier-new"><?php echo esc_html__('New', 'chat-help'); ?></i>
                                    </span>
                                    <span class="themeatelier-free"><span class="themeatelier-free themeatelier-close-icon"></span></span>
                                    <span class="themeatelier-pro"><span class="themeatelier-free themeatelier-check-icon"></span></span>
                                </li>
                                <li class="themeatelier-body">
                                    <span class="themeatelier-title"><?php echo esc_html__('Single form layout\'s forms fields', 'chat-help'); ?><i class="themeatelier-new">New</i><i class="themeatelier-hot"><?php echo esc_html__('Hot', 'chat-help'); ?></i></span>
                                    <span class="themeatelier-free"><b>2</b></span>
                                    <span class="themeatelier-pro"><b>Unlimited</b></span>
                                </li>

                                <li class="themeatelier-body">
                                    <span class="themeatelier-title">
                                        <?php echo esc_html__('List All Leads Inside Leads Menu', 'chat-help'); ?>
                                    </span>
                                    <span class="themeatelier-free themeatelier-check-icon"></span>
                                    <span class="themeatelier-pro themeatelier-check-icon"></span>
                                </li>
                                <li class="themeatelier-body">
                                    <span class="themeatelier-title">
                                        <?php echo esc_html__('Export Leads As CSV', 'chat-help'); ?>
                                    </span>
                                    <span class="themeatelier-free themeatelier-close-icon"></span>
                                    <span class="themeatelier-pro themeatelier-check-icon"></span>
                                </li>
                                <li class="themeatelier-body">
                                    <span class="themeatelier-title">
                                        <?php echo esc_html__('Advanced Filtering For Leads', 'chat-help'); ?>
                                    </span>
                                    <span class="themeatelier-free themeatelier-check-icon"></span>
                                    <span class="themeatelier-pro themeatelier-check-icon"></span>
                                </li>
                                <li class="themeatelier-body">
                                    <span class="themeatelier-title">
                                        <?php echo esc_html__('Transform it to your current timezone', 'chat-help'); ?>
                                       
                                    </span>
                                    <span class="themeatelier-free themeatelier-check-icon"></span>
                                    <span class="themeatelier-pro themeatelier-check-icon"></span>
                                </li>

                                <li class="themeatelier-body">
                                    <span class="themeatelier-title">
                                        <?php echo esc_html__('Time based availablity for agents', 'chat-help'); ?>
                                       
                                    </span>
                                    <span class="themeatelier-free themeatelier-check-icon"></span>
                                    <span class="themeatelier-free themeatelier-check-icon"></span>
                                </li>
                                <li class="themeatelier-body">
                                    <span class="themeatelier-title">
                                        <?php echo esc_html__('GDPR Compliance', 'chat-help'); ?>
                                        
                                    </span>
                                    <span class="themeatelier-free themeatelier-check-icon"></span>
                                    <span class="themeatelier-free themeatelier-check-icon"></span>
                                </li>
                                <li class="themeatelier-body">
                                    <span class="themeatelier-title">
                                        <?php echo esc_html__('Footer Content Change Option', 'chat-help'); ?>
                                    </span>
                                    <span class="themeatelier-free themeatelier-close-icon"></span>
                                    <span class="themeatelier-pro themeatelier-check-icon"></span>
                                </li>

                                <li class="themeatelier-body">
                                    <span class="themeatelier-title">
                                        <?php echo esc_html__('Icons For Send Message Button', 'chat-help'); ?>
                                       
                                    </span>
                                    <span class="themeatelier-free"><b>6</b></span>
                                    <span class="themeatelier-pro"><b>2000+</b></span>
                                </li>
                                <li class="themeatelier-body">
                                    <span class="themeatelier-title">
                                        <?php echo esc_html__('Icons For Circle Button', 'chat-help'); ?>
                                       
                                    </span>
                                    <span class="themeatelier-free"><b>6</b></span>
                                    <span class="themeatelier-pro"><b>2000+</b></span>
                                </li>
                                <li class="themeatelier-body">
                                    <span class="themeatelier-title">
                                        <?php echo esc_html__('Transition Effect for Circle Icon', 'chat-help'); ?>
                                    </span>
                                    <span class="themeatelier-free"><b>1</b></span>
                                    <span class="themeatelier-pro"><b>4</b></span>
                                </li>

                                <li class="themeatelier-body">
                                    <span class="themeatelier-title">
                                        <?php echo esc_html__('Visibility by option(s)', 'chat-help'); ?>
                                    </span>
                                    <span class="themeatelier-free"><b>2</b></span>
                                    <span class="themeatelier-pro"><b>8</b></span>
                                </li>
                                

                                <li class="themeatelier-body">
                                    <span class="themeatelier-title">
                                        <?php echo esc_html__('Icons For Circle Button Close', 'chat-help'); ?>
                                       
                                    </span>
                                    <span class="themeatelier-free"><b>5</b></span>
                                    <span class="themeatelier-pro"><b>2000+</b></span>
                                </li>
                                <li class="themeatelier-body">
                                    <span class="themeatelier-title">
                                        <?php echo esc_html__('Send Button Color Option', 'chat-help'); ?>
                                    </span>
                                    <span class="themeatelier-free"><span class="themeatelier-free themeatelier-close-icon"></span></span>
                                    <span class="themeatelier-pro"><span class="themeatelier-free themeatelier-check-icon"></span></span>
                                </li>

                                <li class="themeatelier-body">
                                    <span class="themeatelier-title">
                                        <?php echo esc_html__('Webhooks Intregation', 'chat-help'); ?>
                                    </span>
                                    <span class="themeatelier-free"><span class="themeatelier-free themeatelier-close-icon"></span></span>
                                    <span class="themeatelier-pro"><span class="themeatelier-free themeatelier-check-icon"></span></span>
                                </li>

                                <li class="themeatelier-body">
                                    <span class="themeatelier-title">
                                        <?php echo esc_html__('Dark and Night Layout Mode', 'chat-help'); ?>
                                    </span>
                                    <span class="themeatelier-free"><span class="themeatelier-free themeatelier-close-icon"></span></span>
                                    <span class="themeatelier-pro"><span class="themeatelier-free themeatelier-check-icon"></span></span>
                                </li>


                                <li class="themeatelier-body">
                                    <span class="themeatelier-title">
                                        <?php echo esc_html__('Right and Middle for Bubble', 'chat-help'); ?>
                                    </span>
                                    <span class="themeatelier-free"><span class="themeatelier-free themeatelier-close-icon"></span></span>
                                    <span class="themeatelier-pro"><span class="themeatelier-free themeatelier-check-icon"></span></span>
                                </li>

                                

                                <li class="themeatelier-body">
                                    <span class="themeatelier-title"><?php echo esc_html__('Shortcode Buttons', 'chat-help'); ?></span>
                                    <span class="themeatelier-free themeatelier-check-icon"></span>
                                    <span class="themeatelier-pro themeatelier-check-icon"></span>
                                </li>

                                <li class="themeatelier-body">
                                    <span class="themeatelier-title"><?php echo esc_html__('WooCommerce Buttons', 'chat-help'); ?></span>
                                    <span class="themeatelier-free themeatelier-check-icon"></span>
                                    <span class="themeatelier-pro themeatelier-check-icon"></span>
                                </li>

                                <li class="themeatelier-body">
                                    <span class="themeatelier-title"><?php echo esc_html__('Gutenberg Button Blocks', 'chat-help'); ?></span>
                                    <span class="themeatelier-free themeatelier-check-icon"></span>
                                    <span class="themeatelier-pro themeatelier-check-icon"></span>
                                </li>
                               
                            </ul>
                        </div>

                        <div class="themeatelier-upgrade-to-pro">
                            <h2 class="themeatelier-section-title"><?php echo esc_html__('Upgrade To PRO & Enjoy Advanced Features!', 'chat-help'); ?></h2>
                            <span class="themeatelier-section-subtitle">
                                <?php echo sprintf(esc_html__('Already, %s people are using Whatsapp Chat Help on their websites to create beautiful showcases, why won’t you!', 'chat-help'), '<b>50000+</b>'); ?>
                            </span>
                            <div class="themeatelier-upgrade-to-pro-btn">
                                <div class="themeatelier-action-btn">
                                    <a target="_blank" href="<?php echo esc_url(CHAT_HELP_DEMO_URL) ?>pricing/" class="chat_btn_primary">
                                        <?php echo esc_html__('Upgrade to Pro Now!', 'chat-help'); ?>
                                    </a>
                                    <span class="themeatelier-small-paragraph">
                                        <?php echo sprintf(esc_html__('14-Day No-Questions-Asked %s', 'chat-help'), '<a target="_blank" href="https://themeatelier.net/refund-policy/">' . esc_html__('Refund Policy', 'chat-help') . '</a>'); ?>
                                    </span>
                                </div>
                                <a target="_blank" class="chat_btn_secondary" href="<?php echo esc_url(CHAT_HELP_DEMO_URL) ?>features/"><?php echo esc_html__('See All Features', 'chat-help'); ?></a>
                                <a target="_blank" class="chat_btn_secondary" href="<?php echo esc_url(CHAT_HELP_DEMO_URL) ?>."><?php echo esc_html__('Pro Live Demo', 'chat-help'); ?></a>
                            </div>
                        </div>
                    

                    <div class="chat_testimonial">
                        <div class="chat_testimonial_title_section">
                            <span class="chat_testimonial-subtitle"><?php echo esc_html__('NO NEED TO TAKE OUR WORD FOR IT', 'chat-help'); ?></span>
                            <h2 class="themeatelier-section-title"><?php echo esc_html__('Our Users Love Whatsapp Chat Help Pro!', 'chat-help'); ?></h2>
                        </div>
                        <div class="chat_testimonial_wrap">
                            <div class="chat_testimonial_area">
                                <div class="chat_testimonial_content">
                                    <p><?php echo esc_html__('The plugin is really easy to use for its good admin UI also the support is very responsive. I got my answer with a solution within a few hours.', 'chat-help'); ?></p>
                                </div>
                                <div class="chat_testimonial-info">
                                    <div class="themeatelier-img">
                                        <img src="<?php echo esc_url(CHAT_HELP_DIR_URL . 'src/Admin/HelpPage/assets/images/user_image.jpg'); ?>"
                                            alt="<?php echo esc_attr__('Crowandravener', 'chat-help'); ?>">
                                    </div>
                                    <div class="themeatelier-info">
                                        <h3><?php echo esc_html__('Crowandravener', 'chat-help'); ?></h3>
                                        <div class="themeatelier-star">
                                            <i>★★★★★</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="chat_testimonial_area">
                                <div class="chat_testimonial_content">
                                    <p><?php echo esc_html__('This plugin has so many essential features what exactly filled my needs! Amazing!', 'chat-help'); ?></p>
                                </div>
                                <div class="chat_testimonial-info">
                                    <div class="themeatelier-img">
                                        <img src="<?php echo esc_url(CHAT_HELP_DIR_URL . 'src/Admin/HelpPage/assets/images/user_image.jpg'); ?>"
                                            alt="<?php echo esc_attr__('PROJECTS4', 'chat-help'); ?>">
                                    </div>
                                    <div class="themeatelier-info">
                                        <h3><?php echo esc_html__('PROJECTS4', 'chat-help'); ?></h3>
                                        <div class="themeatelier-star">
                                            <i>★★★★★</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="chat_testimonial_area">
                                <div class="chat_testimonial_content">
                                    <p><?php echo esc_html__('Support is very fast and friedly', 'chat-help'); ?></p>
                                </div>
                                <div class="chat_testimonial-info">
                                    <div class="themeatelier-img">
                                        <img src="<?php echo esc_url(CHAT_HELP_DIR_URL . 'src/Admin/HelpPage/assets/images/user_image.jpg'); ?>"
                                            alt="<?php echo esc_attr__('User Asiegle', 'chat-help'); ?>">
                                    </div>
                                    <div class="themeatelier-info">
                                        <h3><?php echo esc_html__('Asiegle', 'chat-help'); ?></h3>
                                        <div class="themeatelier-star">
                                            <i>★★★★★</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <!-- About Page -->
            <section id="pro-plugins-tab" class="themeatelier__help about-page tab-content">
            <div class="themeatelier-container">
                    <div class="themeatelier-our-plugin-list">
                        <h2 class="help_page_title">Upgrade your Website with our High-quality Plugins!</h2>
                        <div class="themeatelier-our-plugin-list-wrap">
                            
                            <a target="_blank" class="themeatelier-our-plugin-list-box" href="https://themeatelier.net/downloads/whatsapp-chat-help">
                                <div class="box_btn">
                                    View Details 
                                    <i class="icofont-long-arrow-right"></i>
                                </div>
                                <img src="<?php echo esc_url(CHAT_HELP_DIR_URL . 'src/Admin/HelpPage/assets/images/chat-help.png') ?>" alt="logo">
                                <h4>WhatsApp Chat Help - Chat Support Plugin For WordPress</h4>
                                <p>Whatsapp chat support is a WordPress plugin that allows website owners to easily add a WhatsApp chat button to their website.</p>
                            </a>

                            <a target="_blank" class="themeatelier-our-plugin-list-box" href="https://themeatelier.net/downloads/darkify/">
                                <div class="box_btn">
                                View Details 
                                    <i class="icofont-long-arrow-right"></i>
                                </div>
                                <img src="<?php echo esc_url(CHAT_HELP_DIR_URL . 'src/Admin/HelpPage/assets/images/darkify.gif') ?>" alt="logo">
                                <h4>Darkify - WordPress Dark Mode Plugin</h4>
                                <p>Darkify – is an extremely advanced dark mode plugin for any WordPress website. The plugin has the option to enable a dark mode switcher for the front end and also WordPress admin.</p>
                            </a>
                            <a target="_blank" class="themeatelier-our-plugin-list-box" href="https://themeatelier.net/downloads/eventful/">
                                <div class="box_btn">
                                View Details 
                                    <i class="icofont-long-arrow-right"></i>
                                </div>
                                <img src="<?php echo esc_url(CHAT_HELP_DIR_URL . 'src/Admin/HelpPage/assets/images/eventful.png') ?>" alt="logo">
                                <h4>Eventful - Events Showcase for The "The Events Calendar"</h4>
                                <p>With "Eventful," you can effortlessly create intelligent layouts for "The Events Calendar" plugin, effectively addressing and resolving compatibility issues that may arise.</p>
                            </a>

                            <a target="_blank" class="themeatelier-our-plugin-list-box" href="https://themeatelier.net/downloads/greet-bubble/">
                                <div class="box_btn">
                                View Details 
                                    <i class="icofont-long-arrow-right"></i>
                                </div>
                                <img src="<?php echo esc_url(CHAT_HELP_DIR_URL . 'src/Admin/HelpPage/assets/images/greet-logo.png') ?>" alt="logo">
                                <h4>Greet Bubble - Video Bubble Plugin for WordPress</h4>
                                <p>Placing a video on websites can increase the sales of your services or products in a significant way. Greet is a professional video bubble plugin for showing a welcome video on your websites in a great and fun way.</p>
                            </a>
                            <a target="_blank" class="themeatelier-our-plugin-list-box" href="https://themeatelier.net/downloads/eventful-for-elementor/">
                                <div class="box_btn">
                                View Details 
                                    <i class="icofont-long-arrow-right"></i>
                                </div>
                                <img src="<?php echo esc_url(CHAT_HELP_DIR_URL . 'src/Admin/HelpPage/assets/images/eventful-for-elementor.png') ?>" alt="logo">
                                <h4>Eventful for Elementor - Events Showcase for The "The Events Calendar"</h4>
                                <p>Easily display events from The Events Calendar plugin with Elementor widgets, offering seamless customization and powerful layout options.</p>
                            </a>
                            
                            <a target="_blank" class="themeatelier-our-plugin-list-box" href="https://themeatelier.net/downloads/domain-for-sale/">
                                <div class="box_btn">
                                View Details 
                                    <i class="icofont-long-arrow-right"></i>
                                </div>
                                <img src="<?php echo esc_url(CHAT_HELP_DIR_URL . 'src/Admin/HelpPage/assets/images/thumbnail-2.png') ?>" alt="logo">
                                <h4>WordPress Domain For Sale Plugin</h4>
                                <p>The ultimate WordPress plugin for domain sales, appraisals, auctions, and marketplace management.</p>
                            </a>
                           
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer Section -->
            <section class="themeatelier_footer">
                <div class="themeatelier_footer_top">
                    <p>
                        <span>Made With <i class="icofont-heart-alt"></i></span>
                        By the Team <a target="_blank" href="https://themeatelier.net/">ThemeAtelier</a>
                    </p>
                    <p>Get connected with</p>
                    <ul>
                        <li>
                            <a target="_blank" href="https://www.facebook.com/ThemeAtelier/"><i
                                    class="icofont-facebook"></i></a>
                        </li>
                        <li>
                            <a target="_blank" href="https://x.com/intent/follow?screen_name=themeatelier"><i
                                    class="icofont-x"></i></a>
                        </li>
                        <li>
                            <a target="_blank" href="https://profiles.wordpress.org/themeatelier/#content-plugins"><i
                                    class="icofont-brand-wordpress"></i></a>
                        </li>
                        <li>
                            <a target="_blank" href="https://www.youtube.com/@themeatelier"><i
                                    class="icofont-youtube-play"></i></a>
                        </li>
                    </ul>
                </div>
            </section>
        </div>
<?php
    }
}
