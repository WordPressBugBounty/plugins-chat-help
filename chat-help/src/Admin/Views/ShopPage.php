<?php

/**
 * Views class for Shortcode generator options.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package chat-help
 * @subpackage chat-help/src/Admin/Views/ShopPage
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Views;

use ThemeAtelier\ChatHelp\Admin\Schema\SchemaRegistry;
use ThemeAtelier\ChatHelp\Admin\Views\Fields\WhatsAppFields;

class ShopPage
{
    /**
     * Create Option fields for the setting options.
     *
     * @param string $prefix Option setting key prefix.
     * @return void
     */
    public static function options($prefix)
    {
        SchemaRegistry::createSection($prefix, array(
            'title'       => esc_html__('Shop Page', 'chat-help'),
            'icon'        => 'icofont-prestashop',
            'fields'      => array(
                array(
                    'id'      => 'shop_page_button',
                    'type'    => 'switcher',
                    'title'   => esc_html__('WhatsApp Button on Shop & Product Loops', 'chat-help'),
                    'title_help' => '<div class="chat-help-info-desc">' . esc_html__('Add a custom WhatsApp button on WooCommerce shop and product loop pages, displayed below or beside the Add to Cart button.', 'chat-help') . '</div>' . ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'product/round-pendant-lamp/?ref=1') . '">' . esc_html__('Live Demo', 'chat-help') . '</a>' . ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    'text_on' => esc_html__('Show', 'chat-help'),
                    'text_off' => esc_html__('Hide', 'chat-help'),
                    'text_width'    => 80,
                ),

                array(
                    'id' => 'shop_page_button_type_of_whatsapp',
                    'type' => 'radio',
                    'inline' => true,
                    'title' => esc_html__('WhatsApp Type', 'chat-help'),
                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('Choose how users will connect: select "Number" to receive direct WhatsApp messages, or "Group" to invite users to join your WhatsApp group.', 'chat-help') . '</div>' . ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/what-is-the-whatsapp-type-field-and-how-should-i-use-it/?ref=1') . '">' . esc_html__('Detailed explanation', 'chat-help') . '</a>',
                    'options' => array(
                        'number' => esc_html__('Number', 'chat-help'),
                        'group'  => esc_html__('Group', 'chat-help'),
                    ),
                    'default' => 'number',
                    'dependency'    => array('shop_page_button', '==', 'true'),
                ),
                WhatsAppFields::number('shop_page_button_number', array('shop_page_button|shop_page_button_type_of_whatsapp', '==|==', 'true|number', 'any')),

                WhatsAppFields::group('shop_page_button_group', array(
                    array('shop_page_button_type_of_whatsapp',   '==', 'group', 'visible'),
                    array('shop_page_button', '==', 'true'),
                )),

                array(
                    'id' => 'shop_page_hide_add_to_cart_button',
                    'type' => 'switcher',
                    'class' => 'chat_help_number',
                    'title' => esc_html__('Hide Add to Cart Button', 'chat-help'),
                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('This will only display the WhatsApp button and hide the Add to Cart button.', 'chat-help') . '</div>',
                    'dependency'    => array('shop_page_button', '==', 'true'),
                ),

                array(
                    'id' => 'shop_page_button_message',
                    'type' => 'textarea',
                    'title' => esc_html__('Pre-filled Message', 'chat-help'),
                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('Write a friendly, pre-filled message that users will see when they click the chat button. Example: “Hi! I have a question about your product {productName}.” This saves them time and makes starting a conversation effortless.', 'chat-help') . '</div>' . ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/10-how-can-i-use-dynamic-variables-in-the-woocommerce-button-pre-filled-message/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    'desc' => '<b>' . esc_html__('WooCommerce Vars:', 'chat-help') . '</b> {productName}, {productSlug}, {productSku}, {productPrice}, {productRegularPrice}, {productSalePrice}, {productStockStatus} <br>' .
                        '<b>' . esc_html__('Conditional Blocks:', 'chat-help') . '</b> {PRODUCT_START} ... {PRODUCT_END}, {NOT_PRODUCT_START} ... {NOT_PRODUCT_END}, {LOGGEDIN_START} ... {LOGGEDIN_END}, {NOT_LOGGEDIN_START} ... {NOT_LOGGEDIN_END}  <br>' . '<b>' . esc_html__('Global Vars:', 'chat-help') . '</b> {siteTitle}, {siteEmail}, {currentURL}, {currentTitle}, {siteURL}, {ip}, {date}',
                    'default' => "Hello! I’d like to ask about {productName} (SKU: {productSku}) on {siteTitle}.\n{PRODUCT_START}Current price: {productPrice} (regular: {productRegularPrice}, sale: {productSalePrice})\nStock: {productStockStatus}{PRODUCT_END}",
                    'dependency' =>  array(
                        array('shop_page_button_type_of_whatsapp',   '==', 'number', 'visible'),
                        array('shop_page_button', '==', 'true'),
                    ),
                ),

                array(
                    'id'    => 'shop_page_button_position',
                    'type'  => 'select',
                    'title'   => esc_html__('Button Position', 'chat-help'),
                    'options' => array(
                        'woocommerce_after_shop_loop_item'  => esc_html__('Above "Add to Cart" button', 'chat-help'),
                        'woocommerce_before_shop_loop_item' => esc_html__('Below "Add to Cart" button', 'chat-help'),
                    ),
                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('Choose where the WhatsApp button will appear on WooCommerce shop page or product loop.', 'chat-help') . '</div>' . ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'product/round-pendant-lamp/?ref=1') . '">' . esc_html__('Live Demo', 'chat-help') . '</a>' . ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    'default'   => 'woocommerce_before_shop_loop_item',
                    'dependency'    => array('shop_page_button', '==', 'true'),
                ),

                array(
                    'id' => 'shop_page_button_style',
                    'type' => 'layout_preset',
                    'title' => esc_html__('WooCommerce Button Style', 'chat-help'),
                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('Choose a style for the floating chat button from the available design options.', 'chat-help') . '</div>' . ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'simple-button/">' . esc_html__('Live Demo', 'chat-help') . '</a>' . ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                    'options' => array(
                        '1' => array(
                            'image'           => CHAT_HELP_DIR_URL . 'src/Admin/assets/images/button-1.svg',
                            'text'            => esc_html__('Icon', 'chat-help'),
                            'option_demo_url' => CHAT_HELP_DEMO_URL . 'product/round-pendant-lamp/?ref=1',
                        ),
                        '2' => array(
                            'image'           => CHAT_HELP_DIR_URL . 'src/Admin/assets/images/button-2.svg',
                            'text'            => esc_html__('Simple Button', 'chat-help'),
                            'option_demo_url' => CHAT_HELP_DEMO_URL . 'product/golden-lamps/?ref=1',
                        ),
                        '10' => array(
                            'image'           => CHAT_HELP_DIR_URL . 'src/Admin/assets/images/advance-filled.svg',
                            'text'            => esc_html__('Advance Button', 'chat-help'),
                            'option_demo_url' => CHAT_HELP_DEMO_URL . '/product/hand-made-pottery/?ref=1',
                        ),
                    ),
                    'default' => '2',
                    'dependency'    => array('shop_page_button', '==', 'true'),
                ),

                array(
                    'id' => 'shop_page_agent_photo_type',
                    'type' => 'button_set',
                    'title' => esc_html__('Agent Photo Type', 'chat-help'),
                    'title_help' => '<div class="chat-help-info-label">' .
                        esc_html__('Choose how the agent photo is displayed:', 'chat-help') . '</div>' . ' <b>Default:</b> ' . esc_html__('Use the plugin’s built-in photo.', 'chat-help') . '<br>' . ' <b>Custom:</b> ' . esc_html__('Upload your own image.', 'chat-help') . '<br>' . ' <b>None:</b> ' . esc_html__('No photo will be shown.', 'chat-help') . '<br>' . ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/8-header-and-footer/#header-footer-settings-single-form-single-agent">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    'options' => array(
                        'default'   =>  esc_html__('Default', 'chat-help'),
                        'custom' => esc_html__('Custom', 'chat-help'),
                        'none' => esc_html__('None', 'chat-help'),
                    ),
                    'default'   => 'default',
                    'dependency' => array('shop_page_button|shop_page_button_style', '==|==', 'true|10', 'any'),
                ),

                array(
                    'id' => 'shop_page_agent_photo',
                    'type' => 'media',
                    'title' => esc_html__('Agent Photo', 'chat-help'),
                    'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/assets/images/preview/user_image.png') . '" alt=""></div>' . '<div class="chat-help-info-label">' . esc_html__('Upload an agent photo to display inside the chat bubble.', 'chat-help') . '</div>' . ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form">' . esc_html__('Live Demo', 'chat-help') . '</a>' . ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/8-header-and-footer/#header-footer-settings-single-form-single-agent">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    'placeholder' => esc_html__('Upload or select an image from the media library.', 'chat-help'),

                    'library' => 'image',
                    'preview' => true,
                    'dependency' => array('shop_page_button|shop_page_button_style|shop_page_agent_photo_type', '==|==|==', 'true|10|custom', 'any'),
                ),

                array(
                    'id' => 'shop_page_button_top_label',
                    'type' => 'text',
                    'title' => esc_html__('Button Top Label', 'chat-help'),
                    'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/assets/images/preview/agent_name.png') . '" alt=""></div>' . '<div class="chat-help-info-label">' . esc_html__('Enter the agent’s name to display inside the chat bubble.', 'chat-help') . '</div>' . ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form">' . esc_html__('Live Demo', 'chat-help') . '</a>' . ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/8-header-and-footer/#header-footer-settings-single-form-single-agent">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    'default' => esc_html__('John Doe / Technical support', 'chat-help'),
                    'dependency' => array('shop_page_button|shop_page_button_style', '==|==', 'true|10', 'any'),
                ),

                array(
                    'id' => 'shop_page_button_text',
                    'type' => 'text',
                    'title' => esc_html__('Button Main Label', 'chat-help'),
                    'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/assets/images/preview/button_text.png') . '" alt=""></div>' . '<div class="chat-help-info-label">' . esc_html__('Enter the text to display inside the floating chat button.', 'chat-help') . '</div>' . ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'simple-button/">' . esc_html__('Live Demo', 'chat-help') . '</a>' . ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    'default' => esc_html__('How may I help you?', 'chat-help'),
                    'dependency' => array('shop_page_button|shop_page_button_style', '==|!=', 'true|1', 'any'),
                ),

                array(
                    'id' => 'shop_page_circle_button_icon',
                    'type' => 'button_set',
                    'title' => esc_html__('Icon for Circle Button', 'chat-help'),
                    'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/assets/images/preview/circle_icon.png') . '" alt=""></div>' . '<div class="chat-help-info-label">' . esc_html__('Select an icon to display inside the circular chat button.', 'chat-help') . '</div>' . ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_attr(CHAT_HELP_DEMO_URL) . 'simple-button/">' . esc_html__('Live Demo', 'chat-help') . '</a>' . ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_attr(CHAT_HELP_DEMO_URL) . 'docs/woocommerce-button/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',

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
                        'icofont-paper-plane'    => array(
                            'option_name' => '<i class="icofont-paper-plane"></i>',
                        ),
                        'native'    => array(
                            'option_name' => esc_html__('Native', 'chat-help'),
                        ),
                        'custom'    => array(
                            'option_name' => esc_html__('Custom', 'chat-help'),
                        ),
                    ),
                    'default' => 'icofont-brand-whatsapp',
                    'dependency' => array('shop_page_button|shop_page_button_style', '==|==', 'true|1', 'any'),
                ),

                array(
                    'id' => 'shop_page_circle_button_icon_native',
                    'type' => 'icon',
                    'title' => esc_html__('Circle Button Native Icon', 'chat-help'),
                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('Choose a native icon from the built-in library of 2000+ icons to display inside the circular chat button.', 'chat-help') . '</div>' . ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'simple-button/">' . esc_html__('Live Demo', 'chat-help') . '</a>' . ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    'default' => 'icofont-brand-whatsapp',
                    'dependency' => array('shop_page_button|shop_page_button_style|shop_page_circle_button_icon', '==|==|==', 'true|1|native', 'any'),
                ),
                array(
                    'id' => 'shop_page_circle_button_icon_custom',
                    'type' => 'media',
                    'title' => esc_html__('Circle Button Custom Icon', 'chat-help'),
                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('Upload or select a custom icon from your media library to display inside the circular chat button.', 'chat-help') . '</div>' . ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'simple-button/">' . esc_html__('Live Demo', 'chat-help') . '</a>' . ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/9-button/? ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    'dependency' => array('shop_page_button|shop_page_button_style|shop_page_circle_button_icon', '==|==|==', 'true|1|custom', 'any'),
                ),

                array(
                    'id' => 'shop_page_button_icon_open',
                    'type' => 'button_set',
                    'title' => esc_html__('Icon for Button', 'chat-help'),
                    'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/assets/images/preview/button_icon.png') . '" alt=""></div>' . '<div class="chat-help-info-label">' . esc_html__('Select an icon to display inside the floating chat button.', 'chat-help') . '</div>' . ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'simple-button/">' . esc_html__('Live Demo', 'chat-help') . '</a>' . ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    'options' => array(
                        'icofont-brand-whatsapp'    => array('option_name' => '<i class="icofont-brand-whatsapp"></i>'),
                        'icofont-whatsapp'    => array('option_name' => '<i class="icofont-whatsapp"></i>'),
                        'icofont-live-support'    => array('option_name' => '<i class="icofont-live-support"></i>'),
                        'icofont-ui-messaging'    => array('option_name' => '<i class="icofont-ui-messaging"></i>'),
                        'icofont-telegram'    => array('option_name' => '<i class="icofont-telegram"></i>'),
                        'icofont-paper-plane'    => array('option_name' => '<i class="icofont-paper-plane"></i>'),
                        'native'    => array(
                            'option_name' => esc_html__('Native', 'chat-help'),
                        ),
                        'custom'    => array(
                            'option_name' => esc_html__('Custom', 'chat-help'),
                        ),
                        'no_icon'    => array(
                            'option_name' => esc_html__('No Icon', 'chat-help'),
                        ),
                    ),
                    'default' => 'icofont-brand-whatsapp',
                    'dependency' => array('shop_page_button|shop_page_button_style', '==|==', 'true|2', 'any'),
                ),

                array(
                    'id' => 'shop_page_button_icon_native',
                    'type' => 'icon',
                    'title' => esc_html__('Button Native Icon', 'chat-help'),
                    'title_help' =>
                    '<div class="chat-help-info-label">' .
                        esc_html__('Choose a native icon from the built-in library of 2000+ icons to display inside the floating chat button.', 'chat-help') .
                        '</div>' .
                        ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'simple-button/">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                        ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                    'default' => 'icofont-brand-whatsapp',
                    'dependency' => array('shop_page_button|shop_page_button_style|shop_page_button_icon_open', '==|==|==', 'true|2|native', 'any'),
                ),
                array(
                    'id' => 'shop_page_button_icon_custom',
                    'type' => 'media',
                    'title' => esc_html__('Button Custom Icon', 'chat-help'),
                    'title_help' =>
                    '<div class="chat-help-info-label">' .
                        esc_html__('Upload or select a custom icon from your media library to display inside the floating chat button.', 'chat-help') .
                        '</div>' .
                        ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                        ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                    'dependency' => array('shop_page_button|shop_page_button_style|shop_page_button_icon_open', '==|==|==', 'true|2|custom', 'any'),
                ),
                array(
                    'id' => 'shop_page_button_size',
                    'type' => 'button_set',
                    'title' => esc_html__('Button Size', 'chat-help'),
                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('Select the size of the button.', 'chat-help') . '</div>',
                    'options' => array(
                        '0.7' => array(
                            'option_name'   => esc_html__('XS', 'chat-help'),
                        ),
                        '0.8' => array(
                            'option_name'   => esc_html__('S', 'chat-help'),
                        ),
                        '1' => array(
                            'option_name'   => esc_html__('M', 'chat-help'),
                        ),
                        '1.2' => array(
                            'option_name'   => esc_html__('L', 'chat-help'),
                        ),
                        '1.4' => array(
                            'option_name'   => esc_html__('XL', 'chat-help'),
                        ),
                        '1.6' => array(
                            'option_name'   => esc_html__('XXL', 'chat-help'),
                        ),
                        'custom' => array(
                            'option_name'   => esc_html__('Custom', 'chat-help'),
                        ),
                    ),
                    'default' => '1',
                    'dependency' => array('shop_page_button', '==', 'true', 'any'),
                ),
                array(
                    'id'          => 'shop_page_button_size_custom',
                    'type'        => 'slider',
                    'title'       => esc_html__('Custom Switch Size', 'chat-help'),
                    'title_help' => '<div class="chat-help-info-desc">' . esc_html__('Scale in percentage relative to normal size.', 'chat-help') . '</div><a class="tooltip_btn_primary" href="' . CHAT_HELP_DEMO_URL . 'simple-button/" target="_blank">' . esc_html__('Live Demo', 'chat-help') . '</a><a class="tooltip_btn_secondary" href="' . CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1" target="_blank">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    'default' => '100',
                    'min'     => 40,
                    'max'     => 300,
                    'dependency'    => array('shop_page_button|shop_page_button_size', '==|==', 'true|custom'),
                ),
                array(
                    'id'        => 'shop_page_icon_color',
                    'type'      => 'color_group',
                    'title' => esc_html__('Icon Color', 'chat-help'),
                    'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/assets/images/preview/icon_background.jpg') . '" alt=""></div>' .  '<div class="chat-help-info-label">' .
                        esc_html__('You can define normal and hover colors for the button icon.', 'chat-help') .
                        '</div>',
                    'options' => array(
                        'normal_color'   => esc_html__('Normal Color', 'chat-help'),
                        'hover_color' => esc_html__('Hover Color', 'chat-help'),
                    ),
                    'dependency' => array('shop_page_button|shop_page_button_style|shop_page_button_icon_open', '==|!=|!=', 'true|10|no_icon', 'any'),
                ),
                array(
                    'id' => 'shop_page_icon_bg',
                    'type' => 'switcher',
                    'title' => esc_html__('Icon Background', 'chat-help'),
                    'text_on' => esc_html__('Enable', 'chat-help'),
                    'text_off' => esc_html__('Disable', 'chat-help'),
                    'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/assets/images/preview/icon_background.jpg') . '" alt=""></div>' . '<div class="chat-help-info-label">' .
                        esc_html__('Enable/Disable Button Inner Icon Background', 'chat-help') .
                        '</div>' .
                        ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'simple-button/">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                        ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',

                    'default' => true,
                    'text_width' => 90,
                    'dependency' => array('shop_page_button|shop_page_button_icon_open|shop_page_button_style', '==|!=|==', 'true|no_icon|2', 'any'),
                ),

                array(
                    'id'        => 'shop_page_icon_bg_color',
                    'type'      => 'color_group',
                    'title' => esc_html__('Icon Background Color', 'chat-help'),
                    'title_help' => '<div class="chat-help-info-label">' .
                        esc_html__('You can define normal and hover background colors for the button icon.', 'chat-help') .
                        '</div>',
                    'options' => array(
                        'normal_color'   => esc_html__('Normal Color', 'chat-help'),
                        'hover_color' => esc_html__('Hover Color', 'chat-help'),
                    ),
                    'default'   => array(
                        'normal_color' => '#ffffff',
                        'hover_color' => '#ffffff',
                    ),
                    'dependency' => array('shop_page_button|shop_page_button_icon_open|shop_page_button_style|shop_page_icon_bg', '==|!=|==|==', 'true|no_icon|2|true', 'any'),
                ),

                array(
                    'id'        => 'shop_page_button_bg',
                    'type'      => 'color_group',
                    'title' => esc_html__('Button Background', 'chat-help'),
                    'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/assets/images/preview/button_background.jpg') . '" alt=""></div>' . '<div class="chat-help-info-label">' .
                        esc_html__('Set your button background color.', 'chat-help') .
                        '</div>' .
                        ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form/">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                        ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/10-style/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    'options' => array(
                        'normal_color'   => esc_html__('Normal Color', 'chat-help'),
                        'hover_color' => esc_html__('Hover Color', 'chat-help'),
                    ),
                    'dependency'    => array('shop_page_button', '==', 'true'),
                ),
                array(
                    'id'        => 'shop_page_button_text_color',
                    'type'      => 'color_group',
                    'title' => esc_html__('Button Label Color', 'chat-help'),
                    'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/assets/images/preview/button_text_color.jpg') . '" alt=""></div>' . '<div class="chat-help-info-label">' .
                        esc_html__('Set your button button label color.', 'chat-help') .
                        '</div>' .
                        ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form/">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                        ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/10-style/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    'options' => array(
                        'normal_color'   => esc_html__('Normal Color', 'chat-help'),
                        'hover_color' => esc_html__('Hover Color', 'chat-help'),
                    ),
                    'dependency' => array('shop_page_button|shop_page_button_style', '==|!=', 'true|1', 'any'),
                ),
                array(
                    'id' => 'shop_page_button_border',
                    'type' => 'border',
                    'title' => esc_html__('Button Border', 'chat-help'),
                    'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/assets/images/preview/button_border.jpg') . '" alt=""></div>' . '<div class="chat-help-info-label">' .
                        esc_html__('Set border for the floating chat button.', 'chat-help') .
                        '</div>' .
                        ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                        ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    'all'      => true,
                    'hover_color'      => true,
                    'border_radius'      => true,
                    'default'  => array(
                        'all'   => '0',
                        'style' => 'solid',
                        'color' => '',
                        'hover_color' => '',
                        'border_radius' => '50',
                    ),
                    'dependency'    => array('shop_page_button', '==', 'true'),
                ),
                array(
                    'id' => 'shop_page_icon_border',
                    'type' => 'border',
                    'title' => esc_html__('Icon Border', 'chat-help'),
                    'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/assets/images/preview/button_border.jpg') . '" alt=""></div>' . '<div class="chat-help-info-label">' .
                        esc_html__('Set border for the floating chat button.', 'chat-help') .
                        '</div>' .
                        ' <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'single-form/?ref=1">' . esc_html__('Live Demo', 'chat-help') . '</a>' .
                        ' <a class="tooltip_btn_secondary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    'all'      => true,
                    'hover_color'      => true,
                    'border_radius'      => true,
                    'default'  => array(
                        'all'   => '0',
                        'style' => 'solid',
                        'color' => '#ffffff',
                        'hover_color' => '#ffffff',
                        'border_radius' => '50',
                    ),
                    'dependency' => array('shop_page_button|opt-button-style', '==|!=', 'true|1', 'any'),
                ),
                array(
                    'id'    => 'shop_page_button_padding',
                    'type'    => 'spacing',
                    'title'     => esc_html__('Button Padding', 'chat-help'),
                    'title_help' => '<div class="chat-help-img-tag"><img src="' . esc_url(CHAT_HELP_DIR_URL . 'src/Admin/assets/images/preview/button_padding.jpg') . '" alt=""></div>' . '<div class="chat-help-info-label">' . esc_html__('Adjust the inner spacing (padding) of the chat button for better alignment and appearance.',  'chat-help') . '</div>' . ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'product/round-pendant-lamp/?ref=1') . '">' . esc_html__('Live Demo', 'chat-help') . '</a>' . ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    'default'     => array(
                        'top'       => '5',
                        'right'     => '15',
                        'bottom'    => '5',
                        'left'      => '6',
                        'unit'      => 'px',
                    ),
                    'dependency' => array('shop_page_button|shop_page_button_style', '==|!=', 'true|1', 'any'),
                ),

                array(
                    'id'    => 'shop_page_button_margin',
                    'type'    => 'spacing',
                    'title'     => esc_html__('Button Margin', 'chat-help'),
                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('Adjust the outer spacing (margin) around the chat button to control its placement.', 'chat-help') . '</div>' . ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'product/round-pendant-lamp/?ref=1') . '">' . esc_html__('Live Demo', 'chat-help') . '</a>' . ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    'default'     => array(
                        'top'       => '0',
                        'right'     => '0',
                        'bottom'    => '0',
                        'left'      => '0',
                        'unit'      => 'px',
                    ),
                    'output_mode' => 'margin',
                    'dependency'    =>  array('shop_page_button', '==', 'true')
                ),

                array(
                    'id'      => 'shop_page_button_visibility',
                    'type'    => 'button_set',
                    'title'     => esc_html__('Button Visibility', 'chat-help'),
                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('Control where the chat button is visible. Choose to show it on all devices or restrict it to desktop, tablet, or mobile only.', 'chat-help') . '</div>' . ' <a class="tooltip_btn_primary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'product/round-pendant-lamp/?ref=1') . '">' . esc_html__('Live Demo', 'chat-help') . '</a>' . ' <a class="tooltip_btn_secondary" target="_blank" href="' . esc_url(CHAT_HELP_DEMO_URL . 'docs/woocommerce-button/?ref=1') . '">' . esc_html__('Open Docs', 'chat-help') . '</a>',
                    'options'   => array(
                        'everywhere'  => esc_html__('Everywhere', 'chat-help'),
                        'desktop'     => esc_html__('Desktop Only', 'chat-help'),
                        'tablet'      => esc_html__('Tablet Only', 'chat-help'),
                        'mobile'      => esc_html__('Mobile Only', 'chat-help'),
                    ),
                    'default' => 'everywhere',
                    'dependency'    =>  array('shop_page_button', '==', 'true')
                )
            )
        ));
    }
}
