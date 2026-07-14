<?php

/**
 * Shared "WhatsApp Number" / "WhatsApp Group" field definitions.
 *
 * Every settings page that asks for a WhatsApp destination — Global Chat,
 * each per-widget layout, and every WooCommerce page (Shop, Product, Cart,
 * Checkout, Thank You) — renders through the same `WhatsAppNumberInput` /
 * `WhatsAppGroupInput` React components (matched by field `type` + `id` in
 * FieldRenderer.jsx), but until now each page also hand-copied its own
 * title/description text, which had drifted out of sync between pages. These
 * two factories are the single source of truth for that copy, so every call
 * site stays identical and future wording changes only need to happen once.
 *
 * @link       https://themeatelier.net
 * @since      3.5.0
 *
 * @package    chat-help
 * @subpackage chat-help/src/Admin/Views/Fields
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\ChatHelp\Admin\Views\Fields;

if (! defined('ABSPATH')) {
    die;
}

class WhatsAppFields
{
    /**
     * @param string $id         Field id (e.g. `opt-number`, `shop_page_button_number`).
     * @param array  $dependency Framework dependency array controlling visibility.
     * @param string $class      Framework CSS class (kept consistent across all call sites).
     */
    public static function number(string $id, array $dependency, string $class = 'chat_help_number'): array
    {
        return array(
            'id'         => $id,
            'class'      => $class,
            'type'       => 'text',
            'title'      => esc_html__('WhatsApp Number', 'chat-help'),
            'title_help' => '<div class="chat-help-info-label">' . esc_html__('Add your WhatsApp number including the country code (e.g., +880123456189).', 'chat-help') . '</div> <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/how-should-i-enter-my-whatsapp-number-in-the-plugin/?ref=1">' . esc_html__('Detailed explanation', 'chat-help') . '</a>',
            'dependency' => $dependency,
        );
    }

    /**
     * @param string $id         Field id (e.g. `opt-group`, `shop_page_button_group`).
     * @param array  $dependency Framework dependency array controlling visibility.
     * @param string $class      Framework CSS class (kept consistent across all call sites).
     */
    public static function group(string $id, array $dependency, string $class = 'chat_help_group'): array
    {
        return array(
            'id'         => $id,
            'type'       => 'text',
            'class'      => $class,
            'title'      => esc_html__('WhatsApp Group', 'chat-help'),
            'title_help' => '<div class="chat-help-info-label">' . esc_html__('Invite your visitors to join your WhatsApp group by adding the group’s invite URL here.', 'chat-help') . '</div> <a class="tooltip_btn_primary" target="_blank" href="' . CHAT_HELP_DEMO_URL . 'docs/how-do-i-create-a-whatsapp-group-and-invite-members/?ref=1">' . esc_html__('Detailed explanation', 'chat-help') . '</a>',
            'dependency' => $dependency,
        );
    }
}
