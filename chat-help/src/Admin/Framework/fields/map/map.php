<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: map
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'CHAT_HELP_Field_map' ) ) {
  class CHAT_HELP_Field_map extends CHAT_HELP_Fields {

    public $version = '1.9.2';
    public $cdn_url = 'https://cdn.jsdelivr.net/npm/leaflet@';

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $args              = wp_parse_args( $this->field, array(
        'placeholder'    => esc_html__( 'Search...', 'chat-help' ),
        'latitude_text'  => esc_html__( 'Latitude', 'chat-help' ),
        'longitude_text' => esc_html__( 'Longitude', 'chat-help' ),
        'address_field'  => '',
        'height'         => '',
      ) );

      $value             = wp_parse_args( $this->value, array(
        'address'        => '',
        'latitude'       => '20',
        'longitude'      => '0',
        'zoom'           => '2',
      ) );

      $default_settings   = array(
        'center'          => array( $value['latitude'], $value['longitude'] ),
        'zoom'            => $value['zoom'],
        'scrollWheelZoom' => false,
      );

      $settings = ( ! empty( $this->field['settings'] ) ) ? $this->field['settings'] : array();
      $settings = wp_parse_args( $settings, $default_settings );

      $style_attr  = ( ! empty( $args['height'] ) ) ? ' style="min-height:'. esc_attr( $args['height'] ) .';"' : '';
      $placeholder = ( ! empty( $args['placeholder'] ) ) ? array( 'placeholder' => $args['placeholder'] ) : '';

      echo wp_kses_post($this->field_before());

      if ( empty( $args['address_field'] ) ) {
        echo '<div class="chat-help--map-search">';
        echo '<input type="text" name="'. esc_attr( $this->field_name( '[address]' ) ) .'" value="'. esc_attr( $value['address'] ) .'"'. wp_kses_post($this->field_attributes( $placeholder )) .' />';
        echo '</div>';
      } else {
        echo '<div class="chat-help--address-field" data-address-field="'. esc_attr( $args['address_field'] ) .'"></div>';
      }

      echo '<div class="chat-help--map-osm-wrap"><div class="chat-help--map-osm" data-map="'. esc_attr( wp_json_encode( $settings ) ) .'"'. wp_kses_post($style_attr) .'></div></div>';

      echo '<div class="chat-help--map-inputs">';

        echo '<div class="chat-help--map-input">';
        echo '<label>'. esc_attr( $args['latitude_text'] ) .'</label>';
        echo '<input type="text" name="'. esc_attr( $this->field_name( '[latitude]' ) ) .'" value="'. esc_attr( $value['latitude'] ) .'" class="chat-help--latitude" />';
        echo '</div>';

        echo '<div class="chat-help--map-input">';
        echo '<label>'. esc_attr( $args['longitude_text'] ) .'</label>';
        echo '<input type="text" name="'. esc_attr( $this->field_name( '[longitude]' ) ) .'" value="'. esc_attr( $value['longitude'] ) .'" class="chat-help--longitude" />';
        echo '</div>';

      echo '</div>';

      echo '<input type="hidden" name="'. esc_attr( $this->field_name( '[zoom]' ) ) .'" value="'. esc_attr( $value['zoom'] ) .'" class="chat-help--zoom" />';

      echo wp_kses_post($this->field_after());

    }

    public function enqueue() {

      if ( ! wp_script_is( 'chat-help-leaflet' ) ) {
        wp_enqueue_script( 'chat-help-leaflet', esc_url( $this->cdn_url . $this->version .'/dist/leaflet.js' ), array( 'chat-help' ), $this->version, true );
      }

      if ( ! wp_style_is( 'chat-help-leaflet' ) ) {
        wp_enqueue_style( 'chat-help-leaflet', esc_url( $this->cdn_url . $this->version .'/dist/leaflet.css' ), array(), $this->version );
      }

      if ( ! wp_script_is( 'jquery-ui-autocomplete' ) ) {
        wp_enqueue_script( 'jquery-ui-autocomplete' );
      }

    }

  }
}
