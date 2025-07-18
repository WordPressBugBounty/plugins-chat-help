<?php

/**
 * Chat Help Agent Message.
 *
 * @package    chat-help
 * @subpackage chat-help/src/Frontend
 */
$agent_photo_type = isset($options['agent_photo_type']) ? $options['agent_photo_type'] : 'default';
$agent_photo_url = (isset($agent_photo['url']) && !empty($agent_photo['url'])) ? $agent_photo['url'] : '';


if($agent_photo_type === 'default') {
    $agent_photo_url = CHAT_HELP_DIR_URL . 'src/assets/image/user.webp';
} elseif($agent_photo_type === 'custom' && $agent_photo_url) {
    $agent_photo_url = $agent_photo['url'];
} elseif($agent_photo_type === 'none') {
    $agent_photo_url = '';
}

if ($agent_photo_url) {
?>
    <div class="image">
        <img src="<?php echo esc_attr($agent_photo_url); ?>" />
    </div>
<?php }
