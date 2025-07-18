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
                    'id'    => 'wooCommerce_button',
                    'type'  => 'switcher',
                    'title' => esc_html__('WooCommerce Button', 'chat-help'),
                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('Show chat whatsapp button on single product page.', 'chat-help') . '</div>',
                    'text_on' => esc_html__('Show', 'chat-help'),
                    'text_off'  => esc_html__('Hide', 'chat-help'),
                    'text_width'    => 80,
                ),


                array(
                    'type' => 'section_tab',
                    'class'=> 'chathelp-mt-0',
                    'dependency' => array('wooCommerce_button', '==', 'true'),
                    'tabs' => array(

                        array(
                            'title' => esc_html__('GENERAL', 'chat-help'),
                            'icon'  => 'icofont-gears',
                            'fields' => array(
                                array(
                                    'id'    => 'wooCommerce_button_position',
                                    'type'  => 'button_set',
                                    'title' => esc_html__('Button Position', 'chat-help'),
                                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('Select button position. Default: After Cart Button.', 'chat-help') . '</div>',
                                    'options'    => array(
                                        'before'  => array(
                                            'text' => esc_html__('Before Cart', 'chat-help'),
                                        ),
                                        'after' => array(
                                            'text' => esc_html__('After Cart', 'chat-help'),
                                        ),
                                    ),
                                    'default'   => 'after',
                                ),
                                array(
                                    'id' => 'wooCommerce_button_type_of_whatsapp',
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
                                ),
                                array(
                                    'id' => 'wooCommerce_button_number',
                                    'type' => 'text',
                                     'class' => 'chat_help_number',
                                    'title' => esc_html__('WhatsApp Number', 'chat-help'),
                                    'desc' => 'WhatsApp number in international format.', 'chat-help',
                                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('Add your WhatsApp number including country code. eg: +880123456189', 'chat-help') . '</div> <a class="tooltip_btn_primary" target="_blank" href="https://faq.whatsapp.com/640432094208718/?helpref=uf_share">Detailed explanation</a>',
                                    'dependency' =>  array(
                                        array('wooCommerce_button_type_of_whatsapp',   '==', 'number', 'visible'),
                                    ),
                                ),
                                array(
                                    'id' => 'wooCommerce_button_group',
                                    'type' => 'text',
                                    'class' => 'chat_help_group',
                                    'desc' => 'WhatsApp group link.', 'chat-help',
                                    'title' => esc_html__('WhatsApp Group', 'chat-help'),
                                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('Invite your visitors to join into your whatapp group.', 'chat-help') . '</div> <a class="chat-help-open-docs" target="_blank" href="https://faq.whatsapp.com/3242937609289432?helpref=search&cms_platform=web">Detailed explanation</a>',
                                    'dependency' =>  array(
                                        array('wooCommerce_button_type_of_whatsapp',   '==', 'group', 'visible'),
                                    ),
                                ),

                                array(
                                    'id' => 'wooCommerce_button_message',
                                    'type' => 'textarea',
                                    'title' => esc_html__('Predefined Text', 'chat-help'),
                                    'desc' => esc_html__('Available tags – {siteURL}, {productName}, {productSlug}, {productSku}, {productPrice}, {productRegularPrice}, {productSalePrice}, {productStockStatus}, {ip}', 'chat-help'),
                                    'dependency' =>  array(
                                        array('wooCommerce_button_type_of_whatsapp',   '==', 'number', 'visible'),
                                    ),
                                ),

                                
                                array(
                                    'id'    => 'wooCommerce_button_icon',
                                    'type'  => 'switcher',
                                    'title' => esc_html__('Show/Hide Icon', 'chat-help'),
                                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('Show chat whatsapp button on single product page.', 'chat-help') . '</div>',
                                    'text_on' => esc_html__('Show', 'chat-help'),
                                    'text_off'  => esc_html__('Hide', 'chat-help'),
                                    'default'   => true,
                                    'text_width'    => 80,
                                ),
                                // Circle button icon
                                array(
                                    'id'    => 'wooCommerce_button_icon_open',
                                    'type'  => 'icon',
                                    'title' => esc_html__('Icon For Circle Button', 'chat-help'),
                                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('Change icon for circle button.', 'chat-help') . '</div>',
                                    'default' => 'icofont-brand-whatsapp',
                                    'dependency' => array('wooCommerce_button_icon', '==', 'true'),
                                ),
                                array(
                                    'id'    => 'wooCommerce_button_text',
                                    'type'  => 'text',
                                    'title' => esc_html__('Button Text', 'chat-help'),
                                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('Change text to show in button.', 'chat-help') . '</div>',
                                    'default'   => 'How may I help you?',
                                ),
                                array(
                                    'id'    => 'wooCommerce_button_padding',
                                    'type'    => 'spacing',
                                    'title'   => esc_html__('Button Padding', 'chat-help'),
                                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('Change button padding.', 'chat-help') . '</div>',
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
                                    'title'   => esc_html__('Button Margin', 'chat-help'),
                                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('Change button margin.', 'chat-help') . '</div>',
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
                                    'title'   => esc_html__('Button Border Radius', 'chat-help'),
                                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('Change button border radius.', 'chat-help') . '</div>',
                                    'default'     => array(
                                        'top'       => '5',
                                        'right'     => '5',
                                        'bottom'    => '5',
                                        'left'      => '5',
                                        'unit'      => 'px',
                                    ),
                                ),


                            ),
                        ),

                        array(
                            'title' => esc_html__('Visibility', 'chat-help'),
                            'icon'  => 'icofont-eye-open',
                            'fields' => array(
                                array(
                                    'id'      => 'wooCommerce_button_visibility',
                                    'type'    => 'button_set',
                                    'title'   => esc_html__('Button Visibility', 'chat-help'),
                                    'default' => 'everywhere',
                                    'options' => array(
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


                        array(
                            'title' => esc_html__('Webhooks', 'chat-help'),
                            'icon'  => 'icofont-connection',
                            'fields' => array(
                                array(
                                    'type'    => 'subheading',
                                    'content' => 'Webhooks are automated HTTP POST requests that instantly transmit data to a specified URL when triggered by specific events. This allows applications to communicate in real time without requiring manual input. <a target="_blank" href="https://docs.themeatelier.net/docs/whatsapp-chat-help/shortcode/">Check WebHooks Documentation</a>',
                                ),
                                array(
                                    'id' => 'shortcode_webhook_url',
                                    'type' => 'text',
                                    'title' => esc_html__('Webhook URL', 'chat-help'),
                                    'title_help' => '<div class="chat-help-info-label">' . esc_html__('Clicking on the WhatsApp shortcode buttons triggers this Webhook URL.', 'chat-help') . '</div>',
                                    'class'      => 'only-for-pro',
                                ),

                                array(
                                    'id' => 'shortcode_webhook_values',
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


                            ),
                        ),

                    ),
                ),
            )
        ));
    }
}
