<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: sorter
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'CHAT_HELP_Field_sorter' ) ) {
  class CHAT_HELP_Field_sorter extends CHAT_HELP_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $args = wp_parse_args( $this->field, array(
        'disabled'       => true,
        'enabled_title'  => esc_html__( 'Enabled', 'chat-help' ),
        'disabled_title' => esc_html__( 'Disabled', 'chat-help' ),
      ) );

      echo wp_kses_post($this->field_before());

      $this->value      = ( ! empty( $this->value ) ) ? $this->value : $this->field['default'];
      $enabled_options  = ( ! empty( $this->value['enabled'] ) ) ? $this->value['enabled'] : array();
      $disabled_options = ( ! empty( $this->value['disabled'] ) ) ? $this->value['disabled'] : array();

      echo '<div class="chat-help-sorter" data-depend-id="'. esc_attr( $this->field['id'] ) .'"></div>';

      echo ( $args['disabled'] ) ? '<div class="chat-help-modules">' : '';

      echo ( ! empty( $args['enabled_title'] ) ) ? '<div class="chat-help-sorter-title">'. esc_attr( $args['enabled_title'] ) .'</div>' : '';
      echo '<ul class="chat-help-enabled">';
      if ( ! empty( $enabled_options ) ) {
        foreach ( $enabled_options as $key => $value ) {
          echo '<li><input type="hidden" name="'. esc_attr( $this->field_name( '[enabled]['. $key .']' ) ) .'" value="'. esc_attr( $value ) .'"/><label>'. esc_attr( $value ) .'</label></li>';
        }
      }
      echo '</ul>';

      // Check for hide/show disabled section
      if ( $args['disabled'] ) {

        echo '</div>';

        echo '<div class="chat-help-modules">';
        echo ( ! empty( $args['disabled_title'] ) ) ? '<div class="chat-help-sorter-title">'. esc_attr( $args['disabled_title'] ) .'</div>' : '';
        echo '<ul class="chat-help-disabled">';
        if ( ! empty( $disabled_options ) ) {
          foreach ( $disabled_options as $key => $value ) {
          echo '<li><input type="hidden" name="'. esc_attr( $this->field_name( '[disabled]['. $key .']' ) ) .'" value="'. esc_attr( $value ) .'"/><label>'. esc_attr( $value ) .'</label></li>';
          }
        }
        echo '</ul>';
        echo '</div>';

      }


      echo wp_kses_post($this->field_after());

    }

    public function enqueue() {

      if ( ! wp_script_is( 'jquery-ui-sortable' ) ) {
        wp_enqueue_script( 'jquery-ui-sortable' );
      }

    }

  }
}
