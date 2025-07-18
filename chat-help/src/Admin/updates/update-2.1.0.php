<?php

/**
 * Update version.
 */
update_option('chat_help_version', CHAT_HELP_VERSION);
update_option('chat_help_db_version', CHAT_HELP_VERSION);

/**
 * Convert old data keys to new ones.
 */
function chat_help_convert_old_to_new_data_2_1_0($options)
{
    $options = get_option('cwp_option');
    $opt_chat_type = !empty($options['opt-chat-type']) ? $options['opt-chat-type'] : [];
    $opt_layout_type = !empty($options['opt-layout-type']) ? $options['opt-layout-type'] : '';

    if ($opt_chat_type == 'single') {
        if ($opt_layout_type == 'agent') {
            $options['chat_layout'] = 'agent';
        } else {
            $options['chat_layout'] = 'form';
        }
        unset($opt_chat_type);
        unset($opt_layout_type);
    } else if ($opt_chat_type == 'multi') {
        $options['chat_layout'] = 'multi';
        unset($opt_chat_type);
    }

    update_option('cwp_option', $options);
}

/**
 * Update old to new data.
 */
$options = get_option('cwp_option');
if ($options) {
    chat_help_convert_old_to_new_data_2_1_0($options);
}
