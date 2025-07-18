<?php

/**
 * Update version.
 */
update_option('chat_help_version', CHAT_HELP_VERSION);
update_option('chat_help_db_version', CHAT_HELP_VERSION);

/**
 * Convert old data keys to new ones.
 */
function chat_help_convert_old_to_new_data_2_2_9($options)
{
    $options = get_option('cwp_option');
    $agent_photo 	= isset($options['agent-photo']) ? $options['agent-photo'] : '';
    $agent_photo_url = (isset($agent_photo['url']) && !empty($agent_photo['url'])) ? $agent_photo['url'] : '';

    if ($agent_photo_url) {
        $options['agent_photo_type'] = 'custom';
    }
    update_option('cwp_option', $options);
}

/**
 * Update old to new data.
 */
$options = get_option('cwp_option');
if ($options) {
    chat_help_convert_old_to_new_data_2_2_9($options);
}
