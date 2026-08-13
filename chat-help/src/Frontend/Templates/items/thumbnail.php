<?php
if (! defined('ABSPATH')) {
    die;
} // Cannot access directly.

use ThemeAtelier\ChatHelp\Frontend\Helpers\Helpers;

/**
 * ChatHelp Agent Message.
 *
 * @package    chat-help
 * @subpackage chat-help/src/Frontend
 */
$agent_photo_type = isset($options['agent_photo_type']) ? $options['agent_photo_type'] : 'default';
$agent_photo_url = (isset($agent_photo['url']) && !empty($agent_photo['url'])) ? $agent_photo['url'] : '';

if ($agent_photo_type === 'custom' && $agent_photo_url) {
    $agent_photo_url = $agent_photo['url'];
} elseif ($agent_photo_type === 'none') {
    $agent_photo_url = '';
}

if ($agent_photo_type === 'none') {
    return;
}

if ($agent_photo_type === 'default' || empty($agent_photo_url)) {
    $agent_initials = Helpers::agent_initials(isset($agent_name) ? $agent_name : '');
?>
    <div class="image">
        <div class="chat_help_avatar_initials"><?php echo esc_html($agent_initials); ?></div>
    </div>
<?php
} else {
?>
    <div class="image">
        <img src="<?php echo esc_attr($agent_photo_url); ?>" />
    </div>
<?php
}
