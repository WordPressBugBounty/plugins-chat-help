<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: icon
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'CHAT_HELP_Field_icon' ) ) {
  class CHAT_HELP_Field_icon extends CHAT_HELP_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $args = wp_parse_args( $this->field, array(
        'button_title' => esc_html__( 'Add Icon', 'chat-help' ),
        'remove_title' => esc_html__( 'Remove Icon', 'chat-help' ),
      ) );

      echo wp_kses_post($this->field_before());

      $nonce  = wp_create_nonce( 'chat_help_icon_nonce' );
      $hidden = ( empty( $this->value ) ) ? ' hidden' : '';

      echo '<div class="chat-help-icon-select">';
      echo '<span class="chat-help-icon-preview'. esc_attr( $hidden ) .'"><i class="'. esc_attr( $this->value ) .'"></i></span>';
      echo '<a href="#" class="button button-primary chat-help-icon-add" data-nonce="'. esc_attr( $nonce ) .'">'. esc_html($args['button_title']) .'</a>';
      echo '<a href="#" class="button chat-help-warning-primary chat-help-icon-remove'. esc_attr( $hidden ) .'">'. wp_kses_post($args['remove_title']) .'</a>';
      echo '<input type="hidden" name="'. esc_attr( $this->field_name() ) .'" value="'. esc_attr( $this->value ) .'" class="chat-help-icon-value"'. wp_kses_post($this->field_attributes()) .' />';
      echo '</div>';

      echo wp_kses_post($this->field_after());

    }

    public function enqueue() {
      add_action( 'admin_footer', array( 'CHAT_HELP_Field_icon', 'add_footer_modal_icon' ) );
      add_action( 'customize_controls_print_footer_scripts', array( 'CHAT_HELP_Field_icon', 'add_footer_modal_icon' ) );
    }

    public static function add_footer_modal_icon() {
    ?>
      <div id="chat-help-modal-icon" class="chat-help-modal chat-help-modal-icon hidden">
        <div class="chat-help-modal-table">
          <div class="chat-help-modal-table-cell">
            <div class="chat-help-modal-overlay"></div>
            <div class="chat-help-modal-inner">
              <div class="chat-help-modal-title">
                <?php esc_html_e( 'Add Icon', 'chat-help' ); ?>
                <div class="chat-help-modal-close chat-help-icon-close"></div>
              </div>
              <div class="chat-help-modal-header">
                <input type="text" placeholder="<?php esc_html_e( 'Search...', 'chat-help' ); ?>" class="chat-help-icon-search" />
              </div>
              <div class="chat-help-modal-content">
                <div class="chat-help-modal-loading"><div class="chat-help-loading"></div></div>
                <div class="chat-help-modal-load"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php
    }

  }
}
