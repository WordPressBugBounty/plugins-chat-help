<?php

/**
 * Framework license field file.
 *
 * @link https://themeatelier.net
 * @since 2.0.0
 *
 * @package darkify_pro
 * @subpackage darkify_pro/Admin
 */

if (! defined('ABSPATH')) {
	die;
} // Cannot access directly.

if (! class_exists('CHAT_HELP_Field_license')) {
	/**
	 *
	 * Field: license
	 *
	 * @since 2.2.4
	 * @version 2.2.4
	 */
	class CHAT_HELP_Field_license extends CHAT_HELP_Fields
	{
		/**
		 * Field constructor.
		 *
		 * @param array  $field The field type.
		 * @param string $value The values of the field.
		 * @param string $unique The unique ID for the field.
		 * @param string $where To where show the output CSS.
		 * @param string $parent The parent args.
		 */
		public function __construct($field, $value = '', $unique = '', $where = '', $parent = '')
		{
			parent::__construct($field, $value, $unique, $where, $parent);
		}

		/**
		 * Render
		 *
		 * @return void
		 */
		public function render()
		{
			echo wp_kses_post($this->field_before());

			echo '<div class="darkify-license text-center">';
			echo '<h3>' . esc_html__('You\'re using Chat Help Lite - No License Needed. Enjoy! 🙂', 'chat-help') . '</h3>';

			echo '<p>'. esc_html__('Upgrade to Chat Help Pro and unlock all the features.', 'chat-help') . '</p>';
			echo '<a href="https://chathelp.themeatelier.net/pricing/" target="_blank" class="button-secondary">'. esc_html__('Upgrade To Pro Now', 'chat-help') . '</a>';

			echo '</div>';
			echo wp_kses_post($this->field_after());
		}
	}
}
