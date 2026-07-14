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
 * @subpackage  chat-help/src/WooCommerce
 * @author      ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Frontend;

use ThemeAtelier\ChatHelp\Frontend\Templates\WooButton;
use ThemeAtelier\ChatHelp\Frontend\Helpers\Helpers;

// don't call the file directly.
if (! defined('ABSPATH')) {
    exit;
}

/**
 * The WooCommerce class to manage all public facing stuffs.
 *
 * @since 1.0.0
 */
class WooCommerce
{
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name       The name of the plugin.
     * @param      string $version    The version of this plugin.
     */
    public function __construct()
    {
        $ch_wooCommerce = get_option('ch_wooCommerce');
        $shop_page_hide_add_to_cart_button = isset($ch_wooCommerce['shop_page_hide_add_to_cart_button']) ? $ch_wooCommerce['shop_page_hide_add_to_cart_button'] : '';
        $cart_page_button = isset($ch_wooCommerce['cart_page_button']) ? $ch_wooCommerce['cart_page_button'] : '';
        $shop_page_button = isset($ch_wooCommerce['shop_page_button']) ? $ch_wooCommerce['shop_page_button'] : '';
        $cart_page_hide_add_to_cart_button = isset($ch_wooCommerce['cart_page_hide_add_to_cart_button']) ? $ch_wooCommerce['cart_page_hide_add_to_cart_button'] : '';
        $this->shop_page_button();
        $this->product_page_button();
        $this->cart_page_button();
        $this->checkout_page_button();
        $this->thank_you_page_button();

        if ($shop_page_hide_add_to_cart_button && $shop_page_button) {
            add_action('wp_head', function () {
                if (is_shop() || is_product_category() || is_product_tag()) {
                    echo '<style>
                .add_to_cart_button,
                .product_type_simple,
                .product_type_variable,
                .product_type_external {
                    display:none !important;
                }
            </style>';
                }
            });
        }

        if ($cart_page_hide_add_to_cart_button && $cart_page_button) {
            add_action('wp_head', function () {
                if (is_cart()) {
                    echo '<style>
                .wc-proceed-to-checkout .checkout-button.button {
                    display:none !important;
                }
            </style>';
                }
            });
            add_action('woocommerce_proceed_to_checkout', function () {
                if (is_cart()) {
                    remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
                }
            }, 1);
        }
    }

    public function shop_page_button()
    {
        $shopPageButton = new WooButton();
        $ch_wooCommerce = get_option('ch_wooCommerce');

        $shop_page_button = isset($ch_wooCommerce['shop_page_button']) ? $ch_wooCommerce['shop_page_button'] : '';
        $button_position = isset($ch_wooCommerce['shop_page_button_position']) ? $ch_wooCommerce['shop_page_button_position'] : 'after';
        $position = 12;
        if ("woocommerce_after_shop_loop_item" === $button_position) {
            $position = 6;
        } elseif ("woocommerce_before_shop_loop_item" === $button_position) {
            $position = 12;
        }

        $type_of_whatsapp_woo = isset($ch_wooCommerce['shop_page_button_type_of_whatsapp']) ? $ch_wooCommerce['shop_page_button_type_of_whatsapp'] : '';
        $shop_page_number = isset($ch_wooCommerce['shop_page_button_number']) ? $ch_wooCommerce['shop_page_button_number'] : '';
        $shop_page_group = isset($ch_wooCommerce['shop_page_button_group']) ? $ch_wooCommerce['shop_page_button_group'] : '';
        // Empty fields inherit the Global Chat number/group — keeps this
        // enable-gate consistent with WooButton's render-time fallback.
        $global_whatsapp = Helpers::global_whatsapp_defaults();
        $shop_page_number = !empty($shop_page_number) ? $shop_page_number : $global_whatsapp['number'];
        $shop_page_group = !empty($shop_page_group) ? $shop_page_group : $global_whatsapp['group'];

        if ($shop_page_button) {
            if ('number' === $type_of_whatsapp_woo && !empty($shop_page_number) || ('group' === $type_of_whatsapp_woo && !empty($shop_page_group))) {
                add_action("woocommerce_after_shop_loop_item", array($shopPageButton, 'shop_page_button'), $position);
            }
        }
    }
    public function product_page_button()
    {
        $wooButton = new WooButton();
        $ch_wooCommerce = get_option('ch_wooCommerce');
        $product_page_button = isset($ch_wooCommerce['product_page_button']) ? $ch_wooCommerce['product_page_button'] : '';
        $button_position = isset($ch_wooCommerce['product_page_button_position']) ? $ch_wooCommerce['product_page_button_position'] : 'after';

        $type_of_whatsapp_woo = isset($ch_wooCommerce['product_page_button_type_of_whatsapp']) ? $ch_wooCommerce['product_page_button_type_of_whatsapp'] : '';
        $product_page_number = isset($ch_wooCommerce['product_page_button_number']) ? $ch_wooCommerce['product_page_button_number'] : '';
        $product_page_group = isset($ch_wooCommerce['product_page_button_group']) ? $ch_wooCommerce['product_page_button_group'] : '';
        // Empty fields inherit the Global Chat number/group — keeps this
        // enable-gate consistent with WooButton's render-time fallback.
        $global_whatsapp = Helpers::global_whatsapp_defaults();
        $product_page_number = !empty($product_page_number) ? $product_page_number : $global_whatsapp['number'];
        $product_page_group = !empty($product_page_group) ? $product_page_group : $global_whatsapp['group'];

        if ($product_page_button) {
            if ('number' === $type_of_whatsapp_woo && !empty($product_page_number) || ('group' === $type_of_whatsapp_woo && !empty($product_page_group))) {
                add_action($button_position, array($wooButton, 'woo_button'));
            }
        }

        if ($product_page_button) {
            if ('woocommerce_short_description_after' == $button_position) {
                if ('number' === $type_of_whatsapp_woo && !empty($product_page_number) || ('group' === $type_of_whatsapp_woo && !empty($product_page_group))) {
                    add_filter('woocommerce_short_description', function ($description) use ($wooButton) {
                        ob_start();
                        $wooButton->woo_button(); // echoes
                        $button_html = ob_get_clean();
                        return $description . $button_html;
                    }, 20);
                }
            }
        }
    }
    public function cart_page_button()
    {
        $wooButton = new WooButton();
        $ch_wooCommerce = get_option('ch_wooCommerce');

        $cart_page_button = isset($ch_wooCommerce['cart_page_button']) ? $ch_wooCommerce['cart_page_button'] : '';
        $button_position = isset($ch_wooCommerce['cart_page_button_position']) ? $ch_wooCommerce['cart_page_button_position'] : 'after';

        $type_of_whatsapp_woo = isset($ch_wooCommerce['cart_page_button_type_of_whatsapp']) ? $ch_wooCommerce['cart_page_button_type_of_whatsapp'] : '';
        $cart_page_number = isset($ch_wooCommerce['cart_page_button_number']) ? $ch_wooCommerce['cart_page_button_number'] : '';
        $cart_page_group = isset($ch_wooCommerce['cart_page_button_group']) ? $ch_wooCommerce['cart_page_button_group'] : '';
        // Empty fields inherit the Global Chat number/group — keeps this
        // enable-gate consistent with WooButton's render-time fallback.
        $global_whatsapp = Helpers::global_whatsapp_defaults();
        $cart_page_number = !empty($cart_page_number) ? $cart_page_number : $global_whatsapp['number'];
        $cart_page_group = !empty($cart_page_group) ? $cart_page_group : $global_whatsapp['group'];

        $position = 25;
        if ("after" === $button_position) {
            $position = 25;
        } elseif ("before" === $button_position) {
            $position = 0;
        }

        if ($cart_page_button) {
            if ('number' === $type_of_whatsapp_woo && !empty($cart_page_number) || ('group' === $type_of_whatsapp_woo && !empty($cart_page_group))) {
                $this->cart_block_position = $button_position;

                // Classic (shortcode) cart: render above/below the proceed button.
                add_action("woocommerce_proceed_to_checkout", array($wooButton, 'cart_page_button'), $position);

                // Block-based cart: woocommerce_proceed_to_checkout never fires, so
                // inject the button next to the block "Proceed to Checkout" button
                // via JS. The injector is a no-op on a classic cart, so the two
                // paths never both render.
                add_action('wp_enqueue_scripts', array($this, 'enqueue_cart_block_button'), 20);
            }
        }
    }

    /**
     * The cart button position option, used by the block-cart injector.
     *
     * @var string
     */
    protected $cart_block_position = 'after';
    public function checkout_page_button()
    {
        $wooButton = new WooButton();
        $ch_wooCommerce = get_option('ch_wooCommerce');

        $checkout_page_button = isset($ch_wooCommerce['checkout_page_button']) ? $ch_wooCommerce['checkout_page_button'] : '';
        $button_position = isset($ch_wooCommerce['checkout_page_button_position']) ? $ch_wooCommerce['checkout_page_button_position'] : 'after';

        $type_of_whatsapp_woo = isset($ch_wooCommerce['checkout_page_button_type_of_whatsapp']) ? $ch_wooCommerce['checkout_page_button_type_of_whatsapp'] : '';
        $checkout_page_number = isset($ch_wooCommerce['checkout_page_button_number']) ? $ch_wooCommerce['checkout_page_button_number'] : '';
        $checkout_page_group = isset($ch_wooCommerce['checkout_page_button_group']) ? $ch_wooCommerce['checkout_page_button_group'] : '';
        // Empty fields inherit the Global Chat number/group — keeps this
        // enable-gate consistent with WooButton's render-time fallback.
        $global_whatsapp = Helpers::global_whatsapp_defaults();
        $checkout_page_number = !empty($checkout_page_number) ? $checkout_page_number : $global_whatsapp['number'];
        $checkout_page_group = !empty($checkout_page_group) ? $checkout_page_group : $global_whatsapp['group'];

        if ($checkout_page_button) {
            if ('number' === $type_of_whatsapp_woo && !empty($checkout_page_number) || ('group' === $type_of_whatsapp_woo && !empty($checkout_page_group))) {
                $this->checkout_block_position = $button_position;

                // Both paths are registered unconditionally because they are
                // mutually exclusive and self-detecting, which avoids relying on
                // fragile page/block detection:
                //
                // 1) Classic (shortcode) checkout: the legacy action only fires
                //    when the shortcode renders the order review.
                add_action($button_position, array($wooButton, 'checkout_page_button'));

                // 2) Block checkout (WooCommerce Checkout block): the classic
                //    actions never fire, and altering the block's server-rendered
                //    markup breaks the React app that replaces it. We inject the
                //    button into the DOM *after* the checkout has rendered. The
                //    injector is a no-op unless the block's actions row exists,
                //    so it never double-renders on a classic checkout.
                add_action('wp_enqueue_scripts', array($this, 'enqueue_checkout_block_button'), 20);
            }
        }
    }

    /**
     * The checkout button position option, used by the block-checkout injector.
     *
     * @var string
     */
    protected $checkout_block_position = 'woocommerce_review_order_after_submit';

    /**
     * Inject the WhatsApp button into the WooCommerce Checkout block via JS.
     *
     * The block checkout is a React app that swaps out its own server-rendered
     * placeholder, so the button cannot be printed into the markup server-side
     * without breaking that process. We render the button HTML once, hand it to
     * a small vanilla script, and insert it next to the "Place Order" actions
     * row only after the app has mounted. No PHP hook touches the form, and the
     * button uses normal flow positioning (no absolute/fixed/z-index).
     *
     * @return void
     */
    public function enqueue_checkout_block_button()
    {
        if (function_exists('is_checkout') && ! is_checkout()) {
            return;
        }

        $wooButton = new WooButton();
        ob_start();
        $wooButton->checkout_page_button();
        $button_html = trim((string) ob_get_clean());

        if ('' === $button_html) {
            return;
        }

        $before = ('woocommerce_review_order_before_submit' === $this->checkout_block_position);

        // Prefer the actions row; fall back to the Place Order button so we stay
        // compatible across WooCommerce Blocks markup changes.
        $this->print_block_button_script(
            $button_html,
            $before,
            array('.wc-block-checkout__actions_row', '.wc-block-components-checkout-place-order-button'),
            'ch-checkout-block-button',
            '.wp-block-woocommerce-checkout'
        );
    }

    /**
     * Inject the WhatsApp button into the WooCommerce Cart block via JS.
     *
     * Mirrors the checkout injector: the block cart is a React app, so we add
     * the button to the DOM next to the "Proceed to Checkout" button after it
     * mounts instead of altering server markup. Only runs on the cart page and
     * is a no-op on a classic cart (where the proceed button selectors are
     * absent), so it never double-renders.
     *
     * @return void
     */
    public function enqueue_cart_block_button()
    {
        if (function_exists('is_cart') && ! is_cart()) {
            return;
        }

        $wooButton = new WooButton();
        ob_start();
        $wooButton->cart_page_button();
        $button_html = trim((string) ob_get_clean());

        if ('' === $button_html) {
            return;
        }

        // "before" places the button above the Proceed to Checkout button.
        $before = ('before' === $this->cart_block_position);

        $this->print_block_button_script(
            $button_html,
            $before,
            array('.wc-block-cart__submit-button', '.wc-block-cart__submit-container', '.wp-block-woocommerce-proceed-to-checkout-block'),
            'ch-cart-block-button',
            '.wp-block-woocommerce-cart'
        );
    }

    /**
     * Build and output the DOM-injection script for a block-based WC page.
     *
     * The button is inserted as a normal-flow sibling next to the first anchor
     * selector that matches (no absolute/fixed positioning, no z-index). A
     * MutationObserver re-inserts it if the block app re-renders on AJAX cart,
     * shipping or payment updates.
     *
     * @param string   $button_html   Pre-rendered, already-escaped button HTML.
     * @param bool      $before        Insert before the anchor (true) or after (false).
     * @param string[] $selectors     Anchor selectors, tried in order.
     * @param string   $wrap_class    Wrapper class (also the de-dupe marker).
     * @param string   $root_selector Container to observe for re-renders.
     * @return void
     */
    protected function print_block_button_script($button_html, $before, array $selectors, $wrap_class, $root_selector)
    {
        $cfg = wp_json_encode(array(
            'html'   => $button_html,
            'before' => (bool) $before,
            'sel'    => array_values($selectors),
            'cls'    => $wrap_class,
            'root'   => $root_selector,
        ));

        $script = '(function(){'
            . 'var cfg=' . $cfg . ';'
            . 'function anchor(){for(var i=0;i<cfg.sel.length;i++){var e=document.querySelector(cfg.sel[i]);if(e)return e;}return null;}'
            . 'function inject(){'
            . 'var a=anchor();'
            . 'if(!a||!a.parentNode)return;'
            . 'if(a.parentNode.querySelector(":scope > ."+cfg.cls))return;'
            . 'var w=document.createElement("div");'
            . 'w.className=cfg.cls;'
            . 'w.innerHTML=cfg.html;'
            . 'if(cfg.before){a.parentNode.insertBefore(w,a);}'
            . 'else{a.parentNode.insertBefore(w,a.nextSibling);}'
            . '}'
            . 'function watch(){'
            . 'inject();'
            . 'var t=(cfg.root&&document.querySelector(cfg.root))||document.body;'
            . 'var o=new MutationObserver(function(){inject();});'
            . 'o.observe(t,{childList:true,subtree:true});'
            . '}'
            . 'if(document.readyState==="loading"){document.addEventListener("DOMContentLoaded",watch);}else{watch();}'
            . '})();';

        if (wp_script_is('chat-help-script', 'enqueued') || wp_script_is('chat-help-script', 'registered')) {
            wp_add_inline_script('chat-help-script', $script);
        } else {
            // Fallback: print directly in the footer if the handle is unavailable.
            add_action('wp_footer', function () use ($script) {
                echo '<script>' . $script . '</script>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }, 99);
        }
    }
    public function thank_you_page_button()
    {
        $wooButton = new WooButton();
        $ch_wooCommerce = get_option('ch_wooCommerce');

        $thank_you_page_button = isset($ch_wooCommerce['thank_you_page_button']) ? $ch_wooCommerce['thank_you_page_button'] : '';

        $type_of_whatsapp_woo = isset($ch_wooCommerce['thank_you_page_button_type_of_whatsapp']) ? $ch_wooCommerce['thank_you_page_button_type_of_whatsapp'] : '';
        $thank_you_page_number = isset($ch_wooCommerce['thank_you_page_button_number']) ? $ch_wooCommerce['thank_you_page_button_number'] : '';
        $thank_you_page_group = isset($ch_wooCommerce['thank_you_page_button_group']) ? $ch_wooCommerce['thank_you_page_button_group'] : '';
        // Empty fields inherit the Global Chat number/group — keeps this
        // enable-gate consistent with WooButton's render-time fallback.
        $global_whatsapp = Helpers::global_whatsapp_defaults();
        $thank_you_page_number = !empty($thank_you_page_number) ? $thank_you_page_number : $global_whatsapp['number'];
        $thank_you_page_group = !empty($thank_you_page_group) ? $thank_you_page_group : $global_whatsapp['group'];

        if ($thank_you_page_button) {
            if ('number' === $type_of_whatsapp_woo && !empty($thank_you_page_number) || ('group' === $type_of_whatsapp_woo && !empty($thank_you_page_group))) {
                add_action('woocommerce_thankyou_order_received_text', array($wooButton, 'thank_you_page_button'), 10, 2);
            }
        }
    }
}
