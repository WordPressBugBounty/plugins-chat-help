<?php

/**
 * Text.
 *
 * This template can be overridden by copying it to plugin/chat-help/Templates/form/textarea.php
 *
 * @package    chat-help
 * @subpackage chat-help/src/Frontend
 */

$label = isset($form_field['label']) ? $form_field['label'] : '';
$placeholder = isset($form_field['placeholder']) ? $form_field['placeholder'] : '';
$required = !empty($form_field['required']) ? 'required' : '';
$custom_validation_message = isset($form_field['custom_validation_message']) ? $form_field['custom_validation_message'] : '';
$chat_input_label = isset($options['chat_input_label']) ? $options['chat_input_label'] : '';
?>
<div class="form_field">
    <?php if ($label && $chat_input_label ) { ?>
        <label class="form-label" for="chat_help_textarea_<?php echo esc_attr($field_id); ?>"><span><?php echo esc_html($label);
                                                                                                    echo $required ? '<span>*</span>' : '';  ?></span></label>
    <?php } ?>
    <textarea type="text" title="<?php echo esc_attr($custom_validation_message) ?>" rows="4" id="chat_help_textarea_<?php echo esc_attr($field_id); ?>" name="chat_help_textarea_<?php echo esc_attr($field_id) ?>" <?php echo esc_html($required); ?> placeholder="<?php echo esc_html($placeholder); ?>"></textarea>
</div>