<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: link
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'CHAT_HELP_Field_link' ) ) {
  class CHAT_HELP_Field_link extends CHAT_HELP_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $args = wp_parse_args( $this->field, array(
        'add_title'    => esc_html__( 'Add Link', 'chat-help' ),
        'edit_title'   => esc_html__( 'Edit Link', 'chat-help' ),
        'remove_title' => esc_html__( 'Remove Link', 'chat-help' ),
      ) );

      $default_values = array(
        'url'    => '',
        'text'  => '',
        'target' => '',
      );

      $value = wp_parse_args( $this->value, $default_values );

      $hidden = ( ! empty( $value['url'] ) || ! empty( $value['url'] ) || ! empty( $value['url'] ) ) ? ' hidden' : '';

      $maybe_hidden = ( empty( $hidden ) ) ? ' hidden' : '';

      echo wp_kses_post($this->field_before());

      echo '<textarea readonly="readonly" class="chat-help--link hidden"></textarea>';

      echo '<div class="'. esc_attr( $maybe_hidden ) .'"><div class="chat-help--result">'. sprintf( '{url:"%s", text:"%s", target:"%s"}', wp_kses_post($value['url']), esc_html($value['text']), wp_kses_post($value['target']) ) .'</div></div>';

      echo '<input type="hidden" name="'. esc_attr( $this->field_name( '[url]' ) ) .'" value="'. esc_attr( $value['url'] ) .'"'. wp_kses_post($this->field_attributes( array( 'class' => 'chat-help--url' ) )) .' />';
      echo '<input type="hidden" name="'. esc_attr( $this->field_name( '[text]' ) ) .'" value="'. esc_attr( $value['text'] ) .'" class="chat-help--text" />';
      echo '<input type="hidden" name="'. esc_attr( $this->field_name( '[target]' ) ) .'" value="'. esc_attr( $value['target'] ) .'" class="chat-help--target" />';

      echo '<a href="#" class="button button-primary chat-help--add'. esc_attr( $hidden ) .'">'. wp_kses_post($args['add_title']) .'</a> ';
      echo '<a href="#" class="button chat-help--edit'. esc_attr( $maybe_hidden ) .'">'. wp_kses_post($args['edit_title']) .'</a> ';
      echo '<a href="#" class="button chat-help-warning-primary chat-help--remove'. esc_attr( $maybe_hidden ) .'">'. wp_kses_post($args['remove_title']) .'</a>';

      echo wp_kses_post($this->field_after());

    }

    public function enqueue() {

      if ( ! wp_script_is( 'wplink' ) ) {
        wp_enqueue_script( 'wplink' );
      }

      if ( ! wp_script_is( 'jquery-ui-autocomplete' ) ) {
        wp_enqueue_script( 'jquery-ui-autocomplete' );
      }

      add_action( 'admin_print_footer_scripts', array( $this, 'add_wp_link_dialog' ) );

    }

    public function add_wp_link_dialog() {

      if ( ! class_exists( '_WP_Editors' ) ) {
        require_once ABSPATH . WPINC .'/class-wp-editor.php';
      }

      wp_print_styles( 'editor-buttons' );

      _WP_Editors::wp_link_dialog();

    }

  }
}
