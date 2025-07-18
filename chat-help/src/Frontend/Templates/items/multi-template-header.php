<?php

/**
 * Chat Whatsapp Pro Agent Message.
 *
 * @package    chat-help
 * @subpackage chat-help/src/Frontend
 */

use ThemeAtelier\ChatHelp\Helpers\Helpers;

if ($bubble_title || $bubble_subtitle) : ?>
    <div class="wHelp-multi__popup--header">
        <?php if ($bubble_title) : ?>
            <h3 class="title"><?php echo esc_html($bubble_title); ?></h3>
        <?php endif;
        if ($bubble_subtitle) : ?>
            <p class="subtitle"><?php echo esc_html($bubble_subtitle); ?></p>
        <?php endif; ?>
    </div>
<?php endif; ?>