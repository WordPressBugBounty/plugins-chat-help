<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: sortable
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
use ThemeAtelier\ChatHelp\Admin\Framework\Classes\Chat_Help;

if ( ! class_exists( 'CHAT_HELP_Field_sortable' ) ) {
  class CHAT_HELP_Field_sortable extends CHAT_HELP_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      echo wp_kses_post($this->field_before());

      echo '<div class="chat-help-sortable" data-depend-id="'. esc_attr( $this->field['id'] ) .'">';

      $pre_sortby = array();
      $pre_fields = array();

      // Add array-keys to defined fields for sort by
      foreach ( $this->field['fields'] as $key => $field ) {
        $pre_fields[$field['id']] = $field;
      }

      // Set sort by by saved-value or default-value
      if ( ! empty( $this->value ) ) {

        foreach ( $this->value as $key => $value ) {
          $pre_sortby[$key] = $pre_fields[$key];
        }

        $diff = array_diff_key( $pre_fields, $this->value );

        if( ! empty( $diff ) ) {
          $pre_sortby = array_merge( $pre_sortby, $diff );
        }

      } else {

        foreach ( $pre_fields as $key => $value ) {
          $pre_sortby[$key] = $value;
        }

      }

      foreach ( $pre_sortby as $key => $field ) {

        echo '<div class="chat-help-sortable-item">';

          echo '<div class="chat-help-sortable-content">';

          $field_default = ( isset( $this->field['default'][$key] ) ) ? $this->field['default'][$key] : '';
          $field_value   = ( isset( $this->value[$key] ) ) ? $this->value[$key] : $field_default;
          $unique_id     = ( ! empty( $this->unique ) ) ? $this->unique .'['. $this->field['id'] .']' : $this->field['id'];

          Chat_Help::field( $field, $field_value, $unique_id, 'field/sortable' );

          echo '</div>';

          echo '<div class="chat-help-sortable-helper"><i class="icofont-drag"></i></div>';

        echo '</div>';

      }

      echo '</div>';

      echo wp_kses_post($this->field_after());

    }

    public function enqueue() {

      if ( ! wp_script_is( 'jquery-ui-sortable' ) ) {
        wp_enqueue_script( 'jquery-ui-sortable' );
      }

    }

  }
}
