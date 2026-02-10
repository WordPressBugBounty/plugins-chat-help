<?php
if (! defined('ABSPATH')) {
    die;
} // Cannot access directly.
/**
 * Chat Whatsapp Agent Message.
 *
 * @package    chat-help
 * @subpackage chat-help/src/Frontend
 */

use ThemeAtelier\ChatHelp\Frontend\Helpers\Helpers;

$open_in_new_tab = isset($ch_settings['open_in_new_tab']) ? $ch_settings['open_in_new_tab'] : '';
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
    style="--wHelp-color-primary: <?php echo esc_attr($background) ?>;--wHelp-color-secondary:<?php echo esc_attr($hover_background) ?>;--text-color: <?php echo esc_attr($color) ?>;--text-hover-color: <?php echo esc_attr($hover_color) ?>">

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

    $url_for_desktop = isset($ch_settings['url_for_desktop']) ? $ch_settings['url_for_desktop'] : '';
    $url_for_mobile = isset($ch_settings['url_for_mobile']) ? $ch_settings['url_for_mobile'] : '';
    $message = isset($options['prefilled_message']) ? $options['prefilled_message'] : '';
    $message = Helpers::replacement_vars($message);
    $url = Helpers::whatsAppUrl($whatsapp_number,  $type_of_whatsapp, $whatsapp_group, $url_for_desktop, $url_for_mobile, $message);

    $open_in_new_tab = $open_in_new_tab ? '_blank' : '_self';
    echo '<a href="' . esc_attr($url) . '" target="' . esc_attr($open_in_new_tab) . '"></a>';
    ?>
</div>
</div>