<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: radio
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'CHAT_HELP_Field_radio' ) ) {
  class CHAT_HELP_Field_radio extends CHAT_HELP_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $args = wp_parse_args( $this->field, array(
        'inline'     => false,
        'query_args' => array(),
      ) );

      $inline_class = ( $args['inline'] ) ? ' class="chat-help--inline-list"' : '';

      echo wp_kses_post($this->field_before());

      if ( isset( $this->field['options'] ) ) {

        $options = $this->field['options'];
        $options = ( is_array( $options ) ) ? $options : array_filter( $this->field_data( $options, false, $args['query_args'] ) );

        if ( is_array( $options ) && ! empty( $options ) ) {

          echo '<ul'. wp_kses_post($inline_class) .'>';

          foreach ( $options as $option_key => $option_value ) {

            if ( is_array( $option_value ) && ! empty( $option_value ) ) {

              echo '<li>';
                echo '<ul>';
                  echo '<li><strong>'. esc_attr( $option_key ) .'</strong></li>';
                  foreach ( $option_value as $sub_key => $sub_value ) {
                    $checked = ( $sub_key == $this->value ) ? ' checked' : '';
                    echo '<li>';
                    echo '<label>';
                    echo '<input type="radio" name="'. esc_attr( $this->field_name() ) .'" value="'. esc_attr( $sub_key ) .'"'. wp_kses_post($this->field_attributes()) . esc_attr( $checked ) .'/>';
                    echo '<span class="chat-help--text">'. esc_attr( $sub_value ) .'</span>';
                    echo '</label>';
                    echo '</li>';
                  }
                echo '</ul>';
              echo '</li>';

            } else {

              $checked = ( $option_key == $this->value ) ? ' checked' : '';

              echo '<li>';
              echo '<label>';
              echo '<input type="radio" name="'. esc_attr( $this->field_name() ) .'" value="'. esc_attr( $option_key ) .'"'. wp_kses_post($this->field_attributes()) . esc_attr( $checked ) .'/>';
              echo '<span class="chat-help--text">'. esc_attr( $option_value ) .'</span>';
              echo '</label>';
              echo '</li>';

            }

          }

          echo '</ul>';

        } else {

          echo ( ! empty( $this->field['empty_message'] ) ) ? esc_attr( $this->field['empty_message'] ) : esc_html__( 'No data available.', 'chat-help' );

        }

      } else {

        $label = ( isset( $this->field['label'] ) ) ? $this->field['label'] : '';
        echo '<label><input type="radio" name="'. esc_attr( $this->field_name() ) .'" value="1"'. wp_kses_post($this->field_attributes()) . esc_attr( checked( $this->value, 1, false ) ) .'/>';
        echo ( ! empty( $this->field['label'] ) ) ? '<span class="chat-help--text">'. esc_attr( $this->field['label'] ) .'</span>' : '';
        echo '</label>';

      }

      echo wp_kses_post($this->field_after());

    }

  }
}
