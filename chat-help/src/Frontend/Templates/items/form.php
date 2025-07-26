<?php

/**
 * Chat Help Agent Message.
 *
 * @package    chat-help
 * @subpackage chat-help/src/Frontend
 */

use ThemeAtelier\ChatHelp\Helpers\Helpers;

$gdpr_enable = isset($options['gdpr-enable']) ? $options['gdpr-enable'] : '';
$agent_name_placeholder_text = isset($options['agent-name-placeholder-text']) ? $options['agent-name-placeholder-text'] : __('Your name?', 'text-domain');
$agent_message_placeholder_text = isset($options['agent-message-placeholder-text']) ? $options['agent-message-placeholder-text'] : __('Message', 'text-domain');
$before_chat_icon = isset($options['before-chat-icon']) ? $options['before-chat-icon'] : 'icofont-brand-whatsapp';
$chat_button_text = isset($options['chat-button-text']) ? $options['chat-button-text'] : __('Send a message', 'text-domain');
$chat_loading_text = isset($options['chat-button-loading-text']) ? $options['chat-button-loading-text'] : 'Redirecting...';

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
    id="form"
    class="wHelp__popup__content" <?php echo esc_attr($product_attr); ?>
    data-loading="<?php echo esc_attr($chat_loading_text) ?>" data-button="<?php echo esc_attr($chat_button_text) ?>"
    style="--color-primary: <?php echo esc_attr($primary); ?>;--color-secondary: <?php echo esc_attr($secondary); ?>;">
    <div class="user-text">
        <?php
        if ($form_editor) {
            foreach ($form_editor as $field_id => $form_field) {
                $field_name = isset($form_field['field_select']) ? $form_field['field_select'] : '';

                switch ($field_name) {
                    case 'text':
                        include Helpers::chat_help_locate_template('form/text.php');
                        break;
                    case 'textarea':
                        include Helpers::chat_help_locate_template('form/textarea.php');
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