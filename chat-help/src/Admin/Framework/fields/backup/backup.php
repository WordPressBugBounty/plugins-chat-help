<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: backup
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'CHAT_HELP_Field_backup' ) ) {
  class CHAT_HELP_Field_backup extends CHAT_HELP_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $unique = $this->unique;
      $nonce  = wp_create_nonce( 'chat_help_backup_nonce' );
      $export = add_query_arg( array( 'action' => 'chat-help-export', 'unique' => $unique, 'nonce' => $nonce ), admin_url( 'admin-ajax.php' ) );

      echo wp_kses_post($this->field_before());

      echo '<textarea name="chat_help_import_data" class="chat-help-import-data"></textarea>';
      echo '<button type="submit" class="button button-primary chat-help-confirm chat-help-import" data-unique="'. esc_attr( $unique ) .'" data-nonce="'. esc_attr( $nonce ) .'">'. esc_html__( 'Import', 'chat-help' ) .'</button>';
      echo '<hr />';
      echo '<textarea readonly="readonly" class="chat-help-export-data">'. esc_attr( wp_json_encode( get_option( $unique ) ) ) .'</textarea>';
      echo '<a href="'. esc_url( $export ) .'" class="button button-primary chat-help-export" target="_blank">'. esc_html__( 'Export & Download', 'chat-help' ) .'</a>';
      echo '<hr />';
      echo '<button type="submit" name="chat_help_transient[reset]" value="reset" class="button chat-help-warning-primary chat-help-confirm chat-help-reset" data-unique="'. esc_attr( $unique ) .'" data-nonce="'. esc_attr( $nonce ) .'">'. esc_html__( 'Reset', 'chat-help' ) .'</button>';

      echo wp_kses_post($this->field_after());

    }

  }
}
