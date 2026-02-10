<?php

/**
 * Views class for Shortcode generator options.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/src/Admin/Views/Shortcode
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Views;

use ThemeAtelier\ChatHelp\Admin\Framework\Classes\Chat_Help;

class Shortcode
{
    /**
     * Create Option fields for the setting options.
     *
     * @param string $prefix Option setting key prefix.
     * @return void
     */
    public static function options($prefix)
    {
        Chat_Help::createOptions($prefix, array(
            'menu_title'        => esc_html__('ChatHelp Shortcode', 'chat-help'),
            'menu_slug'         => 'chat-help-shortcode',
            'menu_type'               => 'submenu',
            'show_search'             => false,
            'show_bar_menu'           => false,
            'show_sub_menu'           => false,
            'show_reset_all'          => false,
            'show_reset_section'          => false,
            'show_save_button'          => false,
            'show_footer'              => false,
            'show_all_options'          => false,
            'framework_title'   => esc_html__('ChatHelp Shortcode', 'chat-help'),
            'admin_bar_menu_priority' => 5,
            'footer_text'             => esc_html__('Thank you for using our product', 'chat-help'),
            'theme'                   => 'light',
            'nav'                     => 'inline',
            'framework_class'         => 'chat-help-setting-admin',
            'class'                    => 'chat-help-preloader',
        ));
        //
        // Field: shortcodes
        //
        Chat_Help::createSection(
            $prefix,
            array(
                'title'  => esc_html__('SHORTCODES', 'chat-help'),
                'icon'   => 'icofont-code-alt',
                'fields' => array(
                    array(
                        'id'      => 'opt-shortcode-select',
                        'type'    => 'layout_preset',
                        'title'     => esc_html__('Select Button Style', 'chat-help'),
                        'title_help' =>
                        '<div class="chat-help-info-label">' .
                            esc_html__('Choose between Simple or Advanced button styles for the shortcode. The Advanced style supports agent details (photo, name, designation), while the Simple style is a basic WhatsApp button.', 'chat-help') .
                            '</div>' .
                            ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'button-shortcode/?ref=1') . '">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/shortcodes/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                        'options' => array(
                            '2' => array(
                                'image'           => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/button2.svg',
                                'text'            => esc_html__('Simple Button', 'chat-help'),
                                'option_demo_url' => CHAT_HELP_DEMO_URL . 'button-shortcode#simple-button',
                            ),
                            '1' => array(
                                'image'           => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/button-with-info.svg',
                                'text'            => esc_html__('Advance Button', 'chat-help'),
                                'option_demo_url' => CHAT_HELP_DEMO_URL . 'button-shortcode#btn_demo',
                                'pro_only' => true,
                            ),

                        ),
                        'default' => '2',

                    ),

                    array(
                        'id'    => 'advance_button_shortcode',
                        'type'  => 'shortcode',
                        'title' => esc_html__('Shortcode', 'chat-help'),
                        'desc'  => '<b>' . esc_html__('Available Attributes', 'chat-help') . '</b> = style="1", type_of_whatsapp="number/group", number="WhatApp number", group="WhatsApp group invite link", message="Your desired message" top_label="Button top label" main_label="Button main label" visibility="desktop/tablet/mobile", size="1", background="#118c7e", hover_background="#0b5a51", text_color="#ffffff", hover_text_color="#ffffff", padding="5px 15px 5px 6px", border_radius="50px", border="0px", border_style="solid", border_color="#118c7e", border_hover_color="#0b5a51"',
                        'dependency' => array('opt-shortcode-select', 'any', '1'),
                        'shortcode_text'    => '[chat_help style="1" number="+880123456789" message="Hi! I have a question about your service." timezone="Asia/Dhaka" top_label="John / Technical support" main_label="How can I help you?" online="I am online" offline="I am offline" sunday="00:00-23:59" monday="00:00-23:59" tuesday="00:00-23:59" wednesday="00:00-23:59" thursday="00:00-23:59" friday="00:00-23:59" saturday="00:00-23:59"]',
                    ),
                    array(
                        'id'    => 'simple_button_shortcode',
                        'type'  => 'shortcode',
                        'title' => esc_html__('Shortcode', 'chat-help'),
                        'desc'  => '<b>' . esc_html__('Available Attributes', 'chat-help') . '</b> = style="2", type_of_whatsapp="number/group", number="WhatApp number", group="WhatsApp group invite link", message="Your desired message" label="Button label" visibility="desktop/tablet/mobile", size="1", background="#118c7e", hover_background="#0b5a51", text_color="#ffffff", hover_text_color="#ffffff", padding="5px 15px 5px 6px", border_radius="50px", icon="yes/no" icon_bg="yes/no" icon_background="#ffffff", hover_icon_background="#ffffff", icon_color="#118c7e", hover_icon_color="#0b5a51", border="0px", border_style="solid", border_color="#118c7e", border_hover_color="#0b5a51"',
                        'dependency' => array('opt-shortcode-select', 'any', '2'),
                        'shortcode_text'    => '[chat_help style="2" number="+880123456789" message="Hi! I have a question about your service." label="How can I help you?" sunday="00:00-23:59" monday="00:00-23:59" tuesday="00:00-23:59" wednesday="00:00-23:59" thursday="00:00-23:59" friday="00:00-23:59" saturday="00:00-23:59"]',
                    ),
                )

            )
        );
    }
}
