<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: gallery
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'CHAT_HELP_Field_gallery' ) ) {
  class CHAT_HELP_Field_gallery extends CHAT_HELP_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $args = wp_parse_args( $this->field, array(
        'add_title'   => esc_html__( 'Add Gallery', 'chat-help' ),
        'edit_title'  => esc_html__( 'Edit Gallery', 'chat-help' ),
        'clear_title' => esc_html__( 'Clear', 'chat-help' ),
      ) );

      $hidden = ( empty( $this->value ) ) ? ' hidden' : '';

      echo wp_kses_post($this->field_before());

      echo '<ul>';
      if ( ! empty( $this->value ) ) {

        $values = explode( ',', $this->value );

        foreach ( $values as $id ) {
          $attachment = wp_get_attachment_image_src( $id, 'thumbnail' );
          echo '<li><img src="'. esc_url( $attachment[0] ) .'" /></li>';
        }

      }
      echo '</ul>';

      echo '<a href="#" class="button button-primary chat-help-button">'. wp_kses_post($args['add_title']) .'</a>';
      echo '<a href="#" class="button chat-help-edit-gallery'. esc_attr( $hidden ) .'">'. wp_kses_post($args['edit_title']) .'</a>';
      echo '<a href="#" class="button chat-help-warning-primary chat-help-clear-gallery'. esc_attr( $hidden ) .'">'. wp_kses_post($args['clear_title']) .'</a>';
      echo '<input type="hidden" name="'. esc_attr( $this->field_name() ) .'" value="'. esc_attr( $this->value ) .'"'. wp_kses_post($this->field_attributes()) .'/>';

      echo wp_kses_post($this->field_after());

    }

  }
}
