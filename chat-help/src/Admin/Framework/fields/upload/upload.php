<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: upload
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'CHAT_HELP_Field_upload' ) ) {
  class CHAT_HELP_Field_upload extends CHAT_HELP_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $args = wp_parse_args( $this->field, array(
        'library'        => array(),
        'preview'        => false,
        'preview_width'  => '',
        'preview_height' => '',
        'button_title'   => esc_html__( 'Upload', 'chat-help' ),
        'remove_title'   => esc_html__( 'Remove', 'chat-help' ),
      ) );

      echo wp_kses_post($this->field_before());

      $library = ( is_array( $args['library'] ) ) ? $args['library'] : array_filter( (array) $args['library'] );
      $library = ( ! empty( $library ) ) ? implode(',', $library ) : '';
      $hidden  = ( empty( $this->value ) ) ? ' hidden' : '';

      if ( ! empty( $args['preview'] ) ) {

        $preview_type   = ( ! empty( $this->value ) ) ? strtolower( substr( strrchr( $this->value, '.' ), 1 ) ) : '';
        $preview_src    = ( ! empty( $preview_type ) && in_array( $preview_type, array( 'jpg', 'jpeg', 'gif', 'png', 'svg', 'webp' ) ) ) ? $this->value : '';
        $preview_width  = ( ! empty( $args['preview_width'] ) ) ? 'max-width:'. esc_attr( $args['preview_width'] ) .'px;' : '';
        $preview_height = ( ! empty( $args['preview_height'] ) ) ? 'max-height:'. esc_attr( $args['preview_height'] ) .'px;' : '';
        $preview_style  = ( ! empty( $preview_width ) || ! empty( $preview_height ) ) ? ' style="'. esc_attr( $preview_width . $preview_height ) .'"': '';
        $preview_hidden = ( empty( $preview_src ) ) ? ' hidden' : '';

        echo '<div class="chat-help--preview'. esc_attr( $preview_hidden ) .'">';
        echo '<div class="chat-help-image-preview"'. wp_kses_post($preview_style) .'>';
        echo '<i class="chat-help--remove icofont-close"></i><span><img src="'. esc_url( $preview_src ) .'" class="chat-help--src" /></span>';
        echo '</div>';
        echo '</div>';

      }

      echo '<div class="chat-help--wrap">';
      echo '<input type="text" name="'. esc_attr( $this->field_name() ) .'" value="'. esc_attr( $this->value ) .'"'. wp_kses_post($this->field_attributes()) .'/>';
      echo '<a href="#" class="button button-primary chat-help--button" data-library="'. esc_attr( $library ) .'">'. esc_html($args['button_title']) .'</a>';
      echo '<a href="#" class="button button-secondary chat-help-warning-primary chat-help--remove'. esc_attr( $hidden ) .'">'. wp_kses_post($args['remove_title']) .'</a>';
      echo '</div>';

      echo wp_kses_post($this->field_after());

    }
  }
}
