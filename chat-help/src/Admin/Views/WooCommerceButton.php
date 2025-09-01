<?php

/**
 * Views class for Shortcode generator options.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/src/Admin/Views/WooCommerceButton
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Views;

use ThemeAtelier\ChatHelp\Admin\Framework\Classes\Chat_Help;

class WooCommerceButton
{

    /**
     * Create Option fields for the setting options.
     *
     * @param string $prefix Option setting key prefix.
     * @return void
     */
    public static function options($prefix)
    {
        //
        // Field: backup
        //
        Chat_Help::createSection($prefix, array(
            'title'       => esc_html__('WOOCOMMERCE BUTTON', 'chat-help'),
            'icon'        => 'icofont-shopping-cart',
            'fields'      => array(
                array(
                    'id'      => 'wooCommerce_button',
                    'type'    => 'switcher',
                    'title'   => esc_html__('WooCommerce Button', 'chat-help'),
                    'title_help' =>
                    '<div class="chat-help-info-label">' .
                        esc_html__('Show or hide the WhatsApp chat button on WooCommerce product pages.', 'chat-help') .
                        '</div>' .
                        ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'product/round-pendant-lamp/?ref=1') . '">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                        ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                    'text_on' => esc_html__('Show', 'chat-help'),
                    'text_off' => esc_html__('Hide', 'chat-help'),
                    'text_width'    => 80,
                ),

                array(
                    'id'    => 'wooCommerce_button_position',
                    'type'  => 'button_set',
                    'title'   => esc_html__('Button Position', 'chat-help'),
                    'options' => array(
                        'before' => esc_html__('Before Cart Button', 'chat-help'),
                        'after'  => esc_html__('After Cart Button', 'chat-help'),
                    ),
                    'title_help' =>
                    '<div class="chat-help-info-label">' .
                        esc_html__('Choose where the WhatsApp button will appear on WooCommerce product pages. Default: After Cart Button.', 'chat-help') .
                        '</div>' .
                        ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'product/round-pendant-lamp/?ref=1') . '">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                        ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                    'default'   => 'after',
                ),

                array(
                    'id' => 'wooCommerce_button_type_of_whatsapp',
                    'type' => 'radio',
                    'inline' => true,
                    'title' => esc_html__('WhatsApp Type', 'chat-help'),
                    'title_help' =>
                    '<div class="chat-help-info-label">' .
                        esc_html__('Choose how users will connect: select "Number" to receive direct WhatsApp messages, or "Group" to invite users to join your WhatsApp group.', 'chat-help') .
                        '</div>' .
                        ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/what-is-the-whatsapp-type-field-and-how-should-i-use-it/?ref=1') . '">' . esc_html__('Detailed explanation', 'chat-help') . '</a>',
                    'options' => array(
                        'number' => esc_html__('Number', 'chat-help'),
                        'group'  => esc_html__('Group', 'chat-help'),
                    ),

                    'default' => 'number',
                ),
                array(
                    'id' => 'wooCommerce_button_number',
                    'type' => 'text',
                    'class' => 'chat_help_number',
                    'title' => esc_html__('WhatsApp Number', 'chat-help'),
                    'desc' => 'WhatsApp number in international format.',
                    'chat-help',
                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('Add your WhatsApp number including country code. eg: +880123456189', 'chat-help') . '</div> <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/how-should-i-enter-my-whatsapp-number-in-the-plugin/?ref=1">Detailed explanation</a>',
                    'dependency' =>  array(
                        array('wooCommerce_button_type_of_whatsapp', '==', 'number', 'any'),
                    ),
                ),

                array(
                    'id' => 'wooCommerce_button_group',
                    'type' => 'text',
                    'class' => 'chat_help_group',
                    'title' => esc_html__('WhatsApp Group', 'chat-help'),
                    'desc' => esc_html__('Enter a valid WhatsApp group link (e.g., https://chat.whatsapp.com/Dn16RARM6KW7X4fq0fxVet).', 'chat-help'),
                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('Invite your visitors to join your WhatsApp group by adding the group’s invite URL here.', 'chat-help') . '</div> <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/how-do-i-create-a-whatsapp-group-and-invite-members/?ref=1">Detailed explanation</a>',
                    'dependency' =>  array(
                        array('wooCommerce_button_type_of_whatsapp',   '==', 'group', 'visible'),
                    ),
                ),

                array(
                    'id' => 'wooCommerce_button_message',
                    'type' => 'textarea',
                    'title' => esc_html__('Pre-filled Message', 'chat-help'),
                    'title_help' =>
                    '<div class="chat-help-info-label">' .
                        esc_html__('Write a friendly, pre-filled message that users will see when they click the chat button. Example: “Hi! I have a question about your product {productName}.” This saves them time and makes starting a conversation effortless.', 'chat-help') .
                        '</div>' .
                        ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/10-how-can-i-use-dynamic-variables-in-the-woocommerce-button-pre-filled-message/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    'desc' =>
                    '<b>' . esc_html__('WooCommerce Vars:', 'chat-help') . '</b> {productName}, {productSlug}, {productSku}, {productPrice}, {productRegularPrice}, {productSalePrice}, {productStockStatus} <br>' .
                        '<b>' . esc_html__('Conditional Blocks:', 'chat-help') . '</b> {PRODUCT_START} ... {PRODUCT_END}, {NOT_PRODUCT_START} ... {NOT_PRODUCT_END}, {LOGGEDIN_START} ... {LOGGEDIN_END}, {NOT_LOGGEDIN_START} ... {NOT_LOGGEDIN_END}  <br>' . '<b>' . esc_html__('Global Vars:', 'chat-help') . '</b> {siteTitle}, {siteEmail}, {currentURL}, {currentTitle}, {siteURL}, {ip}, {date}',
                    'default' => "Hello! I’d like to ask about {productName} (SKU: {productSku}) on {siteTitle}.\n{PRODUCT_START}Current price: {productPrice} (regular: {productRegularPrice}, sale: {productSalePrice})\nStock: {productStockStatus}{PRODUCT_END}",

                    'dependency' =>  array(
                        array('wooCommerce_button_type_of_whatsapp',   '==', 'number', 'visible'),
                    ),
                ),

                array(
                    'id'    => 'wooCommerce_button_icon',
                    'type'  => 'switcher',
                    'title'     => esc_html__('Show/Hide Icon', 'chat-help'),
                    'title_help' =>
                    '<div class="chat-help-info-label">' .
                        esc_html__('Toggle the visibility of the WhatsApp chat icon on single product pages.', 'chat-help') .
                        '</div>' .
                        ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'product/round-pendant-lamp/?ref=1') . '">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                        ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    'text_on'   => esc_html__('Show', 'chat-help'),
                    'text_off'  => esc_html__('Hide', 'chat-help'),

                    'default'   => true,
                    'text_width'    => 80,

                ),

                // Circle button icon
                array(
                    'id'    => 'wooCommerce_button_icon_open',
                    'type'  => 'icon',
                    'title'     => esc_html__('Icon for Button', 'chat-help'),
                    'title_help' =>
                    '<div class="chat-help-info-label">' .
                        esc_html__('Change the icon displayed inside the button.', 'chat-help') .
                        '</div>' .
                        ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'product/round-pendant-lamp/?ref=1') . '">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                        ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                    'default' => 'icofont-brand-whatsapp',
                    'dependency' => array('wooCommerce_button_icon', '==', 'true'),
                ),

                array(
                    'id'    => 'wooCommerce_button_text',
                    'type'  => 'text',
                    'title'     => esc_html__('Button Text', 'chat-help'),
                    'title_help' =>
                    '<div class="chat-help-info-label">' .
                        esc_html__('Set the label text displayed inside the WhatsApp chat button.', 'chat-help') .
                        '</div>' .
                        ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'product/round-pendant-lamp/?ref=1') . '">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                        ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    'default'   => esc_html__('How may I help you?', 'chat-help'),

                ),

                array(
                    'id'    => 'wooCommerce_button_padding',
                    'type'    => 'spacing',
                    'title'     => esc_html__('Button Padding', 'chat-help'),
                    'title_help' =>
                    '<div class="chat-help-info-label">' .
                        esc_html__('Adjust the inner spacing (padding) of the chat button for better alignment and appearance.', 'chat-help') .
                        '</div>' .
                        ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'product/round-pendant-lamp/?ref=1') . '">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                        ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                    'default'     => array(
                        'top'       => '5',
                        'right'     => '15',
                        'bottom'    => '5',
                        'left'      => '15',
                        'unit'      => 'px',
                    ),

                ),

                array(
                    'id'    => 'wooCommerce_button_margin',
                    'type'    => 'spacing',
                    'title'     => esc_html__('Button Margin', 'chat-help'),
                    'title_help' =>
                    '<div class="chat-help-info-label">' .
                        esc_html__('Adjust the outer spacing (margin) around the chat button to control its placement.', 'chat-help') .
                        '</div>' .
                        ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'product/round-pendant-lamp/?ref=1') . '">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                        ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                    'default'     => array(
                        'top'       => '0',
                        'right'     => '0',
                        'bottom'    => '20',
                        'left'      => '0',
                        'unit'      => 'px',
                    ),

                ),

                array(
                    'id'    => 'wooCommerce_button_border_radius',
                    'type'    => 'spacing',
                    'title'     => esc_html__('Button Border Radius', 'chat-help'),
                    'title_help' =>
                    '<div class="chat-help-info-label">' .
                        esc_html__('Adjust the border radius to control the roundness of the chat button corners.', 'chat-help') .
                        '</div>' .
                        ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'product/round-pendant-lamp/?ref=1') . '">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                        ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                    'default'     => array(
                        'top'       => '5',
                        'right'     => '5',
                        'bottom'    => '5',
                        'left'      => '5',
                        'unit'      => 'px',
                    ),

                ),
                array(
                    'id'      => 'wooCommerce_button_visibility',
                    'type'    => 'button_set',
                    'title'     => esc_html__('Button Visibility', 'chat-help'),
                    'title_help' =>
                    '<div class="chat-help-info-label">' .
                        esc_html__('Control where the chat button is visible. Choose to show it on all devices or restrict it to desktop, tablet, or mobile only.', 'chat-help') .
                        '</div>' .
                        ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'product/round-pendant-lamp/?ref=1') . '">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                        ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    'options'   => array(
                        'everywhere'  => esc_html__('Everywhere', 'chat-help'),
                        'desktop'     => esc_html__('Desktop Only', 'chat-help'),
                        'tablet'      => esc_html__('Tablet Only', 'chat-help'),
                        'mobile'      => esc_html__('Mobile Only', 'chat-help'),
                    ),
                    'default' => 'everywhere',
                )
            )
        ));
    }
}
