<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: switcher
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'CHAT_HELP_Field_switcher' ) ) {
  class CHAT_HELP_Field_switcher extends CHAT_HELP_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $active     = ( ! empty( $this->value ) ) ? ' chat-help--active' : '';
      $text_on    = ( ! empty( $this->field['text_on'] ) ) ? $this->field['text_on'] : esc_html__( 'On', 'chat-help' );
      $text_off   = ( ! empty( $this->field['text_off'] ) ) ? $this->field['text_off'] : esc_html__( 'Off', 'chat-help' );
      $text_width = ( ! empty( $this->field['text_width'] ) ) ? ' style="width: '. esc_attr( $this->field['text_width'] ) .'px;"': '';

      echo wp_kses_post($this->field_before());

      echo '<div class="chat-help--switcher'. esc_attr( $active ) .'"'. wp_kses_post($text_width) .'>';
      echo '<span class="chat-help--on">'. esc_attr( $text_on ) .'</span>';
      echo '<span class="chat-help--off">'. esc_attr( $text_off ) .'</span>';
      echo '<span class="chat-help--ball"></span>';
      echo '<input type="hidden" name="'. esc_attr( $this->field_name() ) .'" value="'. esc_attr( $this->value ) .'"'. wp_kses_post($this->field_attributes()) .' />';
      echo '</div>';

      echo ( ! empty( $this->field['label'] ) ) ? '<span class="chat-help--label">'. esc_attr( $this->field['label'] ) . '</span>' : '';

      echo wp_kses_post($this->field_after());

    }

  }
}
