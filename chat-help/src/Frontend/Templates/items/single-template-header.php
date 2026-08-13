<?php
if (! defined('ABSPATH')) {
    die;
} // Cannot access directly.
/**
 * Chat Whatsapp Pro Agent Message.
 *
 * @package    chat-help
 * @subpackage chat-help/src/Frontend
 */

use ThemeAtelier\ChatHelp\Frontend\Helpers\Helpers;

$header_close_icon = isset($options['header_close_icon']) ? $options['header_close_icon'] : 'yes';
?>
<div class="wHelp__popup--header
    <?php echo $header_content_position === 'center' ? 'header-center' : ''; ?>"
    style="--color-primary: <?php echo esc_attr($primary); ?>;--color-secondary: <?php echo esc_attr($secondary); ?>;">
    <?php if ($header_close_icon !== 'no') : ?>
        <span class="wHelp-popup-close" role="button" tabindex="0" aria-label="<?php echo esc_attr__('Close', 'chat-help'); ?>">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </span>
    <?php endif; ?>
    <?php include Helpers::chat_help_locate_template('items/thumbnail.php'); ?>
    <div class="info">
        <?php if ($agent_name) : ?>
            <div class="info__name"><?php echo esc_html($agent_name); ?></div>
        <?php endif;
        if ($agent_subtitle || $offline_agent_subtitle) : ?>
            <div class="info__title" data-online="<?php echo esc_attr($agent_subtitle); ?>"
                data-offline="<?php echo esc_attr($offline_agent_subtitle); ?>"><?php echo esc_html($agent_subtitle); ?></div>
        <?php endif; ?>
    </div>
</div>