<?php

/**
 * Views class for Shortcode generator options.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/src/Admin/Views/Popup
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Views;

use ThemeAtelier\ChatHelp\Admin\Framework\Classes\Chat_Help;

class General
{

    /**
     * Create Option fields for the setting options.
     *
     * @param string $prefix Option setting key prefix.
     * @return void
     */
    public static function options($prefix, $timezones)
    {
        Chat_Help::createSection(
            $prefix,
            array(
                'title' => esc_html__('FLOATING CHAT', 'chat-help'),
                'icon' => 'icofont-brand-whatsapp',
                'fields' => array(
                    array(
                        'id' => 'chat_layout',
                        'type' => 'layout_preset',
                        'title' => esc_html__('Floating Chat Layout', 'chat-help'),
                        'class'   => 'chat-help-layout-preset',
                        'options' => array(
                            'off' => array(
                                'image'           => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/off.svg',
                                'text'            => esc_html__('No Floating Chat', 'chat-help'),
                                'option_demo_url' => '',
                            ),
                            'form' => array(
                                'image'           => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/single_form.svg',
                                'text'            => esc_html__('Single Form', 'chat-help'),
                                'option_demo_url' => 'https://chathelp.themeatelier.net/single-form',
                                'class'           => ' wrapper_class_form',
                            ),
                            'agent' => array(
                                'image'           => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/single_agent.svg',
                                'text'            => esc_html__('Single Agent', 'chat-help'),
                                'option_demo_url' => 'https://chathelp.themeatelier.net/single-agent',

                            ),
                            'button' => array(
                                'image'           => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/single_button.svg',
                                'text'            => esc_html__('Simple Button', 'chat-help'),
                                'option_demo_url' => 'https://chathelp.themeatelier.net/simple-button',

                            ),
                            'advance_button' => array(
                                'image'           => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/advanced_button.svg',
                                'text'            => esc_html__('Advance Button', 'chat-help'),
                                'option_demo_url' => 'https://chathelp.themeatelier.net/advance-button',
                                'pro_only'        => true,

                            ),
                            'multi' => array(
                                'image'           => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/multi_agent.svg',
                                'text'            => esc_html__('Multi Agents', 'chat-help'),
                                'option_demo_url' => 'https://chathelp.themeatelier.net/multi-agents',
                                'pro_only'        => true,

                            ),
                        ),
                        'default' => 'off',
                    ),
                    array(
                        'type' => 'subheading',
                        'style'   => 'success',
                        'content' => esc_html__('With \'No Floating Chat\' option, you won\'t be able to use the floating chat feature. However, you can still access and enjoy other functionalities such as the WooCommerce button, shortcodes, and button blocks provided by the plugin.', 'chat-help'),
                        'dependency' => array('chat_layout', '==', 'off'),
                    ),

                    array(
                        'type' => 'section_tab',
                        'class' => 'chathelp-mt-0',
                        'dependency' => array('chat_layout', '!=', 'off', 'any'),
                        'tabs' => array(
                            array(
                                'title' => esc_html__('General', 'chat-help'),
                                'icon'  => 'icofont-gears',
                                'fields' => array(

                                    array(
                                        'id' => 'type_of_whatsapp',
                                        'type' => 'radio',
                                        'class' => 'chat_help_type_of_whatsapp',
                                        'title' => esc_html__('Type of Whatsapp', 'chat-help'),
                                        'title_help' => '<div class="chat-help-info-label">' . esc_html__('Select "Number" to receive direct messages or "Group" to let people join your WhatsApp group.', 'chat-help') . '</div>',
                                        'inline' => true,
                                        'options'    => array(
                                            'number' => esc_html__('Number', 'chat-help'),
                                            'group' => esc_html__('Group', 'chat-help'),
                                        ),
                                        'default' => 'number',
                                        'dependency' =>  array(
                                            array('chat_layout', '!=', 'multi', 'any'),
                                            array('chat_layout',   '!=', 'form', 'visible'),
                                        ),
                                    ),
                                    // adding contact number
                                    array(
                                        'id' => 'opt-number',
                                        'class' => 'chat_help_number',
                                        'type' => 'text',
                                        'title' => esc_html__('WhatsApp Number', 'chat-help'),
                                        'title_help' => '<div class="chat-help-info-label">' . esc_html__('Add your WhatsApp number including country code. eg: +880123456189', 'chat-help') . '</div> <a class="tooltip_btn_primary" target="_blank" href="https://faq.whatsapp.com/640432094208718/?helpref=uf_share">Detailed explanation</a>',
                                        'desc' => 'WhatsApp number in international format.', 'chat-help',
                                        // 'title_video' => '<div class="chat-help-img-tag">
                                        // <video autoplay loop muted playsinline>
                                        // <source src="http://chat-whatsapp.local/wp-content/uploads/2025/05/os-aware-darkmode.webm" type="video/webm">
                                        //     </video>
                                        // </div><div class="chat-help-info-label">Dark Mode toggling based on OS setting</div>',
                                        'dependency' =>  array(
                                            array('chat_layout', '!=', 'multi', 'any'),
                                            array('type_of_whatsapp',   '!=', 'group', 'visible'),
                                        ),
                                    ),

                                    array(
                                        'id' => 'opt-group',
                                        'type' => 'text',
                                        'title' => esc_html__('WhatsApp Group', 'chat-help'),
                                        'class' => 'chat_help_group',
                                        'title_help' => '<div class="chat-help-info-label">' . esc_html__('Invite your visitors to join into your whatapp group.', 'chat-help') . '</div> <a class="tooltip_btn_primary" target="_blank" href="https://faq.whatsapp.com/3242937609289432?helpref=search&cms_platform=web">Detailed explanation</a>',
                                        'desc' => 'WhatsApp group link.', 'chat-help',
                                        'dependency' =>  array(
                                            array('chat_layout',   '!=', 'form', 'visible'),
                                            array('type_of_whatsapp',   '==', 'group', 'visible'),
                                        ),
                                    ),


                                    // changing timezone
                                    array(
                                        'id' => 'select-timezone',
                                        'type' => 'select',
                                        'title' => esc_html__('Timezone', 'chat-help'),
                                        'title_help' => '<div class="chat-help-info-label">' . esc_html__('When using the date and time from the user browser you can transform it to your current timezone (in case your user is in a different timezone)', 'chat-help') . '</div>',
                                        'chosen' => true,
                                        'placeholder' => esc_html__('Select timezone', 'chat-help'),
                                        'dependency' => array('chat_layout', '!=', 'multi', 'any'),
                                        'options' => $timezones,
                                    ),
                                    // Add availability
                                    array(
                                        'id' => 'opt-availablity',
                                        'type' => 'tabbed',
                                        'title' => esc_html__('Availablity', 'chat-help'),
                                        'title_help' => '<div class="chat-help-info-label">' . esc_html__('24-hour Time without PM:AM" eg: From 00:00 to 23:59. If you are offline for any specefic full day use 00:00 and 00:00 in From and To value.', 'chat-help') . '</div>',
                                        'dependency' => array('chat_layout', '!=', 'multi', 'any'),
                                        // sunday
                                        'tabs' => array(
                                            array(
                                                'title' => esc_html__('Sunday', 'chat-help'),
                                                'fields' => array(
                                                    array(
                                                        'id' => 'availablity-sunday',
                                                        'type' => 'datetime',
                                                        'from_to' => true,
                                                        'settings' => array(
                                                            'noCalendar' => true,
                                                            'enableTime' => true,
                                                            'dateFormat' => 'H:i',
                                                            'time_24hr' => true,
                                                        ),
                                                    ),
                                                ),
                                            ),
                                            // monday
                                            array(
                                                'title' => esc_html__('Monday', 'chat-help'),
                                                'fields' => array(
                                                    array(
                                                        'id' => 'availablity-monday',
                                                        'type' => 'datetime',
                                                        'from_to' => true,
                                                        'settings' => array(
                                                            'noCalendar' => true,
                                                            'enableTime' => true,
                                                            'dateFormat' => 'H:i',
                                                            'time_24hr' => true,
                                                        ),
                                                    ),
                                                ),
                                            ),
                                            // tuesday
                                            array(
                                                'title' => esc_html__('Tuesday', 'chat-help'),
                                                'fields' => array(
                                                    array(
                                                        'id' => 'availablity-tuesday',
                                                        'type' => 'datetime',
                                                        'from_to' => true,
                                                        'settings' => array(
                                                            'noCalendar' => true,
                                                            'enableTime' => true,
                                                            'dateFormat' => 'H:i',
                                                            'time_24hr' => true,
                                                        ),
                                                    ),
                                                ),
                                            ),
                                            // wednesday
                                            array(
                                                'title' => esc_html__('Wednesday', 'chat-help'),
                                                'fields' => array(
                                                    array(
                                                        'id' => 'availablity-wednesday',
                                                        'type' => 'datetime',
                                                        'from_to' => true,
                                                        'settings' => array(
                                                            'noCalendar' => true,
                                                            'enableTime' => true,
                                                            'dateFormat' => 'H:i',
                                                            'time_24hr' => true,
                                                        ),
                                                    ),
                                                ),
                                            ),

                                            // thursday
                                            array(
                                                'title' => esc_html__('Thursday', 'chat-help'),
                                                'fields' => array(
                                                    array(
                                                        'id' => 'availablity-thursday',
                                                        'type' => 'datetime',
                                                        'from_to' => true,
                                                        'settings' => array(
                                                            'noCalendar' => true,
                                                            'enableTime' => true,
                                                            'dateFormat' => 'H:i',
                                                            'time_24hr' => true,
                                                        ),
                                                    ),
                                                ),
                                            ),

                                            // friday
                                            array(
                                                'title' => esc_html__('Friday', 'chat-help'),
                                                'fields' => array(
                                                    array(
                                                        'id' => 'availablity-friday',
                                                        'type' => 'datetime',
                                                        'from_to' => true,
                                                        'settings' => array(
                                                            'noCalendar' => true,
                                                            'enableTime' => true,
                                                            'dateFormat' => 'H:i',
                                                            'time_24hr' => true,
                                                        ),
                                                    ),
                                                ),
                                            ),

                                            // thursday
                                            array(
                                                'title' => esc_html__('Saturday', 'chat-help'),
                                                'fields' => array(
                                                    array(
                                                        'id' => 'availablity-saturday',
                                                        'type' => 'datetime',
                                                        'from_to' => true,
                                                        'settings' => array(
                                                            'noCalendar' => true,
                                                            'enableTime' => true,
                                                            'dateFormat' => 'H:i',
                                                            'time_24hr' => true,
                                                        ),
                                                    ),
                                                ),
                                            ),

                                        ),
                                    ),

                                    // Agent photo type
                                    array(
                                        'id' => 'agent_photo_type',
                                        'type' => 'button_set',
                                        'title' => esc_html__('Agent Photo Type', 'chat-help'),
                                        'title_help' => '<div class="chat-help-info-label">' . esc_html__('Select agent photo type.', 'chat-help') . '</div>',
                                        'options' => array(
                                            'default'   => array(
                                                'text' => esc_html__('Default', 'chat-help'),
                                            ),
                                            'custom' => array(
                                                'text' => esc_html__('Custom', 'chat-help'),
                                            ),
                                            'none' => array(
                                                'text' => esc_html__('None', 'chat-help'),
                                            ),
                                        ),
                                        'default'   => 'default',
                                        'dependency' => array('chat_layout', 'any', 'form,agent', 'any'),
                                    ),

                                    // adding agent photo
                                    array(
                                        'id' => 'agent-photo',
                                        'type' => 'media',
                                        'title' => esc_html__('Agent Photo', 'chat-help'),
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/user_image.png') . '" alt="' . esc_html__('Preview Image', 'chat-help') . '"></div> <div class="chat-help-info-label">' . esc_html__('Add agent photo to show in the bubble.', 'chat-help') . '</div>',
                                        'library' => 'image',
                                        'placeholder' => esc_html__('Upload or select an image from media library.', 'chat-help'),
                                        'preview' => true,
                                        'dependency' => array('chat_layout|agent_photo_type', 'any|==', 'form,agent|custom', 'any'),
                                    ),

                                    // agent name
                                    array(
                                        'id' => 'agent-name',
                                        'type' => 'text',
                                        'title' => esc_html__('Agent Name', 'chat-help'),
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/agent_name.png') . '" alt="' . esc_html__('Preview Image', 'chat-help') . '"></div> <div class="chat-help-info-label">' . esc_html__('Add your/agent name for shying in bubble.', 'chat-help') . '</div>',
                                        'default' => esc_html__('John Doe', 'chat-help'),
                                        'dependency' => array('chat_layout', 'any', 'form,agent', 'any'),
                                    ),

                                    // agent subtitle
                                    array(
                                        'id' => 'agent-subtitle',
                                        'type' => 'text',
                                        'title' => esc_html__('Subtitle', 'chat-help'),
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/agent_subtitle.png') . '" alt="' . esc_html__('Preview Image', 'chat-help') . '"></div> <div class="chat-help-info-label">' . esc_html__('Add subtitle to show under agent name.', 'chat-help') . '</div>',
                                        'default' => esc_html__('Typically replies within a day', 'chat-help'),
                                        'dependency' => array('chat_layout', 'any', 'form,agent', 'any'),
                                    ),

                                    // Header content position
                                    array(
                                        'id' => 'header-content-position',
                                        'type' => 'button_set',
                                        'title' => esc_html__('Bubble Header Content Position', 'chat-help'),
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/header_left_center.png') . '" alt="' . esc_html__('Preview Image', 'chat-help') . '"></div>',
                                        'default' => 'center',
                                        'options' => array(
                                            'left'   => array(
                                                'text' => esc_html__('Left', 'chat-help'),
                                            ),
                                            'center' => array(
                                                'text' => esc_html__('Center', 'chat-help'),
                                            ),
                                        ),
                                        'dependency' => array('chat_layout', 'any', 'form,agent', 'any'),
                                    ),

                                    // GDPR compliance checkbox
                                    array(
                                        'id' => 'gdpr-enable',
                                        'type' => 'switcher',
                                        'title' => esc_html__('GDPR Compliance', 'chat-help'),
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/gdpr.png') . '" alt="' . esc_html__('Preview Image', 'chat-help') . '"></div> <div class="chat-help-info-label">' . esc_html__('Turn ON enabling GDPR compliance checkbox.', 'chat-help') . '</div>',
                                        'default' => false,
                                        'dependency' => array('chat_layout', '!=', 'button', 'any'),
                                    ),
                                    // GDPR compliance text
                                    array(
                                        'id' => 'gdpr-compliance-content',
                                        'type' => 'wp_editor',
                                        'title' => esc_html__('GDPR Compliance Message', 'chat-help'),
                                        'title_help' => '<div class="chat-help-info-label">' . esc_html__('Change default GDPR compliance text.', 'chat-help') . '</div>',
                                        'default' => esc_attr('Please accept our <a href="#">privacy policy</a> first to start a conversation.', 'chat-help'),
                                        'dependency' => array('chat_layout|gdpr-enable', '!=|==', 'button|true', 'any'),
                                    ),
                                    array(
                                        'id' => 'show_current_time',
                                        'type' => 'switcher',
                                        'title' => esc_html__('Current Time', 'chat-help'),
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/current_time.png') . '" alt="' . esc_html__('Preview Image', 'chat-help') . '"></div> <div class="chat-help-info-label">' . esc_html__('Show message before current time.', 'chat-help') . '</div>',
                                        'default' => true,
                                        'dependency' => array('chat_layout', '==', 'agent', 'any'),
                                    ),

                                    // agent subtitle
                                    array(
                                        'id' => 'agent-message',
                                        'type' => 'textarea',
                                        'title' => esc_html__('Message From Agent', 'chat-help'),
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/agent_message.png') . '" alt="' . esc_html__('Preview Image', 'chat-help') . '"></div> <div class="chat-help-info-label">' . esc_html__('Add add custom message for shoeing in message box.', 'chat-help') . '</div>',
                                        'default' => esc_html__('Hello, Welcome to the site. Please click below button for chating me throught WhatsApp.', 'chat-help'),
                                        'dependency' => array('chat_layout', '==', 'agent', 'any'),
                                    ),

                                    // before chat icon
                                    array(
                                        'id' => 'before-chat-icon',
                                        'type' => 'button_set',
                                        'title' => esc_html__('Icon For Send Message Button', 'chat-help'),
                                        'options' => array(
                                            'icofont-brand-whatsapp'    => array(
                                                'text' => '<i class="icofont-brand-whatsapp"></i>',
                                            ),
                                            'icofont-whatsapp'    => array(
                                                'text' => '<i class="icofont-whatsapp"></i>',
                                            ),
                                            'icofont-live-support'    => array(
                                                'text' => '<i class="icofont-live-support"></i>',
                                            ),
                                            'icofont-ui-messaging'    => array(
                                                'text' => '<i class="icofont-ui-messaging"></i>',
                                            ),
                                            'icofont-telegram'    => array(
                                                'text' => '<i class="icofont-telegram"></i>',
                                            ),
                                            'icofont-life-buoy'    => array(
                                                'text' => '<i class="icofont-life-buoy"></i>',
                                            ),
                                            'no_icon'    => array(
                                                'option_name' => esc_html__('No Icon', 'chat-help'),
                                            ),
                                            'native'    => array(
                                                'text' => esc_html__('Native', 'chat-help'),
                                                'pro_only' => true,
                                            ),
                                            'custom'    => array(
                                                'text' => esc_html__('Custom', 'chat-help'),
                                                'pro_only' => true,
                                            ),
                                        ),
                                        'default' => 'icofont-brand-whatsapp',
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/send_message_icon.png') . '" alt="' . esc_html__('Preview Image', 'chat-help') . '"></div> <div class="chat-help-info-label">' . esc_html__('Change icon for adding before send message button text.', 'chat-help') . '</div>',
                                        'dependency' => array('chat_layout', 'any', 'form,agent', 'any'),
                                    ),

                                    // agent subtitle
                                    array(
                                        'id' => 'chat-button-text',
                                        'type' => 'text',
                                        'title' => esc_html__('Send Message Button Text', 'chat-help'),
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/send_message_text.png') . '" alt="' . esc_html__('Preview Image', 'chat-help') . '"></div> <div class="chat-help-info-label">' . esc_html__('Add send message button text.', 'chat-help') . '</div>',
                                        'default' => esc_html__('Send a message', 'chat-help'),
                                        'dependency' => array('chat_layout', 'any', 'form,agent', 'any'),
                                    ),
                                )
                            ),
                            array(
                                'title' => esc_html__('Forms', 'chat-help'),
                                'icon'  => 'icofont-envelope-open',
                                'fields' => array(
                                    array(
                                        'id'        => 'form_editor',
                                        'type'      => 'group',
                                        'title' => esc_html__('Form Fields', 'chat-help'),
                                        'accordion_title_number' => true,
                                        'class' => 'chat-help-form-fields-wrapper',
                                        'accordion_title_by' => 'label',
                                        'add_more_text' => __('Want to unlock the full potential of Form Fields? <a target="_blank" href="https://chathelp.themeatelier.net/pricing/"><b>Upgrade To Pro!</b></a>', 'chat-help'),
                                        'max'   => 2,
                                        'dependency' => array('chat_layout', 'any', 'form', 'any'),
                                        'fields'    => array(
                                            array(
                                                'id'    => 'field_select',
                                                'type'  => 'select',
                                                'class' => 'field_select_items_select',
                                                'title' => esc_html__('Form Fields', 'chat-help'),
                                                'options' => array(
                                                    'text' => esc_html__('Text', 'chat-help'),
                                                    'email' => esc_html__('Email (Pro)', 'chat-help'),
                                                    'phone_number' => esc_html__('Phone Number (Pro)', 'chat-help'),
                                                    'textarea' => esc_html__('Textarea', 'chat-help'),
                                                    'select' => esc_html__('Select (Pro)', 'chat-help'),
                                                ),
                                                'attributes' => array(
                                                    'style' => 'min-width: 250px;',
                                                ),
                                            ),

                                            array(
                                                'id'    => 'label',
                                                'type'  => 'text',
                                                'class' => 'field_select_label',
                                                'title' => esc_html__('Field Label', 'chat-help'),
                                                'default' => esc_html__('Field Label', 'chat-help'),
                                            ),
                                            array(
                                                'id'    => 'placeholder',
                                                'type'  => 'text',
                                                'title' => esc_html__('Placeholder', 'chat-help'),
                                                'default' => esc_html__('E.g. placeholder', 'chat-help'),
                                            ),
                                            array(
                                                'id'     => 'select_options',
                                                'type'   => 'repeater',
                                                'title'  => esc_html__('Select Options', 'chat-help'),
                                                'dependency' => array('field_select', '==', 'select'),
                                                'fields' => array(
                                                    array(
                                                        'id'    => 'option',
                                                        'type'  => 'text',
                                                        'title'  => esc_html__('Option', 'chat-help'),
                                                    ),

                                                ),
                                            ),
                                            array(
                                                'id'      => 'required',
                                                'type'    => 'checkbox',
                                                'title'   => esc_html__('Required', 'chat-help'),
                                                'default' => true,
                                                'dependency' => array('field_select', '!=', 'select'),
                                            ),
                                            array(
                                                'id'      => 'custom_validation_message',
                                                'type'    => 'text',
                                                'title'   => esc_html__('Custom Validation Message', 'chat-help'),
                                                'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/custom_validation.png') . '" alt=""></div>',
                                            ),
                                        ),
                                        'default'   => array(
                                            array(
                                                'field_select'      => 'name',
                                                'label'             => esc_html__('Name', 'chat-help'),
                                                'placeholder'       => esc_html__('Your Name?', 'chat-help'),
                                                'required'          => true,
                                            ),
                                            array(
                                                'field_select'      => 'textarea',
                                                'label'             => esc_html__('Message', 'chat-help'),
                                                'placeholder'       => esc_html__('Your Message', 'chat-help'),
                                                'required'          => true,
                                            ),
                                        ),
                                    ),

                                    array(
                                        'id' => 'chat_input_label',
                                        'type' => 'switcher',
                                        'title' => esc_html__('Input label', 'chat-help'),
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/label.png') . '" alt=""></div> <div class="chat-help-info-label">' . esc_html__('Turn Show input label.', 'chat-help') . '</div>',
                                        'text_on' => esc_html__('Show', 'chat-help'),
                                        'text_off' => esc_html__('Hide', 'chat-help'),
                                        'text_width' => 80,
                                        'dependency' => array('chat_layout', 'any', 'form', 'any'),
                                    ),
                                    array(
                                        'id' => 'chat-button-loading-text',
                                        'type' => 'text',
                                        'title' => esc_html__('Loading Text', 'chat-help'),
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/redirecting.png') . '" alt=""></div> <div class="chat-help-info-label">' . esc_html__('Add send message loading text.', 'chat-help') . '</div>',
                                        'default' => esc_html__('Redirecting...', 'chat-help'),
                                        'dependency' => array('chat_layout', 'any', 'form,agent', 'any'),
                                    ),

                                    array(
                                        'id' => 'whatsapp_message_template',
                                        'type' => 'textarea',
                                        'title' => esc_html__('Message Template', 'chat-help'),
                                        'title_help' => '<div class="chat-help-info-label">' . esc_html__('Customize your message templates based on the information you need. You can recive all form fields data using {form_fields} or use separate important variables from below this field.', 'chat-help') . '</div>',
                                        'default' => esc_html__("{form_fields}.\n\nDate: {date}"),
                                        'desc' => '<div class="message_variables"></div>',
                                        'dependency' => array('chat_layout', '==', 'form', 'any'),
                                    ),
                                ),
                            ),
                            array(
                                'title' => esc_html__('Button', 'chat-help'),
                                'icon'  => 'icofont-scroll-double-right',
                                'fields' => array(
                                    array(
                                        'id' => 'opt-button-style',
                                        'type' => 'image_select',
                                        'title' => esc_html__('Button Style', 'chat-help'),
                                        'options' => array(
                                            '1' => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/button-1.svg',
                                            '2' => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/button-2.svg',
                                            '3' => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/button-3.svg',
                                            '4' => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/button-4.svg',
                                            '5' => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/button-5.svg',
                                            '6' => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/button-6.svg',
                                            '7' => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/button-7.svg',
                                            '8' => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/button-8.svg',
                                            '9' => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/button-9.svg',
                                        ),
                                        'default' => '1',
                                    ),


                                    // Button text

                                    array(
                                        'id' => 'bubble-text',
                                        'type' => 'text',
                                        'title' => esc_html__('Button Text', 'chat-help'),
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/button_text.png') . '" alt="' . esc_html__('Preview Image', 'chat-help') . '"></div> <div class="chat-help-info-label">' . esc_html__('Change text to show in button.', 'chat-help') . '</div>',
                                        'default' => esc_html__('How may I help you?', 'chat-help'),
                                        'dependency' => array('opt-button-style', '!=', '1', 'any'),
                                    ),

                                    // Show hide icon
                                    array(
                                        'id' => 'disable-button-icon',
                                        'type' => 'switcher',
                                        'title' => esc_html__('Show/Hide Icon', 'chat-help'),
                                        'text_on' => esc_html__('Show', 'chat-help'),
                                        'text_off' => esc_html__('Hide', 'chat-help'),
                                        'default' => true,
                                        'text_width' => 80,
                                        'dependency' => array('opt-button-style', '!=', '1', 'any'),
                                    ),

                                    // Circle button icon
                                    array(
                                        'id' => 'circle-button-icon-1',
                                        'type' => 'button_set',
                                        'title' => esc_html__('Icon For Circle Button', 'chat-help'),
                                        'options' => array(
                                            'icofont-brand-whatsapp'    => array(
                                                'text' => '<i class="icofont-brand-whatsapp"></i>',
                                            ),
                                            'icofont-whatsapp'    => array(
                                                'text' => '<i class="icofont-whatsapp"></i>',
                                            ),
                                            'icofont-live-support'    => array(
                                                'text' => '<i class="icofont-live-support"></i>',
                                            ),
                                            'icofont-ui-messaging'    => array(
                                                'text' => '<i class="icofont-ui-messaging"></i>',
                                            ),
                                            'icofont-telegram'    => array(
                                                'text' => '<i class="icofont-telegram"></i>',
                                            ),
                                            'icofont-life-buoy'    => array(
                                                'text' => '<i class="icofont-life-buoy"></i>',
                                            ),
                                            'native'    => array(
                                                'text' => esc_html__('Native', 'chat-help'),
                                                'pro_only' => true,
                                            ),
                                            'custom'    => array(
                                                'text' => esc_html__('Custom', 'chat-help'),
                                                'pro_only' => true,
                                            ),
                                        ),
                                        'default' => 'icofont-brand-whatsapp',
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/circle_icon.png') . '" alt="' . esc_html__('Preview Image', 'chat-help') . '"></div> <div class="chat-help-info-label">' . esc_html__('Change icon for circle button.', 'chat-help') . '</div>',
                                        'dependency' => array('opt-button-style', '==', '1', 'any'),
                                    ),

                                    // Circle button icon close
                                    array(
                                        'id' => 'circle-button-close-1',
                                        'type' => 'button_set',
                                        'title' => esc_html__('Icon For Circle Button Close ', 'chat-help'),
                                        'options' => array(
                                            'icofont-close'    => array(
                                                'text' => '<i class="icofont-close"></i>',
                                            ),
                                            'icofont-close-line'    => array(
                                                'text' => '<i class="icofont-close-line"></i>',
                                            ),
                                            'icofont-close-circled'    => array(
                                                'text' => '<i class="icofont-close-circled"></i>',
                                            ),
                                            'icofont-ui-close'    => array(
                                                'text' => '<i class="icofont-ui-close"></i>',
                                            ),
                                            'icofont-close-squared-alt'    => array(
                                                'text' => '<i class="icofont-close-squared-alt"></i>',
                                            ),
                                            'native'    => array(
                                                'text' => esc_html__('Native', 'chat-help'),
                                                'pro_only' => true,
                                            ),
                                            'custom'    => array(
                                                'text' => esc_html__('Custom', 'chat-help'),
                                                'pro_only' => true,
                                            ),
                                        ),
                                        'default' => 'icofont-close',
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/close_icon.png') . '" alt=""></div> <div class="chat-help-info-label">' . esc_html__('Change icon for circle button close.', 'chat-help') . '</div>',
                                        'dependency' => array('opt-button-style', '==', '1', 'any'),
                                    ),
                                    // Circle button icon
                                    array(
                                        'id' => 'circle-button-icon',
                                        'type' => 'button_set',
                                        'title' => esc_html__('Icon For Circle Button', 'chat-help'),
                                        'options' => array(
                                            'icofont-brand-whatsapp'    => array(
                                                'text' => '<i class="icofont-brand-whatsapp"></i>',
                                            ),
                                            'icofont-whatsapp'    => array(
                                                'text' => '<i class="icofont-whatsapp"></i>',
                                            ),
                                            'icofont-live-support'    => array(
                                                'text' => '<i class="icofont-live-support"></i>',
                                            ),
                                            'icofont-ui-messaging'    => array(
                                                'text' => '<i class="icofont-ui-messaging"></i>',
                                            ),
                                            'icofont-telegram'    => array(
                                                'text' => '<i class="icofont-telegram"></i>',
                                            ),
                                            'icofont-life-buoy'    => array(
                                                'text' => '<i class="icofont-life-buoy"></i>',
                                            ),
                                            'native'    => array(
                                                'text' => esc_html__('Native', 'chat-help'),
                                                'pro_only' => true,
                                            ),
                                            'custom'    => array(
                                                'text' => esc_html__('Custom', 'chat-help'),
                                                'pro_only' => true,
                                            ),
                                        ),
                                        'default' => 'icofont-brand-whatsapp',
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/circle_icon.png') . '" alt="' . esc_html__('Preview Image', 'chat-help') . '"></div> <div class="chat-help-info-label">' . esc_html__('Change icon for circle button.', 'chat-help') . '</div>',
                                        'dependency' => array('disable-button-icon|opt-button-style', '==|!=', 'true|1', 'any'),
                                    ),

                                    // Circle button icon close
                                    array(
                                        'id' => 'circle-button-close',
                                        'type' => 'button_set',
                                        'title' => esc_html__('Icon For Circle Button Close ', 'chat-help'),
                                        'options' => array(
                                            'icofont-close'    => array(
                                                'text' => '<i class="icofont-close"></i>',
                                            ),
                                            'icofont-close-line'    => array(
                                                'text' => '<i class="icofont-close-line"></i>',
                                            ),
                                            'icofont-close-circled'    => array(
                                                'text' => '<i class="icofont-close-circled"></i>',
                                            ),
                                            'icofont-ui-close'    => array(
                                                'text' => '<i class="icofont-ui-close"></i>',
                                            ),
                                            'icofont-close-squared-alt'    => array(
                                                'text' => '<i class="icofont-close-squared-alt"></i>',
                                            ),
                                            'native'    => array(
                                                'text' => esc_html__('Native', 'chat-help'),
                                                'pro_only' => true,
                                            ),
                                            'custom'    => array(
                                                'text' => esc_html__('Custom', 'chat-help'),
                                                'pro_only' => true,
                                            ),
                                        ),
                                        'default' => 'icofont-close',
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/circle_icon.png') . '" alt="' . esc_html__('Preview Image', 'chat-help') . '"></div> <div class="chat-help-info-label">' . esc_html__('Change icon for circle button close.', 'chat-help') . '</div>',
                                        'dependency' => array('disable-button-icon|opt-button-style', '==|!=', 'true|1', 'any'),
                                    ),

                                    // changeing circle animations
                                    array(
                                        'id' => 'circle-animation',
                                        'type' => 'select',
                                        'title' => esc_html__('Transition Effect for Circle Icon', 'chat-help'),
                                        'options' => array(
                                            '3' => esc_html__('Fade', 'chat-help'),
                                            '1' => esc_html__('Slide down (Pro)', 'chat-help'),
                                            '2' => esc_html__('Rotate (Pro)', 'chat-help'),
                                            '4' => esc_html__('Slide Up (Pro)', 'chat-help'),
                                        ),
                                        'default' => '3',
                                        'dependency' => array('chat_layout', 'any', 'form,agent,multi', 'any'),
                                    ),


                                    // Button padding
                                    array(
                                        'id' => 'bubble-button-padding',
                                        'type' => 'spacing',
                                        'title' => esc_html__('Button Padding', 'chat-help'),
                                        'title_help' => '<div class="chat-help-info-label">' . esc_html__('Change button padding', 'chat-help') . '</div>',
                                        'default' => array(
                                            'top' => '5',
                                            'right' => '15',
                                            'bottom' => '5',
                                            'left' => '15',
                                            'unit' => 'px',
                                        ),
                                        'dependency' => array('opt-button-style', '!=', '1', 'any'),
                                    ),
                                    array(
                                        'id' => 'bubble_button_tooltip',
                                        'type' => 'button_set',
                                        'title' => esc_html__('Button Tooltip', 'chat-help'),
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/tooltip.png') . '" alt="' . esc_html__('Preview Image', 'chat-help') . '"></div> <div class="chat-help-info-label">' . esc_html__('Show button tooltip.', 'chat-help') . '</div>',
                                        'options' => array(
                                            'on_hover' => array(
                                                'text' => esc_html__('On Hover', 'chat-help'),
                                            ),
                                            'show' => array(
                                                'text' => esc_html__('Show', 'chat-help'),
                                            ),
                                            'hide' => array(
                                                'text' => esc_html__('Hide', 'chat-help'),
                                            )
                                        ),
                                        'default' => 'on_hover',
                                    ),
                                    array(
                                        'id' => 'bubble_button_tooltip_text',
                                        'type' => 'text',
                                        'title' => esc_html__('Button Tooltip Text', 'chat-help'),
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/tooltip.png') . '" alt="' . esc_html__('Preview Image', 'chat-help') . '"></div> <div class="chat-help-info-label">' . esc_html__('Set button tooltip text.', 'chat-help') . '</div>',
                                        'default' => esc_html__('Need Help? Chat with us', 'chat-help'),
                                        'dependency' => array('bubble_button_tooltip', '!=', 'hide', 'any'),
                                    ),
                                    array(
                                        'id' => 'bubble_button_tooltip_background',
                                        'type' => 'color',
                                        'title' => esc_html__('Button Tooltip Background', 'chat-help'),
                                        'title_help' => '<div class="chat-help-info-label">' . esc_html__('Set button tooltip background color.', 'chat-help') . '</div>',
                                        'default' => '#f5f7f9',
                                        'dependency' => array('bubble_button_tooltip', '!=', 'hide', 'any'),
                                    ),
                                    array(
                                        'id' => 'bubble_button_tooltip_width',
                                        'type' => 'slider',
                                        'title' => esc_html__('Button Tooltip Width', 'chat-help'),
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/tooltip_width.png') . '" alt="' . esc_html__('Preview Image', 'chat-help') . '"></div> <div class="chat-help-info-label">' . esc_html__('Set bubble button tooltip width.', 'chat-help') . '</div>',
                                        'min' => 20,
                                        'max' => 500,
                                        'step' => 5,
                                        'unit' => 'px',
                                        'default' => 210,
                                        'dependency' => array('bubble_button_tooltip', '!=', 'hide', 'any'),
                                    ),
                                ),
                            ),
                            array(
                                'title' => esc_html__('Visibility', 'chat-help'),
                                'icon' => 'icofont-eye-open',
                                'fields' => array(
                                    array(
                                        'id'       => 'visibility',
                                        'type'     => 'checkbox',
                                        'class'    => 'chat_help_column_2 visibility',
                                        'title'    => esc_html__('Visibility By', 'chat-help'),
                                        'title_help' => '<div class="chat-help-info-label">' . esc_html__('Check the option(s) to visibility by different options.', 'chat-help') . '</div>',
                                        'options'  => array(
                                            'theme_page'        => esc_html__('Theme Pages', 'chat-help'),
                                            'page'              => esc_html__('Pages', 'chat-help'),
                                            'posts'             => esc_html__('Posts (Pro)', 'chat-help'),
                                            'product'           => esc_html__('Products (Pro)', 'chat-help'),
                                            'category'          => esc_html__('Post Categories (Pro)', 'chat-help'),
                                            'tags'              => esc_html__('Post Tags (Pro)', 'chat-help'),
                                            'product_category'  => esc_html__('Porduct Categories (Pro)', 'chat-help'),
                                            'product_tags'      => esc_html__('Porduct Tags (Pro)', 'chat-help'),
                                        ),
                                    ),
                                    array(
                                        'id'            => 'visibility_by_theme_page',
                                        'type'          => 'accordion',
                                        'class'         => 'padding-t-0',
                                        'dependency'    => array('visibility', 'any', 'theme_page', 'any'),
                                        'accordions'    => array(
                                            array(
                                                'title'     => esc_html__('Theme Pages', 'chat-help'),
                                                // 'icon'      => 'fa fa-heart',
                                                'fields'    => array(
                                                    array(
                                                        'id'    => 'theme_page_target',
                                                        'type'  => 'select',
                                                        'title' => esc_html__('Target', 'chat-help'),
                                                        'options'   => array(
                                                            'include'   => esc_html__('Include', 'chat-help'),
                                                            'exclude'   => esc_html__('Exclude', 'chat-help'),
                                                        )
                                                    ),
                                                    array(
                                                        'id'    => 'theme_page_all',
                                                        'type'  => 'checkbox',
                                                        'title' => esc_html__('All Theme Pages', 'chat-help'),
                                                    ),
                                                    // Include specific
                                                    array(
                                                        'id'      => 'theme_page',
                                                        'type'    => 'select',
                                                        'title'   => esc_html__('Theme Pages', 'chat-help'),
                                                        'options'    => array(
                                                            'post_page' => esc_html__('Blog Page', 'chat-help'),
                                                            '404_page' => esc_html__('404 Page', 'chat-help'),
                                                            'search_page' => esc_html__('Search Page', 'chat-help'),
                                                        ),
                                                        'chosen'      => true,
                                                        'multiple'     => true,
                                                        'sortable'    => true,
                                                        'dependency'    => array('theme_page_all', '!=', 'true', 'any'),
                                                    ),
                                                )
                                            ),
                                        )
                                    ),
                                    array(
                                        'id'            => 'visibility_by_page',
                                        'type'          => 'accordion',
                                        'class'         => 'padding-t-0',
                                        'dependency'    => array('visibility', 'any', 'page', 'any'),
                                        'accordions'    => array(
                                            array(
                                                'title'     => esc_html__('Pages', 'chat-help'),
                                                // 'icon'      => 'fa fa-heart',
                                                'fields'    => array(
                                                    array(
                                                        'id'    => 'page_target',
                                                        'type'  => 'select',
                                                        'title' => esc_html__('Target', 'chat-help'),
                                                        'options'   => array(
                                                            'include'   => esc_html__('Include', 'chat-help'),
                                                            'exclude'   => esc_html__('Exclude', 'chat-help'),
                                                        )
                                                    ),
                                                    array(
                                                        'id'    => 'page_all',
                                                        'type'  => 'checkbox',
                                                        'title' => esc_html__('All Pages', 'chat-help'),
                                                    ),
                                                    // Include specific
                                                    array(
                                                        'id'      => 'page',
                                                        'type'    => 'select',
                                                        'title'   => esc_html__('Pages', 'chat-help'),
                                                        'options'    => 'pages',
                                                        'query_args'  => array(
                                                            'posts_per_page' => -1,
                                                        ),
                                                        'chosen'      => true,
                                                        'multiple'     => true,
                                                        'sortable'    => true,
                                                        'empty_message'    => esc_html__('You don\'t have any pages available.', 'chat-help'),
                                                        'dependency'    => array('page_all', '!=', 'true', 'any'),
                                                    ),
                                                )
                                            ),
                                        )
                                    ),

                                    // Button visibility
                                    array(
                                        'id'      => 'bubble-visibility',
                                        'type'    => 'button_set',
                                        'title'   => esc_html__('Device Visibility', 'chat-help'),
                                        'title_help' => '<div class="chat-help-info-label">' . esc_html__('Everywhere = All kind of devices.', 'chat-help') . '<br />' . esc_html__('Deskop Only = 991px bigger devices.', 'chat-help') . '<br />' . esc_html__('Tablet Only = 576px - 991px devices.', 'chat-help') . '<br />' . esc_html__('Mobile Only = Less than 576px devices.', 'chat-help') . '</div>',
                                        'default' => 'everywhere',
                                        'options'    => array(
                                            'everywhere' => array(
                                                'text' => esc_html__('Everywhere', 'chat-help'),
                                            ),
                                            'desktop'    => array(
                                                'text' => esc_html__('Desktop Only', 'chat-help'),
                                            ),
                                            'tablet'     => array(
                                                'text' => esc_html__('Tablet Only', 'chat-help'),
                                            ),
                                            'mobile'     => array(
                                                'text' => esc_html__('Mobile Only', 'chat-help'),
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            // Webhooks
                            array(
                                'title' => esc_html__('Webhooks', 'chat-help'),
                                'icon'   => 'icofont-connection',
                                'fields' => array(
                                    // A Submessage
                                    array(
                                        'type'    => 'subheading',
                                        'content' => 'Webhooks are automated HTTP POST requests that instantly transmit data to a specified URL when triggered by specific events. This allows applications to communicate in real time without requiring manual input. <a target="_blank" href="https://docs.themeatelier.net/docs/whatsapp-chat-help/floating-chat-webhooks/">Check WebHooks Documentation</a>',
                                    ),
                                    array(
                                        'id' => 'webhook_url',
                                        'type' => 'text',
                                        'title' => esc_html__('Webhook URL', 'chat-help'),
                                        'title_help' => '<div class="chat-help-info-label">' . esc_html__('Clicking on the WhatsApp floating button or multi agents triggers this Webhook URL.', 'chat-help') . '</div>',
                                        'class'      => 'only-for-pro',
                                    ),
                                    array(
                                        'id' => 'webhook_values',
                                        'type' => 'repeater',
                                        'title' => esc_html__('Add Values', 'chat-help'),
                                        'class'      => 'only-for-pro',
                                        'fields' => array(
                                            array(
                                                'id'    => 'webhook_value',
                                                'type'  => 'text',
                                                'title' => esc_html__('Add Value', 'chat-help'),
                                            ),
                                        ),
                                        'desc'  => __('<p><b>Dynamic Variables:</b> {title}, {number}, {site_url}, {current_url}, {date}, {ip}</p>
<h4>Retrieving Values from Cookies and URL Parameters</h4>

<p><b>Fetch URL Parameter Values: </b>To extract values from URL parameters, enclose the parameter name in single square brackets [ ]. If the parameter is missing, a blank value is returned.</p>
<p><b>Example:</b> [gclid], [utm_source]</p>

<p><b>Fetch Cookie Values:</b>To extract values from cookies, enclose the cookie name in double square brackets [[ ]]. If the cookie is missing, a blank value is returned.</p>
<p><b>Example:</b> [[ _ga ]]</p>', 'chat-help'),
                                    ),
                                )
                            ),
                            array(
                                'title'  => esc_html__('Others', 'chat-help'),
                                'icon'   => 'icofont-settings',
                                'fields' => array(
                                    // Autometically show popup
                                    array(
                                        'id'        => 'autoshow-popup',
                                        'type'      => 'switcher',
                                        'title'     => esc_html__('Auto Open Popup', 'chat-help'),
                                        'title_help' => '<div class="chat-help-info-label">' . esc_html__('Turn ON for open popup automatically.', 'chat-help') . '</div>',
                                        'default'   => false,
                                        'dependency' => array('chat_layout', '!=', 'button', 'any'),
                                    ),

                                    // Auto open popup timeout
                                    array(
                                        'id' => 'auto_open_popup_timeout',
                                        'type' => 'slider',
                                        'title' => esc_html__('Auto Open Popup Timeout', 'chat-help'),
                                        'title_help' => '<div class="chat-help-info-label">' . esc_html__('Timeout value for opening popup after second.', 'chat-help') . '</div>',
                                        'min' => 0,
                                        'max' => 100,
                                        'step' => 1,
                                        'default' => 0,
                                        'dependency' => array('autoshow-popup|chat_layout', '==|!=', 'true|button', 'any'),
                                    ),

                                    // Changing bubble animations
                                    array(
                                        'id'    => 'select-animation',
                                        'type'  => 'select',
                                        'title' => esc_html__('Select Animation For Bubble', 'chat-help'),
                                        'options' => array(
                                            '14'     => esc_html__('Fade', 'chat-help'),
                                            '1'     => esc_html__('Fade Right', 'chat-help'),
                                            '2'     => esc_html__('Fade Down (Pro)', 'chat-help'),
                                            '4'     => esc_html__('Fade In Scale (Pro)', 'chat-help'),
                                            '5'     => esc_html__('Rotation (Pro)', 'chat-help'),
                                            '6'     => esc_html__('Slide Fall (Pro)', 'chat-help'),
                                            '7'     => esc_html__('Slide Down (Pro)', 'chat-help'),
                                            '3'     => esc_html__('Ease Down (Pro)', 'chat-help'),
                                            '8'     => esc_html__('Rotate Left (Pro)', 'chat-help'),
                                            '9'     => esc_html__('Flip Horizontal (Pro)', 'chat-help'),
                                            '10'    => esc_html__('Flip Vertical (Pro)', 'chat-help'),
                                            '11'    => esc_html__('Flip Up (Pro)', 'chat-help'),
                                            '12'    => esc_html__('Super Scaled (Pro)', 'chat-help'),
                                            '13'    => esc_html__('Slide Up (Pro)', 'chat-help'),
                                            'random' => esc_html__('Random (Pro)', 'chat-help'),
                                        ),
                                        'default'     => 'random',
                                        'dependency' => array('chat_layout', '!=', 'button', 'any'),
                                    ),

                                    // Header content position
                                    array(
                                        'id'      => 'bubble-style',
                                        'type'    => 'button_set',
                                        'title'   => esc_html__('Select Bubble Layout Mode', 'chat-help'),
                                        'default' => 'default',
                                        'options' => array(
                                            'default' => array(
                                                'text' => esc_html__('Light mode', 'chat-help'),
                                            ),
                                            'dark'    => array(
                                                'text' => esc_html__('Dark mode', 'chat-help'),
                                                'pro_only' => true,
                                            ),
                                            'night'   => array(
                                                'text' => esc_html__('Night mode', 'chat-help'),
                                                'pro_only' => true,
                                            ),
                                        ),
                                    ),
                                    array(
                                        'id'      => 'alternative_wHelpBubble',
                                        'type'    => 'text',
                                        'title'   => esc_html__('Alternative Bubble Switcher', 'chat-help'),
                                        'dependency' => array('chat_layout', 'any', 'form,agent', 'any'),
                                        'title_help' => '<div class="chat-help-info-label">'. esc_html__('Enter comma-separated CSS class or ID selectors to treat them as bubble switch.', 'chat-help') .'</div>',
                                    ),
                                    array(
                                        'id'        => 'color_settings',
                                        'type'      => 'color_group',
                                        'title'     => esc_html__('Color Settings', 'chat-help'),
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/brand_color.png') . '" alt="' . esc_html__('Preview Image', 'chat-help') . '"></div> <div class="chat-help-info-label">' . esc_html__('Change Brand Colors.', 'chat-help') . '</div>',
                                        'options'   => array(
                                            'primary' => esc_html__('Primary', 'chat-help'),
                                            'secondary' => esc_html__('Secondary', 'chat-help'),
                                        ),
                                        'default'   => array(
                                            'primary' => '#118c7e',
                                            'secondary' => '#0b5a51',
                                        ),
                                    ),
                                    array(
                                        'id'    => 'heading',
                                        'type'  => 'heading',
                                        'title' => esc_html__('Button Positioning', 'chat-help'),
                                    ),
                                    array(
                                        'id'      => 'bubble-position',
                                        'type'    => 'button_set',
                                        'title'   => esc_html__('Bubble Position', 'chat-help'),
                                        'default' => 'right_bottom',
                                        'options'    => array(
                                            'right_bottom'   => array(
                                                'text' => esc_html__('Right Bottom', 'chat-help'),
                                            ),
                                            'left_bottom' => array(
                                                'text' => esc_html__('Left Bottom', 'chat-help'),
                                            ),
                                            'right_middle' => array(
                                                'text'     => esc_html__('Right Middle', 'chat-help'),
                                                'pro_only' => true,
                                            ),
                                            'left_middle'  => array(
                                                'text'     => esc_html__('Left Middle', 'chat-help'),
                                                'pro_only' => true,
                                            ),
                                        ),
                                    ),

                                    array(
                                        'id'    => 'right_bottom',
                                        'type'  => 'spacing',
                                        'title' => esc_html__('Margin From Right Bottom', 'chat-help'),
                                        'top'   => false,
                                        'left'  => false,
                                        'default'  => array(
                                            'right'    => '30',
                                            'bottom'  => '30',
                                            'unit'   => 'px',
                                        ),
                                        'dependency' => array('bubble-position', '==', 'right_bottom', 'any'),
                                    ),

                                    array(
                                        'id'    => 'left_bottom',
                                        'type'  => 'spacing',
                                        'title' => esc_html__('Margin From Left Bottom', 'chat-help'),
                                        'top'   => false,
                                        'right'  => false,
                                        'default'  => array(
                                            'left'    => '30',
                                            'bottom'  => '30',
                                            'unit'   => 'px',
                                        ),
                                        'dependency' => array('bubble-position', '==', 'left_bottom', 'any'),
                                    ),

                                    array(
                                        'id'    => 'right_middle',
                                        'type'  => 'spacing',
                                        'title' => esc_html__('Margin From Right Middle', 'chat-help'),
                                        'top'   => false,
                                        'left'  => false,
                                        'bottom'  => false,
                                        'default'  => array(
                                            'right'    => '20',
                                            'unit'   => 'px',
                                        ),
                                        'dependency' => array('bubble-position', '==', 'right_middle', 'any'),
                                    ),

                                    array(
                                        'id'    => 'left_middle',
                                        'type'  => 'spacing',
                                        'title' => esc_html__('Margin From Left Middle', 'chat-help'),
                                        'top'   => false,
                                        'right' => false,
                                        'bottom' => false,
                                        'default'  => array(
                                            'left' => '20',
                                            'unit' => 'px',
                                        ),
                                        'dependency' => array('bubble-position', '==', 'left_middle', 'any'),
                                    ),

                                    array(
                                        'type'  => 'subheading',
                                        'title' => esc_html__('Different Positioning on Tablet', 'chat-help'),
                                        'dependency' => array('bubble-visibility', '==', 'everywhere', 'any'),
                                    ),

                                    array(
                                        'id'    => 'enable-positioning-tablet',
                                        'type'  => 'switcher',
                                        'class'    => 'switcher_pro_only',
                                        'title' => esc_html__('Use Different Positioning For Tablet Devices', 'chat-help'),
                                        'text_on' => esc_html__('Yes', 'chat-help'),
                                        'text_off'  => esc_html__('No', 'chat-help'),
                                        'dependency' => array('bubble-visibility', '==', 'everywhere', 'any'),
                                    ),

                                    // Bubble position
                                    array(
                                        'id'      => 'bubble-position-tablet',
                                        'type'    => 'button_set',
                                        'title'   => esc_html__('Bubble Position', 'chat-help'),
                                        'default' => 'right_bottom',
                                        'options'    => array(
                                            'right_bottom' => array(
                                                'text' => esc_html__('Right Bottom', 'chat-help'),
                                            ),
                                            'left_bottom'  => array(
                                                'text' => esc_html__('Left Bottom', 'chat-help'),
                                            ),
                                            'right_middle' => array(
                                                'text'     => esc_html__('Right Middle', 'chat-help'),
                                                'pro_only' => true,
                                            ),
                                            'left_middle'  => array(
                                                'text'     => esc_html__('Left Middle', 'chat-help'),
                                                'pro_only' => true,
                                            ),
                                        ),
                                        'dependency' => array('enable-positioning-tablet|bubble-visibility', '==|==', 'true|everywhere', 'any'),
                                    ),

                                    array(
                                        'id'    => 'right_bottom_tablet',
                                        'type'  => 'spacing',
                                        'title' => esc_html__('Margin From Right Bottom', 'chat-help'),
                                        'top'   => false,
                                        'left'  => false,
                                        'default'  => array(
                                            'right'    => '30',
                                            'bottom'  => '30',
                                            'unit'   => 'px',
                                        ),
                                        'dependency' => array('bubble-position-tablet|enable-positioning-tablet|bubble-visibility', '==|==|==', 'right_bottom|true|everywhere', 'any'),
                                    ),

                                    array(
                                        'id'    => 'left_bottom_tablet',
                                        'type'  => 'spacing',
                                        'title' => esc_html__('Margin From Left Bottom', 'chat-help'),
                                        'top'   => false,
                                        'right'  => false,
                                        'default'  => array(
                                            'left'    => '30',
                                            'bottom'  => '30',
                                            'unit'   => 'px',
                                        ),
                                        'dependency' => array('bubble-position-tablet|enable-positioning-tablet|bubble-visibility', '==|==|==', 'left_bottom|true|everywhere', 'any'),
                                    ),

                                    array(
                                        'id'    => 'right_middle_tablet',
                                        'type'  => 'spacing',
                                        'title' => esc_html__('Margin From Right Middle', 'chat-help'),
                                        'top'   => false,
                                        'left'  => false,
                                        'bottom'  => false,
                                        'default'  => array(
                                            'right'    => '20',
                                            'unit'   => 'px',
                                        ),
                                        'dependency' => array('bubble-position-tablet|enable-positioning-tablet|bubble-visibility', '==|==|==', 'right_middle|true|everywhere', 'any'),
                                    ),

                                    array(
                                        'id'    => 'left_middle_tablet',
                                        'type'  => 'spacing',
                                        'title' => esc_html__('Margin From Left Middle', 'chat-help'),
                                        'top'   => false,
                                        'right' => false,
                                        'bottom' => false,
                                        'default'  => array(
                                            'left' => '20',
                                            'unit' => 'px',
                                        ),
                                        'dependency' => array('bubble-position-tablet|enable-positioning-tablet|bubble-visibility', '==|==|==', 'left_middle|true|everywhere', 'any'),
                                    ),

                                    array(
                                        'type'  => 'subheading',
                                        'title' => esc_html__('Different Positioning on Mobile', 'chat-help'),
                                        'dependency'    => array('bubble-visibility', '==', 'everywhere', 'any')
                                    ),
                                    array(
                                        'id'    => 'enable-positioning-mobile',
                                        'type'  => 'switcher',
                                        'class'    => 'switcher_pro_only',
                                        'title' => esc_html__('Use Different Positioning for Mobile Devices', 'chat-help'),
                                        'text_on' => esc_html__('Yes', 'chat-help'),
                                        'text_off'  => esc_html__('No', 'chat-help'),
                                        'dependency'    => array('bubble-visibility', '==', 'everywhere', 'any')
                                    ),

                                    // Bubble position
                                    array(
                                        'id'      => 'bubble-position-mobile',
                                        'type'    => 'button_set',
                                        'title'   => esc_html__('Bubble position', 'chat-help'),
                                        'default' => 'right_bottom',
                                        'options'    => array(
                                            'right_bottom' => array(
                                                'text' => esc_html__('Right Bottom', 'chat-help'),
                                            ),
                                            'left_bottom'  => array(
                                                'text' => esc_html__('Left Bottom', 'chat-help'),
                                            ),
                                            'right_middle' => array(
                                                'text'     => esc_html__('Right Middle', 'chat-help'),
                                                'pro_only' => true,
                                            ),
                                            'left_middle'  => array(
                                                'text'     => esc_html__('Left Middle', 'chat-help'),
                                                'pro_only' => true,
                                            ),
                                        ),
                                        'dependency' => array('enable-positioning-mobile|bubble-visibility', '==|==', 'true|everywhere', 'any'),
                                    ),

                                    array(
                                        'id'    => 'right_bottom_mobile',
                                        'type'  => 'spacing',
                                        'title' => esc_html__('Margin From Right Bottom', 'chat-help'),
                                        'top'   => false,
                                        'left'  => false,
                                        'default'  => array(
                                            'right'    => '30',
                                            'bottom'  => '30',
                                            'unit'   => 'px',
                                        ),
                                        'dependency' => array('bubble-position-mobile|enable-positioning-mobile|bubble-visibility', '==|==|==', 'right_bottom|true|everywhere', 'any'),
                                    ),

                                    array(
                                        'id'    => 'left_bottom_mobile',
                                        'type'  => 'spacing',
                                        'title' => esc_html__('Margin From Left Bottom', 'chat-help'),
                                        'top'   => false,
                                        'right'  => false,
                                        'default'  => array(
                                            'left'    => '30',
                                            'bottom'  => '30',
                                            'unit'   => 'px',
                                        ),
                                        'dependency' => array('bubble-position-mobile|enable-positioning-mobile|bubble-visibility', '==|==|==', 'left_bottom|true|evenywhere', 'any'),
                                    ),

                                    array(
                                        'id'    => 'right_middle_mobile',
                                        'type'  => 'spacing',
                                        'title' => esc_html__('Margin From Right Middle', 'chat-help'),
                                        'top'   => false,
                                        'left'  => false,
                                        'bottom'  => false,
                                        'default'  => array(
                                            'right'    => '20',
                                            'unit'   => 'px',
                                        ),
                                        'dependency' => array('bubble-position-mobile|enable-positioning-mobile|bubble-visibility', '==|==|==', 'right_middle|true|everywhere', 'any'),
                                    ),

                                    array(
                                        'id'    => 'left_middle_mobile',
                                        'type'  => 'spacing',
                                        'title' => esc_html__('Margin From Left Middle', 'chat-help'),
                                        'top'   => false,
                                        'right' => false,
                                        'bottom' => false,
                                        'default'  => array(
                                            'left' => '20',
                                            'unit' => 'px',
                                        ),
                                        'dependency' => array('bubble-position-mobile|enable-positioning-mobile|bubble-visibility', '==|==|==', 'left_middle|true|everywhere', 'any'),
                                    ),
                                )
                            ),
                        ),
                    ),
                )
            ),
        );
    }
}
