<?php

if (! defined('ABSPATH')) {
	die;
	
} // Cannot access directly.
if (! class_exists('CHAT_HELP_Field_ta_help')) {
	/**
	 *
	 * Field: help
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class CHAT_HELP_Field_ta_help extends CHAT_HELP_Fields
	{

		/**
		 * Help field constructor.
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
			
			require_once CHAT_HELP_DIR_PATH . 'src/Admin/HelpPage/Help.php';
			$help = new \ThemeAtelier\ChatHelp\Admin\HelpPage\Help();
			$help->help_page_callback();
			
			echo wp_kses_post($this->field_after());
		}
	}
}
