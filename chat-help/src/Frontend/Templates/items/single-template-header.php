<?php

/**
 * Chat Whatsapp Pro Agent Message.
 *
 * @package    chat-help
 * @subpackage chat-help/src/Frontend
 */

use ThemeAtelier\ChatHelp\Helpers\Helpers;

?>
<div class="wHelp__popup--header 
    <?php echo $header_content_position === 'center' ? 'header-center' : ''; ?>" 
    style="--color-primary: <?php echo esc_attr($primary); ?>;--color-secondary: <?php echo esc_attr($secondary); ?>;">
    <?php include Helpers::chat_help_locate_template('items/thumbnail.php'); ?>
    <div class="info">
        <?php if ($agent_name) : ?>
            <h4 class="info__name"><?php echo esc_html($agent_name); ?></h4>
        <?php endif;
        if ($agent_subtitle) : ?>
            <p class="info__title"><?php echo esc_html($agent_subtitle); ?></p>
        <?php endif; ?>
    </div>
</div>