<?php

/**
 * Chat Whatsapp Agent Message.
 *
 * @package    chat-help
 * @subpackage chat-help/src/Frontend
 */

use ThemeAtelier\ChatHelp\Helpers\Helpers;

$open_in_new_tab = isset($options['open_in_new_tab']) ? $options['open_in_new_tab'] : '';
echo '<div class="wHelp__popup__content">';
if ($show_current_time) {
    echo '<div class="current-time"></div>';
}
if ($agent_message) : ?>
<?php 
    $replaced_message = Helpers::replacement_vars($agent_message);
?>
    <div class="sms">
        <div class="sms__text">
            <p>
                <?php echo wp_kses_post($replaced_message); ?>
            </p>
        </div>
    </div>
<?php endif;
if ($gdpr_enable) : ?>
    <div class="wHelp--checkbox">
        <input id="gdpr-check" name="gdpr-check" type="checkbox" class="wHelp__checkbox" />
        <label for="gdpr-check"><?php echo wp_kses_post($gdpr_compliance_content); ?></label>
    </div>
<?php endif; ?>
<div
    class="wHelp__send-message <?php echo $gdpr_enable ? 'condition__checked' : ''; ?>"
    target="_blank"
    type="submit"
    <?php echo esc_attr($gaAnalyticsAttr) ?>
    style="--color-primary: <?php echo esc_attr($primary); ?>;--color-secondary: <?php echo esc_attr($secondary); ?>;">

    <?php
    if ($before_chat_icon === 'no_icon') {
        $open_icon = '';
    } elseif (!empty($before_chat_icon)) {
        $open_icon = '<i class="' . esc_attr($before_chat_icon) . '"></i>';
    } else {
        $open_icon = '<i class="icofont-brand-whatsapp"></i>';
    }

    echo wp_kses_post($open_icon) . ' ' . esc_html($chat_button_text);

    $type_of_whatsapp = isset($options['type_of_whatsapp']) ? $options['type_of_whatsapp'] : '';
    $whatsapp_number = isset($options['opt-number']) ? $options['opt-number'] : '';
    $whatsapp_group = isset($options['opt-group']) ? $options['opt-group'] : '';

    $url_for_desktop = isset($options['url_for_desktop']) ? $options['url_for_desktop'] : '';
    $url_for_mobile = isset($options['url_for_mobile']) ? $options['url_for_mobile'] : '';
    $message = isset($options['prefilled_message']) ? $options['prefilled_message'] : '';
    $message = Helpers::replacement_vars($message);
    $url = Helpers::whatsAppUrl( $whatsapp_number,  $type_of_whatsapp,$whatsapp_group, $url_for_desktop, $url_for_mobile, $message);

    $open_in_new_tab = $open_in_new_tab ? '_blank' : '_self';
    echo '<a href="' . esc_attr($url) . '" target="' . $open_in_new_tab . '"></a>';
    ?>
</div>
</div>