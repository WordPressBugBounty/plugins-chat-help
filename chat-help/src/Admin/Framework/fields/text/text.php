<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: text
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'CHAT_HELP_Field_text' ) ) {
  class CHAT_HELP_Field_text extends CHAT_HELP_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $type = ( ! empty( $this->field['attributes']['type'] ) ) ? $this->field['attributes']['type'] : 'text';

      echo wp_kses_post($this->field_before());

      echo '<input type="'. esc_attr( $type ) .'" name="'. esc_attr( $this->field_name() ) .'" value="'. esc_attr( $this->value ) .'"'. wp_kses_post($this->field_attributes()) .' />';

      echo wp_kses_post($this->field_after());

    }

  }
}
