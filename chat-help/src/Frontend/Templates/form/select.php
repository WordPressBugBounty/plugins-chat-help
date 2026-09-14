<?php if (! defined('ABSPATH')) {
	die;
} // Cannot access directly.

use ThemeAtelier\ChatHelp\Frontend\Helpers\Helpers;

/**
 * Select.
 *
 * This template can be overridden by copying it to plugin/chat-help/Templates/form/select.php
 *
 * @package    chat-help
 * @subpackage chat-help/src/Frontend
 */

$label = isset($form_field['label']) ? $form_field['label'] : '';
$select_default_option = isset($form_field['select_default_option']) ? $form_field['select_default_option'] : '';
$select_options = isset($form_field['select_options']) ? $form_field['select_options'] : '';
$chat_input_label = isset($options['chat_input_label']) ? $options['chat_input_label'] : false;

$dynamic_id = isset($chat_help_field_ids[$field_id]) ? $chat_help_field_ids[$field_id] : Helpers::generate_safe_field_id($label, 'chat_help_select_' . esc_attr($field_id));

if (!empty($select_options)) {
?>
    <div class="form_field">
        <?php if ($label && $chat_input_label) { ?>
            <label class="form-label" for="<?php echo esc_attr($dynamic_id); ?>"><span><?php echo esc_html($label); ?></span></label>
        <?php } ?>
        <select name="<?php echo esc_attr($dynamic_id); ?>" id="<?php echo esc_attr($dynamic_id); ?>">
            <?php if (!empty($select_default_option)) { ?>
                <option value="<?php echo esc_attr($select_default_option); ?>"><?php echo esc_html($select_default_option); ?></option>
            <?php } ?>
            <?php foreach ($select_options as $option_data) : ?>
                <?php $option_label = isset($option_data['option']) ? $option_data['option'] : ''; ?>
                <?php if ('' === $option_label) {
                    continue;
                } ?>
                <option value="<?php echo esc_attr($option_label); ?>"><?php echo esc_html($option_label); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
<?php } ?>
