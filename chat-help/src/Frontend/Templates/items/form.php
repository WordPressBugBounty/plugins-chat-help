<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- Template files are included from inside a method, so these variables are local, not globals. Their names are part of the theme-override contract.
if (! defined('ABSPATH')) {
    die;
} // Cannot access directly.
/**
 * ChatHelp Agent Message.
 *
 * @package    chat-help
 * @subpackage chat-help/src/Frontend
 */

use ThemeAtelier\ChatHelp\Frontend\Helpers\Helpers;

$gdpr_enable = isset($options['gdpr-enable']) ? $options['gdpr-enable'] : '';
$agent_name_placeholder_text = isset($options['agent-name-placeholder-text']) ? $options['agent-name-placeholder-text'] : __('Your name?', 'chat-help');
$agent_message_placeholder_text = isset($options['agent-message-placeholder-text']) ? $options['agent-message-placeholder-text'] : __('Message', 'chat-help');
$before_chat_icon = isset($options['before-chat-icon']) ? $options['before-chat-icon'] : 'icofont-brand-whatsapp';
$chat_button_text = isset($options['chat-button-text']) ? $options['chat-button-text'] : __('Send a message', 'chat-help');
$type_of_whatsapp = isset($options['type_of_whatsapp']) ? $options['type_of_whatsapp'] : '';
$whatsapp_number = isset($options['opt-number']) ? $options['opt-number'] : '';
$whatsapp_group = isset($options['opt-group']) ? $options['opt-group'] : '';

$color_settings = isset($options['color_settings']) ? $options['color_settings'] : '';
$primary = !empty($color_settings['primary']) ? $color_settings['primary'] : '#118c7e';
$secondary = !empty($color_settings['secondary']) ? $color_settings['secondary'] : '#118c7e';
$color = '#fff';
$hover_color = '#fff';
$background = $primary;
$hover_background = $secondary;

$whats_type = ($type_of_whatsapp === 'group') ? 'group' : 'number';

// Only print the attribute that matches the selected mode; an empty
// data-number/data-group would be sent to the AJAX handler as a real value.
$gaAnalyticsAttr = sprintf('data-type="%s"', esc_attr($whats_type));

if ('group' === $whats_type) {
    if (!empty($whatsapp_group)) {
        $gaAnalyticsAttr .= sprintf(' data-group="%s"', esc_attr($whatsapp_group));
    }
} elseif (!empty($whatsapp_number)) {
    $gaAnalyticsAttr .= sprintf(' data-number="%s"', esc_attr($whatsapp_number));
}

$form_editor = isset($options['form_editor']) ? $options['form_editor'] : '';
global $product;
$product_attr = '';
if ($product) {
    $product = wc_get_product();
    $id = $product->get_id();
    $product_attr = 'data-product_attr=' . esc_attr($id) . '';
}
?>
<form
    id="wHelp_form"
    class="wHelp__popup__content" <?php echo esc_attr($product_attr); ?>
    data-button="<?php echo esc_attr($chat_button_text) ?>"
    style="--color-primary: <?php echo esc_attr($primary); ?>;--color-secondary: <?php echo esc_attr($secondary); ?>;">
    <div class="user-text">
        <?php
        if ($form_editor) {
            $chat_help_field_ids = Helpers::form_field_ids($form_editor);
            foreach ($form_editor as $field_id => $form_field) {
                $field_name = isset($form_field['field_select']) ? $form_field['field_select'] : '';

                switch ($field_name) {
                    case 'text':
                        include Helpers::chat_help_locate_template('form/text.php');
                        break;
                    case 'email':
                        include Helpers::chat_help_locate_template('form/email.php');
                        break;
                    case 'phone_number':
                        include Helpers::chat_help_locate_template('form/phone_number.php');
                        break;
                    case 'textarea':
                        include Helpers::chat_help_locate_template('form/textarea.php');
                        break;
                    case 'select':
                        include Helpers::chat_help_locate_template('form/select.php');
                        break;
                }
            }
        }
        ?>
    </div>
    <?php if ($gdpr_enable) : ?>
        <div class="wHelp--checkbox">
            <input
                id="gdpr-check"
                name="gdpr-check"
                type="checkbox"
                class="wHelp__checkbox" />
            <label for="gdpr-check">
                <?php echo wp_kses_post($gdpr_compliance_content); ?>
            </label>
        </div>
    <?php endif; ?>
    <button
        type="submit"
        class="wHelp__send-message <?php echo $gdpr_enable ? 'condition__checked' : ''; ?>"
        style="--wHelp-color-primary: <?php echo esc_attr($background) ?>;--wHelp-color-secondary:<?php echo esc_attr($hover_background) ?>;--text-color: <?php echo esc_attr($color) ?>;--text-hover-color: <?php echo esc_attr($hover_color) ?>"
        <?php echo $gaAnalyticsAttr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- each attribute value is already run through esc_attr() when $gaAnalyticsAttr is built above ?>
        target="_blank">
        <?php
        if ($before_chat_icon === 'no_icon') {
            $open_icon = '';
        } elseif (!empty($before_chat_icon)) {
            $open_icon = '<i class="' . esc_attr($before_chat_icon) . '"></i>';
        } else {
            $open_icon = '<i class="icofont-brand-whatsapp"></i>';
        }
        echo wp_kses_post($open_icon) . ' ' . esc_html($chat_button_text);
        ?>
    </button>
</form>