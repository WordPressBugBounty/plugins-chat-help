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
                'class' => 'floating_chat',
                'fields' => array(
                    array(
                        'id' => 'chat_layout',
                        'type' => 'layout_preset',
                        'title' => esc_html__('Floating Chat Layout(s)', 'chat-help'),
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
                                'option_demo_url' => CHAT_HELP_DEMO_URL . 'single-form',
                                'class'           => ' wrapper_class_form',
                            ),
                            'agent' => array(
                                'image'           => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/single_agent.svg',
                                'text'            => esc_html__('Single Agent', 'chat-help'),
                                'option_demo_url' => CHAT_HELP_DEMO_URL . 'single-agent',

                            ),
                            'button' => array(
                                'image'           => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/single_button.svg',
                                'text'            => esc_html__('Simple Button', 'chat-help'),
                                'option_demo_url' => CHAT_HELP_DEMO_URL . 'simple-button',

                            ),
                            'advance_button' => array(
                                'image'           => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/advanced_button.svg',
                                'text'            => esc_html__('Advance Button', 'chat-help'),
                                'option_demo_url' => CHAT_HELP_DEMO_URL . 'advance-button',
                                'pro_only'        => true,

                            ),
                            'multi' => array(
                                'image'           => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/multi_agent.svg',
                                'text'            => esc_html__('Multi Agents List', 'chat-help'),
                                'option_demo_url' => CHAT_HELP_DEMO_URL . 'multi-agents-list',
                                'pro_only'        => true,
                            ),
                            'multi_grid' => array(
                                'image'           => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/multi_grid.svg',
                                'text'            => esc_html__('Multi Agents Grid', 'chat-help'),
                                'option_demo_url' => CHAT_HELP_DEMO_URL . 'multi-agents-grid',
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
                                    // adding contact number
                                    array(
                                        'id' => 'type_of_whatsapp',
                                        'type' => 'radio',
                                        'inline' => true,
                                        'class' => 'chat_help_type_of_whatsapp',
                                        'title' => esc_html__('WhatsApp Type', 'chat-help'),
                                        'title_help' => '<div class="chat-help-info-label">' . esc_html__('Select “Number” to receive direct messages, or “Group” to let people join your WhatsApp group.', 'chat-help') . '</div>' . '<a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/what-is-the-whatsapp-type-field-and-how-should-i-use-it/?ref=1">' . esc_html__('Detailed explanation', 'chat-help') . '</a>',
                                        'options'    => array(
                                            'number' => 'Number',
                                            'group' => 'Group',
                                        ),
                                        'default' => 'number',

                                        'dependency' =>  array(
                                            array('chat_layout', '!=', 'multi', 'any'),
                                            array('chat_layout', '!=', 'multi_grid', 'any'),
                                            array('chat_layout',   '!=', 'form', 'visible'),
                                        ),
                                    ),
                                    array(
                                        'id' => 'opt-number',
                                        'class' => 'chat_help_number',
                                        'type' => 'text',
                                        'title' => esc_html__('WhatsApp Number', 'chat-help'),
                                        'title_help' => '<div class="chat-help-info-label">' . esc_html__('Add your WhatsApp number including the country code (e.g., +880123456189).', 'chat-help') . '</div> <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/how-should-i-enter-my-whatsapp-number-in-the-plugin/?ref=1">Detailed explanation</a>',
                                        'chat-help',
                                        'desc' => esc_html__('Enter WhatsApp number with country code (e.g., +10123456189).', 'chat-help'),
                                        // 'title_video' => '<div class="chat-help-img-tag">
                                        //     <video autoplay loop muted playsinline>
                                        //         <source src="http://chat-whatsapp.local/wp-content/uploads/2025/05/os-aware-darkmode.webm" type="video/webm">
                                        //     </video>
                                        // </div><div class="chat-help-info-label">Dark Mode toggling based on OS setting</div>',
                                        'dependency' =>  array(
                                            array('chat_layout', '!=', 'multi', 'any'),
                                            array('chat_layout', '!=', 'multi_grid', 'any'),
                                            array('type_of_whatsapp',   '!=', 'group', 'visible'),
                                        ),
                                    ),

                                    array(
                                        'id' => 'opt-group',
                                        'type' => 'text',
                                        'class' => 'chat_help_group',
                                        'title' => esc_html__('WhatsApp Group', 'chat-help'),
                                        'desc' => esc_html__('Enter a valid WhatsApp group link (e.g., https://chat.whatsapp.com/Dn16RARM6KW7X4fq0fxVet).', 'chat-help'),
                                        'title_help' => '<div class="chat-help-info-label">' . esc_html__('Invite your visitors to join your WhatsApp group by adding the group’s invite URL here.', 'chat-help') . '</div> <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/how-do-i-create-a-whatsapp-group-and-invite-members/?ref=1">Detailed explanation</a>',
                                        'dependency' =>  array(
                                            array('chat_layout',   '!=', 'form', 'visible'),
                                            array('type_of_whatsapp',   '==', 'group', 'visible'),
                                        ),
                                    ),
                                    /************************************
                                     * SINGLE FORM SETTINGS
                                     *************************************/
                                    // Form Fields for Form Layout
                                    array(
                                        'id'        => 'form_editor',
                                        'type'      => 'group',
                                        'title' => esc_html__('Form Fields', 'chat-help'),
                                        'accordion_title_number' => true,
                                        'title_help' => '<div class="chat-help-info-label">' .  esc_html__('Add and customize the input fields for your WhatsApp form.', 'chat-help') .  '</div>' . ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' . ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/single-form/#form-fields-field-options">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'class' => 'chat-help-form-fields-wrapper',
                                        'accordion_title_by' => 'label',
                                        'add_more_text' => __('Want to unlock the full potential of Form Fields? <a target="_blank" href="' . CHAT_HELP_DEMO_URL . 'pricing/"><b>Upgrade To Pro!</b></a>  Limited time 70% early bird offer going on!', 'chat-help'),
                                        'max'   => 2,
                                        'dependency' => array('chat_layout', 'any', 'form', 'any'),
                                        'fields'    => array(
                                            array(
                                                'id'    => 'field_select',
                                                'type'  => 'select',
                                                'class' => 'field_select_items_select',
                                                'title' => esc_html__('Field Type', 'chat-help'),
                                                'title_help' =>
                                                '<div class="chat-help-info-label">' .
                                                    esc_html__('Select the type of form field you want to add (Text, Email, Phone Number, Textarea, or Select). Each field type allows you to collect different kinds of user input.', 'chat-help') .
                                                    '</div>' .
                                                    ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/single-form/#form-fields-field-options') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                                'options' => array(
                                                    'text' => esc_html__('Text', 'chat-help'),
                                                    'textarea' => esc_html__('Textarea', 'chat-help'),
                                                    'email' => esc_html__('Email (Pro)', 'chat-help'),
                                                    'phone_number' => esc_html__('Phone Number (Pro)', 'chat-help'),
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
                                                'title' => esc_html__('Label', 'chat-help'),
                                                'title_help' =>
                                                '<div class="chat-help-info-label">' .
                                                    esc_html__('Enter the label text for this field.', 'chat-help') .
                                                    '</div>' .
                                                    '<div>' .
                                                    esc_html__('The label appears above or beside the input field and helps users understand what information to provide.', 'chat-help') .
                                                    '</div>' .
                                                    ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/single-form/#form-fields-field-options') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                                'placeholder' => esc_html__('Field Label', 'chat-help'),
                                            ),
                                            array(
                                                'id'    => 'placeholder',
                                                'type'  => 'text',
                                                'title' => esc_html__('Placeholder', 'chat-help'),
                                                'title_help' =>
                                                '<div class="chat-help-info-label">' .
                                                    esc_html__('Enter the placeholder text for this field.', 'chat-help') .
                                                    '</div>' .
                                                    '<div>' .
                                                    esc_html__('The placeholder appears inside the input box and disappears when the user types.' . 'chat-help') .
                                                    '</div>' .
                                                    ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/single-form/#form-fields-field-options') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                                'placeholder' => esc_html__('E.g. placeholder', 'chat-help'),
                                                'dependency' => array('field_select', '!=', 'select'),
                                            ),
                                            array(
                                                'id'    => 'select_default_option',
                                                'type'  => 'text',
                                                'title'   => esc_html__('Default Placeholder', 'chat-help'),
                                                'title_help' =>
                                                '<div class="chat-help-info-label">' .
                                                    esc_html__('Set a default placeholder option for the select dropdown (e.g., "Select Option"). This option will appear as the first unselectable choice until the user picks a value.', 'chat-help') .
                                                    '</div>' .
                                                    ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/single-form/#form-fields-field-options') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                'desc'    => esc_html__('Leave blank if you don\'t want to display a default placeholder option.', 'chat-help'),
                                                'default' => esc_html__('Select Option', 'chat-help'),

                                                'dependency' => array('field_select', '==', 'select'),
                                            ),
                                            array(
                                                'id'     => 'select_options',
                                                'type'   => 'repeater',
                                                'title'  => esc_html__('Select Options', 'chat-help'),
                                                'dependency' => array('field_select', '==', 'select'),
                                                'title_help' =>
                                                '<div class="chat-help-info-label">' .
                                                    esc_html__('Add the options that will appear in the select dropdown. You can add as many options as needed using the repeater.', 'chat-help') .
                                                    '</div>' .
                                                    ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/single-form/#select-field-options-special-fields') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                'fields' => array(
                                                    array(
                                                        'id'    => 'option',
                                                        'type'  => 'text',
                                                        'title' => esc_html__('Option', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Enter the label for this option. Each entry becomes a selectable choice in the dropdown list.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/single-form/#select-field-options-special-fields') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                    ),
                                                ),
                                            ),

                                            array(
                                                'id'      => 'required',
                                                'type'    => 'checkbox',
                                                'title' => esc_html__('Required', 'chat-help'),
                                                'title_help' =>
                                                '<div class="chat-help-info-label">' .
                                                    esc_html__('Check this option to make the field mandatory. Users will not be able to submit the form without filling in this field.', 'chat-help') .
                                                    '</div>' .
                                                    ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/form-fields/?ref=4') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                                'default' => true,
                                                'dependency' => array('field_select', '!=', 'select'),
                                            ),
                                            array(
                                                'id'      => 'custom_validation_message',
                                                'type'    => 'text',
                                                'title'   => esc_html__('Custom Validation Message', 'chat-help'),
                                                'title_help' =>
                                                '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/custom_validation.png') . '" alt="' . esc_html__('Custom Validation Message Preview', 'chat-help') . '"></div>' .
                                                    '<div>' .
                                                    esc_html__('Set a custom error message that will appear if the user leaves this required field empty or enters invalid data.', 'chat-help') .
                                                    '</div>' .
                                                    ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/single-form/#form-fields-field-options') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                            ),
                                        ),
                                        'default'   => array(
                                            array(
                                                'field_select'      => 'name',
                                                'label'             => esc_html__('Name', 'chat-help'),
                                                'placeholder'       => esc_html__('Your Name', 'chat-help'),
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
                                        'title' => esc_html__('Input Label', 'chat-help'),
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/label.png') . '" alt=""></div> <div class="chat-help-info-label">' . esc_html__('Show or hide labels above form fields.', 'chat-help') . '</div>' .
                                            '<a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/single-form/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            '<a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/single-form/#form-fields-field-options">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'text_on' => esc_html__('Show', 'chat-help'),
                                        'text_off' => esc_html__('Hide', 'chat-help'),
                                        'text_width' => 80,
                                        'dependency' => array('chat_layout', 'any', 'form', 'any'),
                                    ),

                                    array(
                                        'id' => 'whatsapp_message_template',
                                        'type' => 'textarea',
                                        'title' => esc_html__('Form Message Template', 'chat-help'),
                                        'title_help' => '<div class="chat-help-info-label">' .  esc_html__('Customize the WhatsApp message template sent after form submission.', 'chat-help') . '</div>' . ' ' . esc_html__('Use {form_fields} to include all fields, or insert specific variables (e.g., {text_1}, {textarea_2}) for more control.', 'chat-help') .      '</br>' . ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/how-can-i-use-dynamic-variables-in-the-single-form-layout/">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'default' => "Hello! \nI’d like to get in touch regarding {currentTitle}.\nHere are my details:\n{form_fields}  {PRODUCT_START}\nProduct: {productName}\nPrice: {productPrice}{PRODUCT_END}",
                                        'desc' => '<div class="message_variables"></div>',
                                        'dependency' => array('chat_layout', '==', 'form', 'any'),
                                    ),

                                    /************************************
                                     * SINGLE AGENT WITHOUT FORM
                                     *************************************/

                                    array(
                                        'id' => 'show_current_time',
                                        'type' => 'switcher',
                                        'title' => esc_html__('Current Time', 'chat-help'),
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/current_time.png') . '" alt=""></div> <div class="chat-help-info-label">' . esc_html__('Enable to display the current time before the agent’s message.', 'chat-help') . '</div>' .
                                            '<a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/single-agent/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            '<a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/single-agent/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'default' => true,
                                        'dependency' => array('chat_layout', '==', 'agent', 'any'),
                                        'text_on'    => esc_html__('Enabled', 'chat-help'),
                                        'text_off'   => esc_html__('Disabled', 'chat-help'),
                                        'text_width' => 100
                                    ),

                                    // message from agent
                                    array(
                                        'id' => 'agent-message',
                                        'type' => 'textarea',
                                        'title' => esc_html__('Message From Agent', 'chat-help'),
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/agent_message.png') . '" alt=""></div> <div class="chat-help-info-label">' . esc_html__('Add a custom message to display inside the agent’s message box.', 'chat-help') . '</div>' .
                                            '<a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-agent/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            '<a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/single-agent/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'default' => esc_html__('Hello 👋 Welcome to {siteTitle}! Click the button below to start chatting with us on WhatsApp.', 'chat-help'),
                                        'desc' => __('Global Vars:  {siteTitle}, {siteEmail}, {currentURL}, {currentTitle}, {siteURL}, {ip}, {date} <br> {PRODUCT_START} WooCommerce Vars: {productName}, {productSlug}, {productSku}, {productPrice}, {productRegularPrice}, {productSalePrice}, {productStockStatus} {PRODUCT_END} <br> <b>Conditional Blocks:</b>  {PRODUCT_START} ... {PRODUCT_END},  {NOT_PRODUCT_START} ... {NOT_PRODUCT_END},  {LOGGEDIN_START} ... {LOGGEDIN_END},  {NOT_LOGGEDIN_START} ... {NOT_LOGGEDIN_END}', 'chat-help'),
                                        'dependency' => array('chat_layout', '==', 'agent', 'any'),
                                    ),

                                    /************************************
                                     * PREDEFINED FOR SINGLE AGENT, SIMPLE BUTTON, ADVANCE BUTTON
                                     *************************************/
                                    array(
                                        'id'    => 'prefilled_message',
                                        'type'  => 'textarea',
                                        'title' => esc_html__('Pre-filled Message', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Write a friendly, pre-filled message that appears when users click the chat bubble.', 'chat-help') .
                                            ' ' .
                                            esc_html__('Example: "Hi! I have a question about your services."', 'chat-help') .
                                            ' ' .
                                            esc_html__('You can also insert dynamic variables as needed.', 'chat-help') .
                                            '</div>' .
                                            '<a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-agent/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>' .
                                            '<a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/10-how-can-i-use-dynamic-variables-in-the-woocommerce-button-pre-filled-message/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'desc' =>
                                        '<b>' . esc_html__('Global Vars:', 'chat-help') . '</b> {siteTitle}, {siteEmail}, {currentURL}, {currentTitle}, {siteURL}, {ip}, {date} <br>' .
                                            '<b>' . esc_html__('WooCommerce Vars:', 'chat-help') . '</b> {productName}, {productSlug}, {productSku}, {productPrice}, {productRegularPrice}, {productSalePrice}, {productStockStatus} <br>' .
                                            '<b>' . esc_html__('Conditional Blocks:', 'chat-help') . '</b> {PRODUCT_START} ... {PRODUCT_END}, {NOT_PRODUCT_START} ... {NOT_PRODUCT_END}, {LOGGEDIN_START} ... {LOGGEDIN_END}, {NOT_LOGGEDIN_START} ... {NOT_LOGGEDIN_END} ',

                                        'default'   => __('Hello! I have a question about {currentTitle}.', 'chat-help'),
                                        'dependency' =>
                                        array(
                                            array('chat_layout',   '!=', 'form', 'visible'),
                                            array('chat_layout',   '!=', 'multi', 'visible'),
                                            array('chat_layout',   '!=', 'multi_grid', 'visible'),
                                            array('type_of_whatsapp',   '!=', 'group', 'visible'),
                                        ),
                                    ),
                                    /************************************
                                     * TIMEZONE SETTINGS
                                     *************************************/
                                    array(
                                        'id' => 'availablity_heading',
                                        'type' => 'heading',
                                        'content' => esc_html__('Availability', 'chat-help'),
                                        'dependency' => array(
                                            array('chat_layout', '!=', 'multi', 'any'),
                                            array('chat_layout', '!=', 'multi_grid', 'any'),
                                        ),
                                    ),

                                    // changeing timezone
                                    array(
                                        'id' => 'select-timezone',
                                        'type' => 'select',
                                        'title' => esc_html__('Timezone', 'chat-help'),
                                        'title_help' => '<div class="chat-help-info-desc">' . esc_html__('Select your local timezone. Availability schedules will be applied based on this timezone.', 'chat-help') . '</div>' .
                                            '<a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/how-do-timezone-and-availability-work-in-whatsapp-chat-help/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'chosen' => true,
                                        'placeholder' => esc_html__('Select Timezone', 'chat-help'),
                                        'dependency' => array(
                                            array('chat_layout', '!=', 'multi', 'any'),
                                            array('chat_layout', '!=', 'multi_grid', 'any'),
                                        ),
                                        'options' => $timezones,
                                    ),

                                    // Add availablity
                                    array(
                                        'id' => 'opt-availablity',
                                        'type' => 'tabbed',
                                        'title' => esc_html__('Availability', 'chat-help'),
                                        'title_help' => '<div class="chat-help-info-desc">' . esc_html__('Set your daily availability using 24-hour format (e.g., 09:00 to 18:00). To mark a full day as offline, set both From and To values to 00:00.', 'chat-help') . '</div>' .
                                            '<a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/how-do-timezone-and-availability-work-in-whatsapp-chat-help/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'dependency' => array(
                                            array('chat_layout', '!=', 'multi', 'any'),
                                            array('chat_layout', '!=', 'multi_grid', 'any'),
                                        ),
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

                                    /************************************
                                     * MULTI AGENTS ITEMS SETTINGS
                                     *************************************/
                                    // Show search field
                                    array(
                                        'id' => 'bubble-search',
                                        'type' => 'switcher',
                                        'title' => esc_html__('Show Search Field', 'chat-help'),
                                        'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/search_field.webp') . '" alt=""></div> <div class="chat-help-info-label">' . esc_html__('Show or hide the search box. This helps visitors quickly find an agent when you have many agents.', 'chat-help') . '</div>' .
                                            '<a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'multi-agent-list/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            '<a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/multi-agent-list/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'default' => true,
                                        'text_on' => esc_html__('Yes', 'chat-help'),
                                        'text_off' => esc_html__('No', 'chat-help'),
                                        'dependency' => array('chat_layout', 'any', 'multi,multi_grid', 'any'),
                                    ),


                                    // Chat agents
                                    array(
                                        'id' => 'opt-chat-agents',
                                        'type' => 'group',
                                        'title' => esc_html__('Chat Agents', 'chat-help'),
                                        'title_help' =>
                                        esc_html__('Add and manage your chat agents. Each agent can have a name, photo, WhatsApp type (number or group), pre-filled message, timezone, availability, designation, and custom online/offline text. You can add as many agents as you need.', 'chat-help') .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'multi-agents/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/multi-agent-list/#agent-settings">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'dependency' => array('chat_layout', 'any', 'multi,multi_grid', 'any'),
                                        'fields' => array(
                                            array(
                                                'id' => 'agent-name',
                                                'type' => 'text',
                                                'title' => esc_html__('Agent Name', 'chat-help'),
                                                'title_help' =>
                                                '<div class="chat-help-info-label">' .
                                                    esc_html__('Enter the agent’s name.', 'chat-help') .
                                                    '</div>' .
                                                    ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'multi-agent-list/?ref=1"') . '">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                                    ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/#agent-settings"') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                            ),

                                            // agent designation
                                            array(
                                                'id' => 'agent-designation',
                                                'type' => 'text',
                                                'title' => esc_html__('Agent Designation', 'chat-help'),
                                                'title_help' =>
                                                '<div class="chat-help-info-label">' .
                                                    esc_html__('Enter the agent’s designation or role (e.g., Sales Manager, Support Agent).', 'chat-help') .
                                                    '</div>' .
                                                    ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'multi-agent-list/?ref=1"') . '">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                                    ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/multi-agent-list/#agent-settings"') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                            ),

                                            // adding agent photo
                                            array(
                                                'id'    => 'agent-photo',
                                                'type'  => 'media',
                                                'title' => esc_html__('Agent Photo', 'chat-help'),
                                                'title_help' =>
                                                '<div class="chat-help-info-label">' .
                                                    esc_html__('Upload or select an image to use as the agent’s photo.', 'chat-help') .
                                                    '</div>' .
                                                    ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'multi-agent-list/?ref=1"') . '">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                                    ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/multi-agent-list/#agent-settings"') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                                'placeholder' => CHAT_HELP_DIR_URL . 'src/assets/image/user.webp',
                                                'library' => 'image',
                                                'preview' => true,
                                            ),

                                            array(
                                                'id' => 'agent_type_of_whatsapp',
                                                'type' => 'radio',
                                                'inline' => true,
                                                'class' => 'chat_help_type_of_whatsapp',
                                                'title' => esc_html__('WhatsApp Type', 'chat-help'),
                                                'title_help' => '<div class="chat-help-info-label">' . esc_html__('Select "Number" to receive direct messages or "Group" to let people join your WhatsApp group.', 'chat-help') . '</div>' . '<a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/what-is-the-whatsapp-type-field-and-how-should-i-use-it/?ref=1">' . esc_html__('Detailed explanation', 'chat-help') . '</a>',
                                                'options'    => array(
                                                    'number' => 'Number',
                                                    'group' => 'Group',
                                                ),
                                                'default' => 'number',
                                            ),
                                            array(
                                                'id' => 'agent-number',
                                                'type' => 'text',
                                                'class' => 'chat_help_number',
                                                'title' => esc_html__('WhatsApp Number for Agent', 'chat-help'),
                                                'desc' => 'WhatsApp number in international format.',
                                                'chat-help',
                                                'title_help' => '<div class="chat-help-info-label">' . esc_html__('Add your WhatsApp number including country code. eg: +880123456189', 'chat-help') . '</div> <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/how-should-i-enter-my-whatsapp-number-in-the-plugin/?ref=1">Detailed explanation</a>',
                                                'dependency' => array('agent_type_of_whatsapp',   '==', 'number'),
                                            ),
                                            array(
                                                'id' => 'agent-group',
                                                'type' => 'text',
                                                'class' => 'chat_help_group',
                                                'title' => esc_html__('WhatsApp Group', 'chat-help'),
                                                'desc' => 'WhatsApp group link.',
                                                'chat-help',
                                                'title_help' => '<div class="chat-help-info-label">' . esc_html__('Invite your visitors to join into your whatapp group.', 'chat-help') . '</div> <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/how-do-i-create-a-whatsapp-group-and-invite-members/?ref=1">Detailed explanation</a>',
                                                'dependency' => array('agent_type_of_whatsapp',   '==', 'group'),
                                            ),

                                            // Predefined text
                                            array(
                                                'id'    => 'prefilled_message',
                                                'type'  => 'textarea',
                                                'title' => esc_html__('Pre-filled Message', 'chat-help'),
                                                'title_help' =>
                                                '<div class="chat-help-info-label">' .
                                                    esc_html__('Write a friendly, pre-filled message that will appear when users start a chat with this agent. Example: “Hi! I have a question about your services.”', 'chat-help') .
                                                    '</div>' .
                                                    ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/how-can-i-use-dynamic-variables-in-the-message-from-agent-field-single-agent-layout/?ref=1"') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                                'desc' => __(
                                                    '<b>Global Vars:</b> {siteTitle}, {siteEmail}, {currentURL}, {currentTitle}, {siteURL}, {ip}, {date}<br>' .
                                                        '<b>WooCommerce Vars:</b> {productName}, {productSlug}, {productSku}, {productPrice}, {productRegularPrice}, {productSalePrice}, {productStockStatus}<br>' .
                                                        '<b>Conditional Blocks:</b> {PRODUCT_START} ... {PRODUCT_END}, {NOT_PRODUCT_START} ... {NOT_PRODUCT_END}, {LOGGEDIN_START} ... {LOGGEDIN_END}, {NOT_LOGGEDIN_START} ... {NOT_LOGGEDIN_END}',
                                                    'chat-help'
                                                ),

                                                'dependency' => array('agent_type_of_whatsapp',   '==', 'number'),

                                            ),

                                            // changeing timezone
                                            array(
                                                'id' => 'agent-timezone',
                                                'type' => 'select',
                                                'title' => esc_html__('Timezone', 'chat-help'),
                                                'title_help' =>
                                                '<div class="chat-help-info-label">' .
                                                    esc_html__('Select the agent’s timezone. This ensures availability times are shown correctly, even if the user is in a different timezone.', 'chat-help') .
                                                    '</div>' .
                                                    ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/how-do-timezone-and-availability-work-in-whatsapp-chat-help/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                                'chosen' => true,
                                                'placeholder' => esc_html__('Select Timezone', 'chat-help'),
                                                'options' => $timezones,
                                            ),

                                            // Add availablity
                                            array(
                                                'id' => 'opt-availablity',
                                                'type' => 'tabbed',
                                                'title' => esc_html__('Availability', 'chat-help'),
                                                'title_help' =>
                                                '<div class="chat-help-info-label">' .
                                                    esc_html__('Set the agent’s available hours using 24-hour format (e.g., From 00:00 to 23:59). To mark a full day as unavailable, use 00:00 for both From and To values.', 'chat-help') .
                                                    '</div>' .
                                                    ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/how-do-timezone-and-availability-work-in-whatsapp-chat-help/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

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

                                            array(
                                                'id' => 'agent-online-text',
                                                'type' => 'text',
                                                'title' => esc_html__('Agent Online Text', 'chat-help'),
                                                'title_help' =>
                                                '<div class="chat-help-info-label">' .
                                                    esc_html__('Set the text that will be shown when the agent is available/online (e.g., “I am Online”).', 'chat-help') .
                                                    '</div>' .
                                                    ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'multi-agents-list/?ref=1"') . '">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                                    ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/multi-agent-list/#agent-settings') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                            ),

                                            array(
                                                'id' => 'agent-offline-text',
                                                'type' => 'text',
                                                'title' => esc_html__('Agent Offline Text', 'chat-help'),
                                                'title_help' =>
                                                '<div class="chat-help-info-label">' .
                                                    esc_html__('Set the text that will be shown when the agent is unavailable/offline (e.g., “I am Offline”).', 'chat-help') .
                                                    '</div>' .
                                                    ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'multi-agents-list/?ref=1"') . '">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                                    ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/multi-agent-list/#agent-settings') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                            ),
                                        ),
                                        'default' => array(
                                            array(
                                                'agent-name' => esc_html__('Sarah C. Patrick', 'chat-help'),
                                                'agent_type_of_whatsapp' => 'number',
                                                'agent-number' => esc_html__('+8801123456588', 'chat-help'),
                                                'agent-designation' => esc_html__('Technical support', 'chat-help'),
                                                'agent-online-text' => esc_html__('I am online', 'chat-help'),
                                                'agent-offline-text' => esc_html__('I am offline', 'chat-help'),
                                                'agent-photo' => [
                                                    "url" => CHAT_HELP_DIR_URL . 'src/assets/image/user.webp',
                                                ]
                                            ),
                                            array(
                                                'agent-name' => esc_html__('Patricia J. Hunt', 'chat-help'),
                                                'agent_type_of_whatsapp' => 'number',
                                                'agent-number' => esc_html__('+8801123456588', 'chat-help'),
                                                'agent-designation' => esc_html__('Marketing support', 'chat-help'),
                                                'agent-online-text' => esc_html__('I am online', 'chat-help'),
                                                'agent-offline-text' => esc_html__('I am offline', 'chat-help'),
                                                'agent-photo' => [
                                                    "url" => CHAT_HELP_DIR_URL . 'src/assets/image/agent1.webp',
                                                ]
                                            ),
                                            array(
                                                'agent-name' => esc_html__('Frederic M. Tune', 'chat-help'),
                                                'agent_type_of_whatsapp' => 'number',
                                                'agent-number' => esc_html__('+8801123456588', 'chat-help'),
                                                'agent-designation' => esc_html__('Sales support', 'chat-help'),
                                                'agent-online-text' => esc_html__('I am online', 'chat-help'),
                                                'agent-offline-text' => esc_html__('I am offline', 'chat-help'),
                                                'agent-photo' => [
                                                    "url" => CHAT_HELP_DIR_URL . 'src/assets/image/agent2.webp',
                                                ]
                                            ),
                                            array(
                                                'agent-name' => esc_html__('Douglas A. Smith', 'chat-help'),
                                                'agent_type_of_whatsapp' => 'number',
                                                'agent-number' => esc_html__('+8801123456588', 'chat-help'),
                                                'agent-designation' => esc_html__('Product manager', 'chat-help'),
                                                'agent-online-text' => esc_html__('I am online', 'chat-help'),
                                                'agent-offline-text' => esc_html__('I am offline', 'chat-help'),
                                                'agent-photo' => [
                                                    "url" => CHAT_HELP_DIR_URL . 'src/assets/image/agent3.webp',
                                                ]
                                            ),
                                            array(
                                                'agent-name' => esc_html__('Douglas A. Smith', 'chat-help'),
                                                'agent_type_of_whatsapp' => 'number',
                                                'agent-number' => esc_html__('+8801123456588', 'chat-help'),
                                                'agent-designation' => esc_html__('Support Manager', 'chat-help'),
                                                'agent-online-text' => esc_html__('I am online', 'chat-help'),
                                                'agent-offline-text' => esc_html__('I am offline', 'chat-help'),
                                                'agent-photo' => [
                                                    "url" => CHAT_HELP_DIR_URL . 'src/assets/image/agent4.webp',
                                                ]
                                            ),
                                            array(
                                                'agent-name' => esc_html__('Garland D. Homer', 'chat-help'),
                                                'agent_type_of_whatsapp' => 'number',
                                                'agent-number' => esc_html__('+8801123456588', 'chat-help'),
                                                'agent-designation' => esc_html__('Technical support', 'chat-help'),
                                                'agent-online-text' => esc_html__('I am online', 'chat-help'),
                                                'agent-offline-text' => esc_html__('I am offline', 'chat-help'),
                                                'agent-photo' => [
                                                    "url" => CHAT_HELP_DIR_URL . 'src/assets/image/agent1.webp',
                                                ]
                                            ),
                                        )
                                    ),
                                )
                            ),

                            array(
                                'title' => esc_html__('Header & Footer', 'chat-help'),
                                'icon' => 'icofont-layout',
                                'fields' => array(
                                    array(
                                        'id'    => 'box_header_title',
                                        'type'  => 'heading',
                                        'content' => esc_html__('Box Header', 'chat-help'),
                                        'dependency' => array('chat_layout', 'any', 'form,agent,multi,multi_grid', 'any'),
                                    ),
                                    // Agent photo type
                                    array(
                                        'id' => 'agent_photo_type',
                                        'type' => 'button_set',
                                        'title' => esc_html__('Agent Photo Type', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Choose how the agent photo is displayed:', 'chat-help') .
                                            '</div>' .
                                            ' <b>Default:</b> ' . esc_html__('Use the plugin’s built-in photo.', 'chat-help') . '<br>' .
                                            ' <b>Custom:</b> ' . esc_html__('Upload your own image.', 'chat-help') . '<br>' .
                                            ' <b>None:</b> ' . esc_html__('No photo will be shown.', 'chat-help') . '<br>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/8-header-and-footer/#header-footer-settings-single-form-single-agent">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'options' => array(
                                            'default'   =>  esc_html__('Default', 'chat-help'),
                                            'custom' => esc_html__('Custom', 'chat-help'),
                                            'none' => esc_html__('None', 'chat-help'),
                                        ),
                                        'default'   => 'default',
                                        'dependency' => array('chat_layout', 'any', 'form,agent', 'any'),
                                    ),

                                    // adding agent photo
                                    array(
                                        'id' => 'agent-photo',
                                        'type' => 'media',
                                        'title' => esc_html__('Agent Photo', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/user_image.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Upload an agent photo to display inside the chat bubble.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/8-header-and-footer/#header-footer-settings-single-form-single-agent">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'placeholder' => esc_html__('Upload or select an image from the media library.', 'chat-help'),

                                        'library' => 'image',
                                        'preview' => true,
                                        'dependency' => array('chat_layout|agent_photo_type', 'any|==', 'form,agent|custom', 'any'),
                                    ),

                                    // agent name
                                    array(
                                        'id' => 'agent-name',
                                        'type' => 'text',
                                        'title' => esc_html__('Agent Name', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/agent_name.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Enter the agent’s name to display inside the chat bubble.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/8-header-and-footer/#header-footer-settings-single-form-single-agent">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'default' => esc_html__('John Doe', 'chat-help'),
                                        'dependency' => array('chat_layout', 'any', 'form,agent', 'any'),
                                    ),

                                    // agent subtitle
                                    array(
                                        'id' => 'agent-subtitle',
                                        'type' => 'text',
                                        'title' => esc_html__('Subtitle', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/agent_subtitle.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Enter a subtitle to display below the agent’s name in the chat bubble.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/8-header-and-footer/#header-footer-settings-single-form-single-agent">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'default' => esc_html__('Typically replies within a day', 'chat-help'),

                                        'dependency' => array('chat_layout', 'any', 'form,agent', 'any'),
                                    ),

                                    // For Multi chat layout

                                    // Bubble title
                                    array(
                                        'id' => 'bubble-title',
                                        'type' => 'text',
                                        'title' => esc_html__('Bubble Title', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/bubble_title.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Enter the main title text to display at the top of the chat bubble.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . '8-header-and-footer/#header-footer-settings-multi-agent-list-grid">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'default' => esc_html__('Need Help? Send a WhatsApp message now', 'chat-help'),

                                        'dependency' => array('chat_layout', 'any', 'multi,multi_grid', 'any'),
                                    ),

                                    // Bubble subtitle
                                    array(
                                        'id' => 'bubble-subtitle',
                                        'type' => 'text',
                                        'title' => esc_html__('Bubble Subtitle', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/bubble_subtitle.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Enter a subtitle to display below the main title inside the chat bubble.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/8-header-and-footer/#header-footer-settings-multi-agent-list-grid">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'default' => esc_html__('Click one of our representatives below', 'chat-help'),

                                        'dependency' => array('chat_layout', 'any', 'multi,multi_grid', 'any'),
                                    ),
                                    // Header content position
                                    array(
                                        'id' => 'header-content-position',
                                        'type' => 'button_set',
                                        'title' => esc_html__('Bubble Header Content Position', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/header_left_center.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Choose the alignment for the header content.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/8-header-and-footer/#header-footer-settings-single-form-single-agent">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'default' => 'left',
                                        'options' => array(
                                            'left' => esc_html__('Left', 'chat-help'),
                                            'center' => esc_html__('Center', 'chat-help'),
                                        ),
                                        'dependency' => array('chat_layout', 'any', 'form,agent', 'any'),
                                    ),

                                    array(
                                        'id'    => 'box_footer_title',
                                        'type'  => 'heading',
                                        'content' => esc_html__('Box Footer', 'chat-help'),
                                        'dependency' => array('chat_layout', 'any', 'form,agent,multi,multi_grid', 'any'),
                                    ),

                                    // GDPR compliance checkbox
                                    array(
                                        'id' => 'gdpr-enable',
                                        'type' => 'switcher',
                                        'title' => esc_html__('GDPR Compliance', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/gdpr.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Enable a GDPR compliance checkbox for user consent before sending a message.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/how-does-gdpr-compliance-work-in-whatsapp-chat-help/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'text_on' => esc_html__('Enable', 'chat-help'),
                                        'text_off' => esc_html__('Disable', 'chat-help'),
                                        'text_width' => 100,
                                        'default' => false,
                                        'dependency' => array('chat_layout', 'any', 'form,agent,multi,multi_grid', 'any'),
                                    ),
                                    // GDPR compliance text
                                    array(
                                        'id' => 'gdpr-compliance-content',
                                        'type' => 'wp_editor',
                                        'title' => esc_html__('GDPR Compliance Message', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Customize the GDPR compliance text shown with the consent checkbox.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/how-does-gdpr-compliance-work-in-whatsapp-chat-help/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'default' => esc_attr__('Please accept our <a href="#">privacy policy</a> before starting a conversation.', 'chat-help'),

                                        'dependency' => array('chat_layout|gdpr-enable', '!=|==', 'button|true', 'any'),
                                    ),


                                    array(
                                        'id' => 'chat-button-loading-text',
                                        'type' => 'text',
                                        'title' => esc_html__('Loading Text', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/redirecting.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Enter the loading text shown while the message is being sent or redirecting.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/8-header-and-footer/#header-footer-settings-single-form-single-agent">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'default' => esc_html__('Redirecting...', 'chat-help'),

                                        'dependency' => array('chat_layout', 'any', 'form', 'any'),
                                    ),


                                    // before chat icon
                                    array(
                                        'id' => 'before-chat-icon',
                                        'type' => 'button_set',
                                        'title' => esc_html__('Icon for Send Message Button', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/send_message_icon.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Select an icon to display before the send message button text.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/8-header-and-footer/#header-footer-settings-single-form-single-agent">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'options' => array(
                                            'icofont-brand-whatsapp'    => array(
                                                'option_name' => '<i class="icofont-brand-whatsapp"></i>',
                                            ),
                                            'icofont-whatsapp'    => array(
                                                'option_name' => '<i class="icofont-whatsapp"></i>',
                                            ),
                                            'icofont-live-support'    => array(
                                                'option_name' => '<i class="icofont-live-support"></i>',
                                            ),
                                            'icofont-ui-messaging'    => array(
                                                'option_name' => '<i class="icofont-ui-messaging"></i>',
                                            ),
                                            'icofont-telegram'    => array(
                                                'option_name' => '<i class="icofont-telegram"></i>',
                                            ),
                                            'icofont-life-buoy'    => array(
                                                'option_name' => '<i class="icofont-life-buoy"></i>',
                                            ),
                                            'no_icon'    => array(
                                                'option_name' => esc_html__('No Icon', 'chat-help'),
                                            ),
                                            'native'    => array(
                                                'option_name' => esc_html__('Native', 'chat-help'),
                                                'pro_only'  => true,
                                            ),
                                            'custom'    => array(
                                                'option_name' => esc_html__('Custom', 'chat-help'),
                                                'pro_only'  => true,
                                            ),
                                        ),
                                        'default' => 'icofont-brand-whatsapp',
                                        'dependency' => array('chat_layout', 'any', 'form,agent', 'any'),
                                    ),

                                    array(
                                        'id' => 'before-chat-icon-native',
                                        'type' => 'icon',
                                        'title' => esc_html__('Send Message Native Icon', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Choose a native icon from the built-in library of 2000+ icons to display before the send message button text.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/8-header-and-footer/#header-footer-settings-single-form-single-agent">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'default' => 'icofont-brand-whatsapp',
                                        'dependency' => array('chat_layout|before-chat-icon', 'any|', 'form,agent|native', 'any'),
                                    ),
                                    array(
                                        'id' => 'before-chat-icon-custom',
                                        'type' => 'media',
                                        'title' => esc_html__('Send Message Custom Icon', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Upload or select a custom icon from your media library to display before the send message button text.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/8-header-and-footer/#header-footer-settings-single-form-single-agent">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'dependency' => array('chat_layout|before-chat-icon', 'any|==', 'form,agent|custom', 'any'),
                                    ),

                                    // agent message button text
                                    array(
                                        'id' => 'chat-button-text',
                                        'type' => 'text',
                                        'title' => esc_html__('Send Message Button Label', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/send_message_text.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Enter the text to display on the send message button.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/8-header-and-footer/#header-footer-settings-single-form-single-agent">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'default' => esc_html__('Send Message', 'chat-help'),

                                        'dependency' => array('chat_layout', 'any', 'form,agent', 'any'),
                                    ),

                                )
                            ),

                            array(
                                'title' => esc_html__('Button', 'chat-help'),
                                'icon' => 'icofont-scroll-double-right',
                                'fields' => array(
                                    array(
                                        'id' => 'opt-button-style',
                                        'type' => 'image_select',
                                        'title' => esc_html__('Floating Button Style', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Choose a style for the floating chat button from the available design options.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'simple-button/">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',

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
                                        'dependency' => array('chat_layout', '!=', 'advance_button', 'any'),
                                    ),

                                    // Button text
                                    array(
                                        'id' => 'bubble-text',
                                        'type' => 'text',
                                        'title' => esc_html__('Button Label', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/button_text.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Enter the text to display inside the floating chat button.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'simple-button/">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-single-form-single-agent-simple-button-multi-agent-list-multi-agent-grid">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'default' => esc_html__('How may I help you?', 'chat-help'),

                                        'dependency' => array('opt-button-style|chat_layout', '!=|!=', '1|advance_button', 'any'),
                                    ),

                                    // Show hide icon
                                    array(
                                        'id' => 'disable-button-icon',
                                        'type' => 'switcher',
                                        'title' => esc_html__('Show/Hide Icon', 'chat-help'),
                                        'text_on' => esc_html__('Show', 'chat-help'),
                                        'text_off' => esc_html__('Hide', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Toggle whether to display an icon inside the floating chat button.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'simple-button/">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-single-form-single-agent-simple-button-multi-agent-list-multi-agent-grid">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'default' => true,
                                        'text_width' => 80,
                                        'dependency' => array('opt-button-style|chat_layout', '!=|!=', '1|advance_button', 'any'),
                                    ),

                                    // Circle button icon
                                    array(
                                        'id' => 'circle-button-icon-1',
                                        'type' => 'button_set',
                                        'title' => esc_html__('Icon for Circle Button', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/circle_icon.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Select an icon to display inside the circular chat button.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'simple-button/">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-single-form-single-agent-simple-button-multi-agent-list-multi-agent-grid">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'options' => array(
                                            'icofont-brand-whatsapp'    => array(
                                                'option_name' => '<i class="icofont-brand-whatsapp"></i>',
                                            ),
                                            'icofont-whatsapp'    => array(
                                                'option_name' => '<i class="icofont-whatsapp"></i>',
                                            ),
                                            'icofont-live-support'    => array(
                                                'option_name' => '<i class="icofont-live-support"></i>',
                                            ),
                                            'icofont-ui-messaging'    => array(
                                                'option_name' => '<i class="icofont-ui-messaging"></i>',
                                            ),
                                            'icofont-telegram'    => array(
                                                'option_name' => '<i class="icofont-telegram"></i>',
                                            ),
                                            'icofont-life-buoy'    => array(
                                                'option_name' => '<i class="icofont-life-buoy"></i>',
                                            ),
                                            'native'    => array(
                                                'option_name' => esc_html__('Native', 'chat-help'),
                                                'pro_only'  => true,
                                            ),
                                            'custom'    => array(
                                                'option_name' => esc_html__('Custom', 'chat-help'),
                                                'pro_only'  => true,
                                            ),
                                        ),
                                        'default' => 'icofont-brand-whatsapp',
                                        'dependency' => array('opt-button-style|chat_layout', '==|!=', '1|advance_button', 'any'),
                                    ),

                                    // Circle button icon
                                    array(
                                        'id' => 'circle-button-icon-native',
                                        'type' => 'icon',
                                        'title' => esc_html__('Circle Button Native Icon', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Choose a native icon from the built-in library of 2000+ icons to display inside the circular chat button.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'simple-button/">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-single-form-single-agent-simple-button-multi-agent-list-multi-agent-grid">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'default' => 'icofont-brand-whatsapp',
                                        'dependency' => array('opt-button-style|chat_layout|circle-button-icon-1', '==|!=|==', '1|advance_button|native', 'any'),
                                    ),
                                    array(
                                        'id' => 'circle-button-icon-custom',
                                        'type' => 'media',
                                        'title' => esc_html__('Circle Button Custom Icon', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Upload or select a custom icon from your media library to display inside the circular chat button.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'simple-button/">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-single-form-single-agent-simple-button-multi-agent-list-multi-agent-grid">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'dependency' => array('opt-button-style|chat_layout|circle-button-icon-1', '==|!=|==', '1|advance_button|custom', 'any'),
                                    ),

                                    // Circle button icon close
                                    array(
                                        'id' => 'circle-button-close-1',
                                        'type' => 'button_set',
                                        'title' => esc_html__('Icon for Circle Button Close', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Select the icon to display when the circular chat button is in the close state.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'simple-button/">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-single-form-single-agent-simple-button-multi-agent-list-multi-agent-grid">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'options' => array(
                                            'icofont-close'    => array(
                                                'option_name' => '<i class="icofont-close"></i>',
                                            ),
                                            'icofont-close-line'    => array(
                                                'option_name' => '<i class="icofont-close-line"></i>',
                                            ),
                                            'icofont-close-circled'    => array(
                                                'option_name' => '<i class="icofont-close-circled"></i>',
                                            ),
                                            'icofont-ui-close'    => array(
                                                'option_name' => '<i class="icofont-ui-close"></i>',
                                            ),
                                            'icofont-close-squared-alt'    => array(
                                                'option_name' => '<i class="icofont-close-squared-alt"></i>',
                                            ),
                                            'native'    => array(
                                                'option_name' => esc_html__('Native', 'chat-help'),
                                                'pro_only'  => true,
                                            ),
                                            'custom'    => array(
                                                'option_name' => esc_html__('Custom', 'chat-help'),
                                                'pro_only'  => true,
                                            ),
                                        ),
                                        'default' => 'icofont-close',
                                        'dependency' => array('opt-button-style|chat_layout', '==|!=', '1|advance_button', 'any'),
                                    ),

                                    array(
                                        'id' => 'circle-button-close-native',
                                        'type' => 'icon',
                                        'title' => esc_html__('Circle Button Native Close Icon', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Choose a native icon from the built-in library to display when the circular chat button is in the close state.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'simple-button/">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-single-form-single-agent-simple-button-multi-agent-list-multi-agent-grid">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'default' => 'icofont-close',
                                        'dependency' => array('opt-button-style|chat_layout|circle-button-close-1', '==|!=|==', '1|advance_button|native', 'any'),
                                    ),
                                    array(
                                        'id' => 'circle-button-close-custom',
                                        'type' => 'media',
                                        'title' => esc_html__('Circle Button Custom Close Icon', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Upload or select a custom icon from your media library to display when the circular chat button is in the close state.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'simple-button/">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-single-form-single-agent-simple-button-multi-agent-list-multi-agent-grid">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'dependency' => array('opt-button-style|chat_layout|circle-button-close-1', '==|!=|==', '1|advance_button|custom', 'any'),
                                    ),

                                    // Circle button icon
                                    array(
                                        'id' => 'circle-button-icon',
                                        'type' => 'button_set',
                                        'title' => esc_html__('Icon for Button', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/button_icon.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Select an icon to display inside the floating chat button.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'simple-button/">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-single-form-single-agent-simple-button-multi-agent-list-multi-agent-grid">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'options' => array(
                                            'icofont-brand-whatsapp'    => array(
                                                'option_name' => '<i class="icofont-brand-whatsapp"></i>',
                                            ),
                                            'icofont-whatsapp'    => array(
                                                'option_name' => '<i class="icofont-whatsapp"></i>',
                                            ),
                                            'icofont-live-support'    => array(
                                                'option_name' => '<i class="icofont-live-support"></i>',
                                            ),
                                            'icofont-ui-messaging'    => array(
                                                'option_name' => '<i class="icofont-ui-messaging"></i>',
                                            ),
                                            'icofont-telegram'    => array(
                                                'option_name' => '<i class="icofont-telegram"></i>',
                                            ),
                                            'icofont-life-buoy'    => array(
                                                'option_name' => '<i class="icofont-life-buoy"></i>',
                                            ),
                                            'native'    => array(
                                                'option_name' => esc_html__('Native', 'chat-help'),
                                                'pro_only'  => true,
                                            ),
                                            'custom'    => array(
                                                'option_name' => esc_html__('Custom', 'chat-help'),
                                                'pro_only'  => true,
                                            ),
                                        ),
                                        'default' => 'icofont-brand-whatsapp',
                                        'dependency' => array('disable-button-icon|opt-button-style|chat_layout', '==|!=|!=', 'true|1|advance_button', 'any'),
                                    ),

                                    array(
                                        'id' => 'button-icon-native',
                                        'type' => 'icon',
                                        'title' => esc_html__('Button Native Icon', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Choose a native icon from the built-in library of 2000+ icons to display inside the floating chat button.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'simple-button/">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-single-form-single-agent-simple-button-multi-agent-list-multi-agent-grid">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'default' => 'icofont-brand-whatsapp',
                                        'dependency' => array('disable-button-icon|opt-button-style|chat_layout|circle-button-icon', '==|!=|!=', 'true|1|advance_button|native', 'any'),
                                    ),
                                    array(
                                        'id' => 'button-icon-custom',
                                        'type' => 'media',
                                        'title' => esc_html__('Button Custom Icon', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Upload or select a custom icon from your media library to display inside the floating chat button.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-single-form-single-agent-simple-button-multi-agent-list-multi-agent-grid">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'dependency' => array('disable-button-icon|opt-button-style|chat_layout|circle-button-icon', '==|!=|!=|==', 'true|1|advance_button|custom', 'any'),
                                    ),

                                    // Circle button icon close
                                    array(
                                        'id' => 'circle-button-close',
                                        'type' => 'button_set',
                                        'title' => esc_html__('Icon for Button Close', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/button_icon_close.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Select the icon to display when the floating chat button is in the close state.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-single-form-single-agent-simple-button-multi-agent-list-multi-agent-grid">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'options' => array(
                                            'icofont-close'    => array(
                                                'option_name' => '<i class="icofont-close"></i>',
                                            ),
                                            'icofont-close-line'    => array(
                                                'option_name' => '<i class="icofont-close-line"></i>',
                                            ),
                                            'icofont-close-circled'    => array(
                                                'option_name' => '<i class="icofont-close-circled"></i>',
                                            ),
                                            'icofont-ui-close'    => array(
                                                'option_name' => '<i class="icofont-ui-close"></i>',
                                            ),
                                            'icofont-close-squared-alt'    => array(
                                                'option_name' => '<i class="icofont-close-squared-alt"></i>',
                                            ),
                                            'native'    => array(
                                                'option_name' => esc_html__('Native', 'chat-help'),
                                                'pro_only'  => true,
                                            ),
                                            'custom'    => array(
                                                'option_name' => esc_html__('Custom', 'chat-help'),
                                                'pro_only'  => true,
                                            ),
                                        ),
                                        'default' => 'icofont-close',
                                        'dependency' => array('disable-button-icon|opt-button-style|chat_layout', '==|!=|!=', 'true|1|advance_button', 'any'),
                                    ),
                                    array(
                                        'id' => 'button-close-native',
                                        'type' => 'icon',
                                        'title' => esc_html__('Button Native Close Icon', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Choose a native icon from the built-in library to display when the floating chat button is in the close state.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-single-form-single-agent-simple-button-multi-agent-list-multi-agent-grid">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'default' => 'icofont-close',
                                        'dependency' => array('disable-button-icon|opt-button-style|chat_layout|circle-button-close', '==|!=|!=|==', 'true|1|advance_button|native', 'any'),
                                    ),
                                    array(
                                        'id' => 'button-close-custom',
                                        'type' => 'media',
                                        'title' => esc_html__('Button Custom Close Icon', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Upload or select a custom icon from your media library to display when the floating chat button is in the close state.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-single-form-single-agent-simple-button-multi-agent-list-multi-agent-grid">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'dependency' => array('disable-button-icon|opt-button-style|chat_layout|circle-button-close', '==|!=|!=|==', 'true|1|advance_button|custom', 'any'),
                                    ),

                                    // changeing circle animations
                                    array(
                                        'id' => 'circle-animation',
                                        'type' => 'select',
                                        'title' => esc_html__('Transition Effect for Circle Icon', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Select the animation effect used when toggling the circular chat button between open and close states.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-single-form-single-agent-simple-button-multi-agent-list-multi-agent-grid">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'options' => array(
                                            '1' => esc_html__('Slide Down', 'chat-help'),
                                            '3' => esc_html__('Fade', 'chat-help'),
                                            '2' => esc_html__('Rotate (Pro)', 'chat-help'),
                                            '4' => esc_html__('Slide Up (Pro)', 'chat-help'),
                                        ),

                                        'default' => '1',
                                        'dependency' => array('chat_layout', 'any', 'form,agent,multi,multi_grid', 'any'),
                                    ),

                                    // Button padding
                                    array(
                                        'id' => 'bubble-button-padding',
                                        'type' => 'spacing',
                                        'title' => esc_html__('Button Padding', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Adjust the inner spacing (padding) of the floating chat button.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-single-form-single-agent-simple-button-multi-agent-list-multi-agent-grid">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'output'    => '.bubble',
                                        'default' => array(
                                            'top' => '5',
                                            'right' => '15',
                                            'bottom' => '5',
                                            'left' => '15',
                                            'unit' => 'px',
                                        ),
                                        'dependency' => array('opt-button-style|chat_layout', '!=|!=', '1|advance_button', 'any'),
                                    ),
                                    array(
                                        'id' => 'bubble_button_tooltip',
                                        'type' => 'button_set',
                                        'title' => esc_html__('Button Tooltip', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/tooltip.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Enable and customize the tooltip text that appears when hovering over the floating chat button.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-agent/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-single-form-single-agent-simple-button-multi-agent-list-multi-agent-grid">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'options' => array(
                                            'on_hover' => esc_html__('On Hover', 'chat-help'),
                                            'show' => esc_html__('Show', 'chat-help'),
                                            'hide' => esc_html__('Hide', 'chat-help'),
                                        ),
                                        'default' => 'on_hover',
                                        'dependency' => array('chat_layout', '!=', 'advance_button', 'any'),
                                    ),
                                    array(
                                        'id' => 'bubble_button_tooltip_text',
                                        'type' => 'text',
                                        'title' => esc_html__('Button Tooltip Text', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/tooltip.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Enter the text that will appear inside the tooltip when hovering over the floating chat button.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-agent/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-single-form-single-agent-simple-button-multi-agent-list-multi-agent-grid">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'default' => esc_html__('Need Help? Chat with us', 'chat-help'),

                                        'dependency' => array('bubble_button_tooltip|chat_layout', '!=|!=', 'hide|advance_button', 'any'),
                                    ),
                                    array(
                                        'id' => 'bubble_button_tooltip_background',
                                        'type' => 'color',
                                        'title' => esc_html__('Button Tooltip Background', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Choose the background color for the tooltip that appears when hovering over the floating chat button.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-agent/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-single-form-single-agent-simple-button-multi-agent-list-multi-agent-grid">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'default' => '#f5f7f9',
                                        'dependency' => array('bubble_button_tooltip|chat_layout', '!=|!=', 'hide|advance_button', 'any'),
                                    ),
                                    array(
                                        'id' => 'bubble_button_tooltip_width',
                                        'type' => 'slider',
                                        'title' => esc_html__('Button Tooltip Width', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/tooltip_width.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Set the maximum width of the tooltip that appears when hovering over the floating chat button.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-agent/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-single-form-single-agent-simple-button-multi-agent-list-multi-agent-grid">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'min' => 20,
                                        'max' => 500,
                                        'step' => 5,
                                        'unit' => 'px',
                                        'default' => 180,
                                        'dependency' => array('bubble_button_tooltip|chat_layout', '!=|!=', 'hide|advance_button', 'any'),
                                    ),
                                    array(
                                        'id' => 'advance_button_style',
                                        'type' => 'image_select',
                                        'title' => esc_html__('Advanced Button Style', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Select a style for the advanced chat button layout. Choose between filled or outlined button designs.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'advance-button/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-advanced-button-layout">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'options' => array(
                                            '1' => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/advance-filled.svg',
                                            '2' => CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/advance-outline.svg',
                                        ),

                                        'default' => '1',
                                        'dependency' => array('chat_layout', '==', 'advance_button', 'any'),
                                    ),
                                    // Button agent photo
                                    array(
                                        'id' => 'button_agent_photo',
                                        'type' => 'media',
                                        'title' => esc_html__('Button Agent Photo', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/button_agent_photo.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Upload an agent photo to display inside the floating chat button.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'advance-button/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=#button-advanced-button-layout">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'library' => 'image',
                                        'placeholder' => CHAT_HELP_DIR_URL . 'src/assets/image/user.webp',
                                        'preview' => true,
                                        'dependency' => array('chat_layout', 'any', 'advance_button', 'any'),
                                        'default' => [
                                            'url' => CHAT_HELP_DIR_URL . 'src/assets/image/user.webp',
                                        ],
                                    ),

                                    // Button agent name
                                    array(
                                        'id' => 'button_agent_name',
                                        'type' => 'text',
                                        'title' => esc_html__('Button Agent Name', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/button_agent_name.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Enter the agent name to display inside the floating chat button.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'advance-button/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-advanced-button-layout">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'default' => esc_html__('John Doe', 'chat-help'),
                                        'dependency' => array('chat_layout', 'any', 'advance_button', 'any'),
                                    ),

                                    // Button agent designation
                                    array(
                                        'id' => 'button_agent_designation',
                                        'type' => 'text',
                                        'title' => esc_html__('Button Agent Designation', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/designation.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Enter the agent’s designation or role to display below the agent name inside the floating chat button.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'advance-button/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-advanced-button-layout">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'default' => esc_html__('Sales Support', 'chat-help'),
                                        'dependency' => array('chat_layout', 'any', 'advance_button', 'any'),
                                    ),
                                    // Button label
                                    array(
                                        'id' => 'button_label',
                                        'type' => 'text',
                                        'title' => esc_html__('Button Label', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/advance_button_text.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Enter the text label to display inside the advanced chat button.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'advance-button/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-advanced-button-layout">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'default' => esc_html__('How Can I Help You?', 'chat-help'),

                                        'dependency' => array('chat_layout', 'any', 'advance_button', 'any'),
                                    ),
                                    // Online Text
                                    array(
                                        'id' => 'online_text',
                                        'type' => 'text',
                                        'title' => esc_html__('Online Text', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/i_am_on.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Set the text to display when the agent is online and available for chat.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'advance-button/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-advanced-button-layout">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'default' => esc_html__('I Am Online', 'chat-help'),

                                        'dependency' => array('chat_layout', 'any', 'advance_button', 'any'),
                                    ),
                                    // Ofline Text
                                    array(
                                        'id' => 'offline_text',
                                        'type' => 'text',
                                        'title' => esc_html__('Offline Text', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/i_am_of.png') . '" alt=""></div>' .
                                            '<div class="chat-help-info-label">' .
                                            esc_html__('Set the text to display when the agent is offline or unavailable for chat.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'advance-button/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-advanced-button-layout">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'default' => esc_html__('I Am Offline', 'chat-help'),

                                        'dependency' => array('chat_layout', 'any', 'advance_button', 'any'),
                                    ),
                                    array(
                                        'id' => 'advance_button_padding',
                                        'type' => 'spacing',
                                        'title' => esc_html__('Advanced Button Padding', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Adjust the inner spacing (padding) of the advanced chat button for better alignment and appearance.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'advance-button/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-advanced-button-layout">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'default'  => array(
                                            'top'    => '7',
                                            'right'  => '12',
                                            'bottom' => '7',
                                            'left'   => '12',
                                            'unit'   => 'px',
                                        ),
                                        'dependency' => array('chat_layout', 'any', 'advance_button', 'any'),
                                    ),

                                    array(
                                        'id'    => 'heading',
                                        'type'  => 'heading',
                                        'content' => esc_html__('Positioning', 'chat-help'),
                                    ),
                                    array(
                                        'id'      => 'bubble-position',
                                        'type'    => 'button_set',
                                        'title' => esc_html__('Bubble Position', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Select the screen position where the floating chat button will appear.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'advance-button/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-advanced-button-layout">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'options' => array(
                                            'right_bottom' => array(
                                                'text'  => esc_html__('Bottom Right', 'chat-help'),
                                            ),
                                            'left_bottom'  => array(
                                                'text'  => esc_html__('Bottom Left', 'chat-help'),
                                            ),
                                            'right_middle' => array(
                                                'text'  => esc_html__('Middle Right', 'chat-help'),
                                                'pro_only'  => true,
                                            ),
                                            'left_middle'  => array(
                                                'text'  => esc_html__('Middle Left', 'chat-help'),
                                                'pro_only'  => true,
                                            )
                                        ),

                                        'default' => 'right_bottom',
                                    ),

                                    array(
                                        'id'    => 'right_bottom',
                                        'type'  => 'spacing',
                                        'title' => esc_html__('Margin from Bottom Right', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Set the margin (spacing) of the floating chat button from the bottom and right edges of the screen. Adjust to reposition the button as needed.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'advance-button/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-advanced-button-layout">' . esc_html__('Open Docs', 'chat-help') . '</a>',

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
                                        'title' => esc_html__('Margin from Bottom Left', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Set the margin (spacing) of the floating chat button from the bottom and left edges of the screen. Adjust to reposition the button as needed.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'advance-button/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-advanced-button-layout">' . esc_html__('Open Docs', 'chat-help') . '</a>',

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
                                        'title' => esc_html__('Margin from Middle Right', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Set the margin (spacing) of the floating chat button from the right edge of the screen when positioned in the middle. Adjust to fine-tune its placement.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'advance-button/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-advanced-button-layout">' . esc_html__('Open Docs', 'chat-help') . '</a>',

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
                                        'title' => esc_html__('Margin from Middle Left', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Set the margin (spacing) of the floating chat button from the left edge of the screen when positioned in the middle. Adjust to fine-tune its placement.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'advance-button/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-advanced-button-layout">' . esc_html__('Open Docs', 'chat-help') . '</a>',

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
                                        'id'    => 'enable-positioning-tablet',
                                        'type'  => 'switcher',
                                        'class' => 'switcher_pro_only',
                                        'title' => esc_html__('Different Positioning for Tablet Devices', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Enable this option to set a custom bubble position specifically for tablet devices. Useful for optimizing layout and user experience on medium screens.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'advance-button/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-advanced-button-layout">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'text_on' => esc_html__('Yes', 'chat-help'),
                                        'text_off'  => esc_html__('No', 'chat-help'),
                                        'dependency' => array('bubble-visibility', '==', 'everywhere', 'any'),
                                    ),
                                    array(
                                        'id'    => 'enable-positioning-mobile',
                                        'type'  => 'switcher',
                                        'class' => 'switcher_pro_only',
                                        'title' => esc_html__('Different Positioning for Mobile Devices', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Enable this option to set a custom chat bubble position specifically for mobile devices. Useful for optimizing layout and usability on smaller screens.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'advance-button/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/?ref=1#button-advanced-button-layout">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'text_on' => esc_html__('Yes', 'chat-help'),
                                        'text_off'  => esc_html__('No', 'chat-help'),
                                        'dependency'    => array('bubble-visibility', '==', 'everywhere', 'any')
                                    ),
                                )
                            ),

                            array(
                                'title' => esc_html__('Style', 'chat-help'),
                                'icon' => 'icofont-paint',
                                'fields' => array(
                                    // Autometically show popup
                                    array(
                                        'id'        => 'autoshow-popup',
                                        'type'      => 'switcher',
                                        'title' => esc_html__('Auto Open Popup', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Enable this option to automatically open the chat popup when the page loads. Useful for drawing visitor attention without requiring a click.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/10-style/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'text_on' => esc_html__('Yes', 'chat-help'),
                                        'text_off'  => esc_html__('No', 'chat-help'),
                                        'default'   => false,
                                        'dependency' => array('chat_layout', 'any', 'form,agent,multi,multi_grid', 'any'),
                                    ),

                                    // Auto open popup timeout
                                    array(
                                        'id' => 'auto_open_popup_timeout',
                                        'type' => 'slider',
                                        'title' => esc_html__('Auto Open Popup Timeout', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Set the delay (in seconds) before the chat popup automatically opens after the page loads.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/10-style/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                        'min' => 0,
                                        'max' => 30000,
                                        'step' => 100,
                                        'default' => 0,
                                        'dependency' => array('autoshow-popup|chat_layout', '==|any', 'true|form,agent,multi,multi_grid', 'any'),
                                        'unit'       => __('ms', 'chat-help'),
                                    ),

                                    // changeing bubble animations
                                    array(
                                        'id'    => 'select-animation',
                                        'type'  => 'select',
                                        'title' => esc_html__('Select Animation for Bubble', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Choose an animation style for how the chat bubble appears on the screen. You can pick a specific effect or select "Random" to apply a different animation each time.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-agent/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/10-style/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'options' => array(
                                            '14'      => esc_html__('Fade', 'chat-help'),
                                            '1'      => esc_html__('Fade Right', 'chat-help'),
                                            '2'      => esc_html__('Fade Down (Pro)', 'chat-help'),
                                            '3'      => esc_html__('Ease Down (Pro)', 'chat-help'),
                                            '4'      => esc_html__('Fade In Scale (Pro)', 'chat-help'),
                                            '5'      => esc_html__('Rotation (Pro)', 'chat-help'),
                                            '6'      => esc_html__('Slide Fall (Pro)', 'chat-help'),
                                            '7'      => esc_html__('Slide Down (Pro)', 'chat-help'),
                                            '8'      => esc_html__('Rotate Left (Pro)', 'chat-help'),
                                            '9'      => esc_html__('Flip Horizontal (Pro)', 'chat-help'),
                                            '10'     => esc_html__('Flip Vertical (Pro)', 'chat-help'),
                                            '11'     => esc_html__('Flip Up (Pro)', 'chat-help'),
                                            '12'     => esc_html__('Super Scaled (Pro)', 'chat-help'),
                                            '13'     => esc_html__('Slide Up (Pro)', 'chat-help'),
                                            'random' => esc_html__('Random (Pro)', 'chat-help'),
                                        ),
                                        'default'     => '14',
                                        'dependency' => array('chat_layout', 'any', 'form,agent,multi,multi_grid', 'any'),
                                    ),

                                    // Header content position
                                    array(
                                        'id'      => 'bubble-style',
                                        'type'    => 'button_set',
                                        'title' => esc_html__('Select Bubble Layout Mode', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Choose a color mode for the chat bubble. This controls the overall appearance and theme style of the bubble.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-agent/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/10-style/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'options' => array(
                                            'default' => array(
                                                'text'  => esc_html__('Light Mode', 'chat-help'),
                                            ),
                                            'dark'    => array(
                                                'text'  => esc_html__('Dark Mode', 'chat-help'),
                                                'pro_only'  => true,
                                            ),
                                            'night'   => array(
                                                'text'  => esc_html__('Night Mode', 'chat-help'),
                                                'pro_only'  => true,
                                            ),
                                        ),

                                        'default' => 'default',
                                        'dependency' => array('chat_layout', 'any', 'form,agent,multi,multi_grid', 'any'),
                                    ),
                                    array(
                                        'id'      => 'alternative_wHelpBubble',
                                        'type'    => 'text',
                                        'title' => esc_html__('Custom Bubble Trigger', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Add custom CSS selectors (e.g., .classname, #idname) that can also act as triggers to open the chat bubble. Useful when you want other elements on your site to open the chat besides the default button.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/10-style/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'placeholder' => esc_html__('.classname, #idname', 'chat-help'),
                                        'dependency' => array('chat_layout', 'any', 'form,agent,multi,multi_grid', 'any'),

                                    ),
                                    array(
                                        'id'        => 'color_settings',
                                        'type'      => 'color_group',
                                        'title' => esc_html__('Color Settings', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-img-tag">' .
                                            '<img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/Framework/assets/images/preview/brand_color.png') . '" alt="' . esc_html__('Preview Image', 'chat-help') . '">' .
                                            '</div> 
                                            <div class="chat-help-info-label">' .
                                            esc_html__('Set your brand colors for the chat bubble. Adjust the Primary and Secondary colors to match your site style.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form/">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                                            ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/10-style/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'options' => array(
                                            'primary'   => esc_html__('Primary', 'chat-help'),
                                            'secondary' => esc_html__('Secondary', 'chat-help'),
                                        ),

                                        'default'   => array(
                                            'primary' => '#118c7e',
                                            'secondary' => '#0b5a51',
                                        ),
                                    ),

                                    array(
                                        'id'       => 'chat_help_typography',
                                        'type'     => 'typography',
                                        'title' => esc_html__('Typography', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Select the font family and weight for your chat bubble text. Adjust these options to keep the widget consistent with your site’s typography.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/10-style/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'font_size' => false,
                                        'line_height' => false,
                                        'font_style' => false,
                                        'letter_spacing' => false,
                                        'text_align' => false,
                                        'text_transform' => false,
                                        'text_color' => false,
                                        'color' => false,
                                        'subset' => false,
                                        'output'  => '.wHelp,.wHelp-multi,.wHelp-multi input, .advance_button, .wHelp__popup__content input, .wHelp__popup__content textarea',
                                    ),
                                )
                            ),

                            array(
                                'title'  => esc_html__('Others', 'chat-help'),
                                'icon'   => 'icofont-settings',
                                'fields' => array(
                                    // Visiblity
                                    array(
                                        'id'    => 'heading',
                                        'type'  => 'heading',
                                        'content' => esc_html__('Visiblity', 'chat-help'),
                                    ),
                                    // device visibility
                                    array(
                                        'id'      => 'bubble-visibility',
                                        'type'    => 'button_set',
                                        'title' => esc_html__('Device Visibility', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            '<b>' . esc_html__('Everywhere:', 'chat-help') . '</b> ' . esc_html__('Visible on all devices.', 'chat-help') . '<br />' .
                                            '<b>' . esc_html__('Desktop Only:', 'chat-help') . '</b> ' . esc_html__('Visible on devices wider than 991px.', 'chat-help') . '<br />' .
                                            '<b>' . esc_html__('Tablet Only:', 'chat-help') . '</b> ' . esc_html__('Visible on devices between 576px and 991px.', 'chat-help') . '<br />' .
                                            '<b>' . esc_html__('Mobile Only:', 'chat-help') . '</b> ' . esc_html__('Visible on devices smaller than 576px.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'options' => array(
                                            'everywhere' => esc_html__('Everywhere', 'chat-help'),
                                            'desktop'    => esc_html__('Desktop Only', 'chat-help'),
                                            'tablet'     => esc_html__('Tablet Only', 'chat-help'),
                                            'mobile'     => esc_html__('Mobile Only', 'chat-help'),
                                        ),

                                        'default' => 'everywhere',
                                    ),
                                    // pages visibility
                                    array(
                                        'id'       => 'visibility',
                                        'type'     => 'checkbox',
                                        'class'    => 'chat_help_column_2 visibility',
                                        'title' => esc_html__('Visibility By', 'chat-help'),
                                        'title_help' =>
                                        '<div class="chat-help-info-label">' .
                                            esc_html__('Select where the chat bubble should be visible. You can enable it by specific content types such as pages, posts, products, categories, or tags.', 'chat-help') .
                                            '</div>' .
                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                        'options' => array(
                                            'theme_page'       => esc_html__('Theme Pages', 'chat-help'),
                                            'page'             => esc_html__('Pages', 'chat-help'),
                                            'posts'            => esc_html__('Posts (Pro)', 'chat-help'),
                                            'product'          => esc_html__('Products (Pro)', 'chat-help'),
                                            'category'         => esc_html__('Post Categories (Pro)', 'chat-help'),
                                            'tags'             => esc_html__('Post Tags (Pro)', 'chat-help'),
                                            'product_category' => esc_html__('Product Categories (Pro)', 'chat-help'),
                                            'product_tags'     => esc_html__('Product Tags (Pro)', 'chat-help'),
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
                                                'fields'    => array(
                                                    array(
                                                        'id'    => 'theme_page_target',
                                                        'type'  => 'select',
                                                        'title' => esc_html__('Target', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Choose whether to show (Include) or hide (Exclude) the chat bubble on the selected items.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                        'options' => array(
                                                            'include' => esc_html__('Include', 'chat-help'),
                                                            'exclude' => esc_html__('Exclude', 'chat-help'),
                                                        ),

                                                    ),
                                                    array(
                                                        'id'    => 'theme_page_all',
                                                        'type'  => 'checkbox',
                                                        'title' => esc_html__('All Theme Pages', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Enable this option to apply the chat bubble visibility rule to all theme pages at once, instead of selecting them individually.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                    ),
                                                    // Include specific
                                                    array(
                                                        'id'      => 'theme_page',
                                                        'type'  => 'select',
                                                        'title' => esc_html__('Theme Pages', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Select a specific theme page where the chat bubble visibility rule should apply. Options include Blog, 404, or Search pages.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                        'options' => array(
                                                            'post_page'   => esc_html__('Blog Page', 'chat-help'),
                                                            '404_page'    => esc_html__('404 Page', 'chat-help'),
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
                                                'fields'    => array(
                                                    array(
                                                        'id'    => 'page_target',
                                                        'type'  => 'select',
                                                        'title' => esc_html__('Target', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Choose whether to show (Include) or hide (Exclude) the chat bubble on the selected pages.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                        'options' => array(
                                                            'include' => esc_html__('Include', 'chat-help'),
                                                            'exclude' => esc_html__('Exclude', 'chat-help'),
                                                        ),

                                                    ),
                                                    array(
                                                        'id'    => 'page_all',
                                                        'type'  => 'checkbox',
                                                        'title' => esc_html__('All Pages', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Enable this option to apply the chat bubble visibility rule to all pages across your site, instead of selecting individual pages.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                    ),
                                                    // Include specific
                                                    array(
                                                        'id'    => 'page',
                                                        'type'  => 'select',
                                                        'title' => esc_html__('Pages', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Select one or more specific pages where the chat bubble visibility rule should apply.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                        'options' => 'pages',

                                                        'query_args'  => array(
                                                            'posts_per_page' => -1,
                                                        ),
                                                        'chosen'      => true,
                                                        'multiple'     => true,
                                                        'sortable'    => false,
                                                        'empty_message'    => esc_html__('You don\'t have any pages available.', 'chat-help'),
                                                        'dependency'    => array('page_all', '!=', 'true', 'any'),
                                                    ),
                                                )
                                            ),
                                        )
                                    ),
                                    array(
                                        'id'            => 'visibility_by_posts',
                                        'type'          => 'accordion',
                                        'class'         => 'padding-t-0',
                                        'dependency'    => array('visibility', 'any', 'posts', 'any'),
                                        'accordions'    => array(
                                            array(
                                                'title'     => esc_html__('Posts', 'chat-help'),
                                                'fields'    => array(
                                                    array(
                                                        'id'    => 'posts_target',
                                                        'type'  => 'select',
                                                        'title' => esc_html__('Target', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Choose whether to show (Include) or hide (Exclude) the chat bubble on the selected posts.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                        'options' => array(
                                                            'include' => esc_html__('Include', 'chat-help'),
                                                            'exclude' => esc_html__('Exclude', 'chat-help'),
                                                        ),

                                                    ),
                                                    array(
                                                        'id'    => 'posts_all',
                                                        'type'  => 'checkbox',
                                                        'title' => esc_html__('All Posts', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Enable this option to apply the chat bubble visibility rule to all posts across your site, instead of selecting them individually.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                    ),
                                                    // Include specific
                                                    array(
                                                        'id'    => 'posts',
                                                        'type'  => 'select',
                                                        'title' => esc_html__('Posts', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Select one or more specific posts where the chat bubble visibility rule should apply.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                        'options'    => 'posts',
                                                        'query_args'  => array(
                                                            'posts_per_page' => -1,
                                                        ),
                                                        'chosen'      => true,
                                                        'multiple'     => true,
                                                        'sortable'    => true,
                                                        'empty_message'    => esc_html__('You don\'t have any posts available.', 'chat-help'),
                                                        'dependency'    => array('posts_all', '!=', 'true', 'any'),
                                                    ),
                                                )
                                            ),
                                        )
                                    ),
                                    array(
                                        'id'            => 'visibility_by_product',
                                        'type'          => 'accordion',
                                        'class'         => 'padding-t-0',
                                        'dependency'    => array('visibility', 'any', 'product', 'any'),
                                        'accordions'    => array(
                                            array(
                                                'title'     => esc_html__('Products', 'chat-help'),
                                                'fields'    => array(
                                                    array(
                                                        'id'    => 'product_target',
                                                        'type'  => 'select',
                                                        'title' => esc_html__('Target', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Choose whether to show (Include) or hide (Exclude) the chat bubble on the selected products.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                        'options' => array(
                                                            'include' => esc_html__('Include', 'chat-help'),
                                                            'exclude' => esc_html__('Exclude', 'chat-help'),
                                                        ),

                                                    ),
                                                    array(
                                                        'id'    => 'product_all',
                                                        'type'  => 'checkbox',
                                                        'title' => esc_html__('All Products', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Enable this option to apply the chat bubble visibility rule to all products across your store, instead of selecting them individually.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                    ),
                                                    // Include specific
                                                    array(
                                                        'id'    => 'product',
                                                        'type'  => 'select',
                                                        'title' => esc_html__('Products', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Select one or more specific products where the chat bubble visibility rule should apply.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                        'options'    => 'posts',
                                                        'query_args'  => array(
                                                            'post_type' => 'product'
                                                        ),
                                                        'query_args'  => array(
                                                            'posts_per_page' => -1,
                                                        ),
                                                        'chosen'      => true,
                                                        'multiple'     => true,
                                                        'sortable'    => true,
                                                        'empty_message'    => esc_html__('You don\'t have any products available.', 'chat-help'),
                                                        'dependency'    => array('product_all', '!=', 'true', 'any'),
                                                    ),
                                                )
                                            ),
                                        )
                                    ),
                                    array(
                                        'id'            => 'visibility_by_category',
                                        'type'          => 'accordion',
                                        'class'         => 'padding-t-0',
                                        'dependency'    => array('visibility', 'any', 'category', 'any'),
                                        'accordions'    => array(
                                            array(
                                                'title'     => esc_html__('Post Categories', 'chat-help'),
                                                'fields'    => array(
                                                    array(
                                                        'id'    => 'category_target',
                                                        'type'  => 'select',
                                                        'title' => esc_html__('Target', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Choose whether to show (Include) or hide (Exclude) the chat bubble on the selected post categories.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                        'options' => array(
                                                            'include' => esc_html__('Include', 'chat-help'),
                                                            'exclude' => esc_html__('Exclude', 'chat-help'),
                                                        ),

                                                    ),
                                                    array(
                                                        'id'    => 'category_all',
                                                        'type'  => 'checkbox',
                                                        'title' => esc_html__('All Post Categories', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Enable this option to apply the chat bubble visibility rule to all post categories, instead of selecting them individually.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                                                    ),
                                                    // Include specific
                                                    array(
                                                        'id'    => 'category',
                                                        'type'  => 'select',
                                                        'title' => esc_html__('Post Categories', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Select one or more specific post categories where the chat bubble visibility rule should apply.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                        'options'    => 'categories',
                                                        'query_args'  => array(
                                                            'posts_per_page' => -1,
                                                        ),
                                                        'chosen'      => true,
                                                        'multiple'     => true,
                                                        'sortable'    => true,
                                                        'empty_message'    => esc_html__('You don\'t have any post categories available.', 'chat-help'),
                                                        'dependency'    => array('category_all', '!=', 'true', 'any'),
                                                    ),
                                                )
                                            ),
                                        )
                                    ),
                                    array(
                                        'id'            => 'visibility_by_tags',
                                        'type'          => 'accordion',
                                        'class'         => 'padding-t-0',
                                        'dependency'    => array('visibility', 'any', 'tags', 'any'),
                                        'accordions'    => array(
                                            array(
                                                'title'     => esc_html__('Post Tags', 'chat-help'),
                                                'fields'    => array(
                                                    array(
                                                        'id'    => 'tags_target',
                                                        'type'  => 'select',
                                                        'title' => esc_html__('Target', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Choose whether to include or exclude the selected post tags from displaying the chat bubble.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                        'options'   => array(
                                                            'include' => esc_html__('Include', 'chat-help'),
                                                            'exclude' => esc_html__('Exclude', 'chat-help'),
                                                        ),

                                                    ),
                                                    array(
                                                        'id'    => 'tags_all',
                                                        'type'  => 'checkbox',
                                                        'title' => esc_html__('All Post Tags', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Enable this option to apply the chat bubble visibility rule to all post tags, instead of selecting them individually.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                    ),
                                                    // Include specific
                                                    array(
                                                        'id'    => 'tags',
                                                        'type'  => 'select',
                                                        'title' => esc_html__('Post Tags', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Select one or more specific post tags where the chat bubble visibility rule should apply.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                        'options'    => 'tags',
                                                        'query_args'  => array(
                                                            'posts_per_page' => -1,
                                                        ),
                                                        'chosen'      => true,
                                                        'multiple'     => true,
                                                        'sortable'    => true,
                                                        'empty_message'    => esc_html__('You don\'t have any post tags available.', 'chat-help'),
                                                        'dependency'    => array('tags_all', '!=', 'true', 'any'),
                                                    ),
                                                )
                                            ),
                                        )
                                    ),
                                    array(
                                        'id'            => 'visibility_by_product_category',
                                        'type'          => 'accordion',
                                        'class'         => 'padding-t-0',
                                        'dependency'    => array('visibility', 'any', 'product_category', 'any'),
                                        'accordions'    => array(
                                            array(
                                                'title'     => esc_html__('Product Categories', 'chat-help'),
                                                'fields'    => array(
                                                    array(
                                                        'id'    => 'product_category_target',
                                                        'type'  => 'select',
                                                        'title' => esc_html__('Target', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Choose whether to show (Include) or hide (Exclude) the chat bubble on the selected product categories.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                        'options' => array(
                                                            'include' => esc_html__('Include', 'chat-help'),
                                                            'exclude' => esc_html__('Exclude', 'chat-help'),
                                                        ),

                                                    ),
                                                    array(
                                                        'id'    => 'product_category_all',
                                                        'type'  => 'checkbox',
                                                        'title' => esc_html__('All Product Categories', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Enable this option to apply the chat bubble visibility rule to all product categories, instead of selecting them individually.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                    ),
                                                    // Include specific
                                                    array(
                                                        'id'    => 'product_category',
                                                        'type'  => 'select',
                                                        'title' => esc_html__('Product Categories', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Select one or more specific product categories where the chat bubble visibility rule should apply.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                        'options'    => 'categories',
                                                        'query_args'  => array(
                                                            'posts_per_page' => -1,
                                                        ),
                                                        'query_args'  => array(
                                                            'taxonomy' => 'product_cat'
                                                        ),
                                                        'chosen'      => true,
                                                        'multiple'     => true,
                                                        'sortable'    => true,
                                                        'empty_message'    => esc_html__('You don\'t have any product category available.', 'chat-help'),
                                                        'dependency'    => array('product_category_all', '!=', 'true', 'any'),
                                                    ),
                                                )
                                            ),
                                        )
                                    ),
                                    array(
                                        'id'            => 'visibility_by_product_tags',
                                        'type'          => 'accordion',
                                        'class'         => 'padding-t-0',
                                        'dependency'    => array('visibility', 'any', 'product_tags', 'any'),
                                        'accordions'    => array(
                                            array(
                                                'title'     => esc_html__('Product Tags', 'chat-help'),
                                                'fields'    => array(
                                                    array(
                                                        'id'    => 'product_tags_target',
                                                        'type'  => 'select',
                                                        'title' => esc_html__('Target', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Choose whether to show (Include) or hide (Exclude) the chat bubble on the selected product tags.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                        'options' => array(
                                                            'include' => esc_html__('Include', 'chat-help'),
                                                            'exclude' => esc_html__('Exclude', 'chat-help'),
                                                        ),

                                                    ),
                                                    array(
                                                        'id'    => 'product_tags_all',
                                                        'type'  => 'checkbox',
                                                        'title' => esc_html__('All Product Tags', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Enable this option to apply the chat bubble visibility rule to all product tags, instead of selecting them individually.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                    ),
                                                    // Include specific
                                                    array(
                                                        'id'    => 'product_tags',
                                                        'type'  => 'select',
                                                        'title' => esc_html__('Product Tags', 'chat-help'),
                                                        'title_help' =>
                                                        '<div class="chat-help-info-label">' .
                                                            esc_html__('Select one or more specific product tags where the chat bubble visibility rule should apply.', 'chat-help') .
                                                            '</div>' .
                                                            ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/11-others/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                                                        'options'    => 'tags',
                                                        'query_args'  => array(
                                                            'taxonomy' => 'product_tag'
                                                        ),
                                                        'query_args'  => array(
                                                            'posts_per_page' => -1,
                                                        ),
                                                        'chosen'      => true,
                                                        'multiple'     => true,
                                                        'sortable'    => true,
                                                        'empty_message'    => esc_html__('You don\'t have any product tags available.', 'chat-help'),
                                                        'dependency'    => array('product_tags_all', '!=', 'true', 'any'),
                                                    ),
                                                )
                                            ),
                                        )
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
