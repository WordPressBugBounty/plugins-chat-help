<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: spacing
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'CHAT_HELP_Field_spacing' ) ) {
  class CHAT_HELP_Field_spacing extends CHAT_HELP_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $args = wp_parse_args( $this->field, array(
        'top_icon'           => '<i class="icofont-long-arrow-up"></i>',
        'right_icon'         => '<i class="icofont-long-arrow-right"></i>',
        'bottom_icon'        => '<i class="icofont-long-arrow-down"></i>',
        'left_icon'          => '<i class="icofont-long-arrow-left"></i>',
        'all_icon'           => '<i class="icofont-drag"></i>',
        'top_placeholder'    => esc_html__( 'top', 'chat-help' ),
        'right_placeholder'  => esc_html__( 'right', 'chat-help' ),
        'bottom_placeholder' => esc_html__( 'bottom', 'chat-help' ),
        'left_placeholder'   => esc_html__( 'left', 'chat-help' ),
        'all_placeholder'    => esc_html__( 'all', 'chat-help' ),
        'top'                => true,
        'left'               => true,
        'bottom'             => true,
        'right'              => true,
        'unit'               => true,
        'show_units'         => true,
        'all'                => false,
        'units'              => array( 'px', '%', 'em' )
      ) );

      $default_values = array(
        'top'    => '',
        'right'  => '',
        'bottom' => '',
        'left'   => '',
        'all'    => '',
        'unit'   => 'px',
      );

      $value   = wp_parse_args( $this->value, $default_values );
      $unit    = ( count( $args['units'] ) === 1 && ! empty( $args['unit'] ) ) ? $args['units'][0] : '';
      $is_unit = ( ! empty( $unit ) ) ? ' chat-help--is-unit' : '';

      echo wp_kses_post($this->field_before());

      echo '<div class="chat-help--inputs" data-depend-id="'. esc_attr( $this->field['id'] ) .'">';

      if ( ! empty( $args['all'] ) ) {

        $placeholder = ( ! empty( $args['all_placeholder'] ) ) ? ' placeholder="'. esc_attr( $args['all_placeholder'] ) .'"' : '';

        echo '<div class="chat-help--input">';
        echo ( ! empty( $args['all_icon'] ) ) ? '<span class="chat-help--label chat-help--icon">'. wp_kses_post($args['all_icon']) .'</span>' : '';
        echo '<input type="number" name="'. esc_attr( $this->field_name( '[all]' ) ) .'" value="'. esc_attr( $value['all'] ) .'"'. wp_kses_post($placeholder) .' class="chat-help-input-number'. esc_attr( $is_unit ) .'" step="any" />';
        echo ( $unit ) ? '<span class="chat-help--label chat-help--unit">'. esc_attr( $args['units'][0] ) .'</span>' : '';
        echo '</div>';

      } else {

        $properties = array();

        foreach ( array( 'top', 'right', 'bottom', 'left' ) as $prop ) {
          if ( ! empty( $args[$prop] ) ) {
            $properties[] = $prop;
          }
        }

        $properties = ( $properties === array( 'right', 'left' ) ) ? array_reverse( $properties ) : $properties;

        foreach ( $properties as $property ) {

          $placeholder = ( ! empty( $args[$property.'_placeholder'] ) ) ? ' placeholder="'. esc_attr( $args[$property.'_placeholder'] ) .'"' : '';

          echo '<div class="chat-help--input">';
          echo ( ! empty( $args[$property.'_icon'] ) ) ? '<span class="chat-help--label chat-help--icon">'. wp_kses_post($args[$property.'_icon']) .'</span>' : '';
          echo '<input type="number" name="'. esc_attr( $this->field_name( '['. $property .']' ) ) .'" value="'. esc_attr( $value[$property] ) .'"'. wp_kses_post($placeholder) .' class="chat-help-input-number'. esc_attr( $is_unit ) .'" step="any" />';
          echo ( $unit ) ? '<span class="chat-help--label chat-help--unit">'. esc_attr( $args['units'][0] ) .'</span>' : '';
          echo '</div>';

        }

      }

      if ( ! empty( $args['unit'] ) && ! empty( $args['show_units'] ) && count( $args['units'] ) > 1 ) {
        echo '<div class="chat-help--input">';
        echo '<select name="'. esc_attr( $this->field_name( '[unit]' ) ) .'">';
        foreach ( $args['units'] as $unit ) {
          $selected = ( $value['unit'] === $unit ) ? ' selected' : '';
          echo '<option value="'. esc_attr( $unit ) .'"'. esc_attr( $selected ) .'>'. esc_attr( $unit ) .'</option>';
        }
        echo '</select>';
        echo '</div>';
      }

      echo '</div>';

      echo wp_kses_post($this->field_after());

    }

    public function output() {

      $output    = '';
      $element   = ( is_array( $this->field['output'] ) ) ? join( ',', $this->field['output'] ) : $this->field['output'];
      $important = ( ! empty( $this->field['output_important'] ) ) ? '!important' : '';
      $unit      = ( ! empty( $this->value['unit'] ) ) ? $this->value['unit'] : 'px';

      $mode = ( ! empty( $this->field['output_mode'] ) ) ? $this->field['output_mode'] : 'padding';

      if ( $mode === 'border-radius' || $mode === 'radius' ) {

        $top    = 'border-top-left-radius';
        $right  = 'border-top-right-radius';
        $bottom = 'border-bottom-right-radius';
        $left   = 'border-bottom-left-radius';

      } else if ( $mode === 'relative' || $mode === 'absolute' || $mode === 'none' ) {

        $top    = 'top';
        $right  = 'right';
        $bottom = 'bottom';
        $left   = 'left';

      } else {

        $top    = $mode .'-top';
        $right  = $mode .'-right';
        $bottom = $mode .'-bottom';
        $left   = $mode .'-left';

      }

      if ( ! empty( $this->field['all'] ) && isset( $this->value['all'] ) && $this->value['all'] !== '' ) {

        $output  = $element .'{';
        $output .= $top    .':'. $this->value['all'] . $unit . $important .';';
        $output .= $right  .':'. $this->value['all'] . $unit . $important .';';
        $output .= $bottom .':'. $this->value['all'] . $unit . $important .';';
        $output .= $left   .':'. $this->value['all'] . $unit . $important .';';
        $output .= '}';

      } else {

        $top    = ( isset( $this->value['top']    ) && $this->value['top']    !== '' ) ? $top    .':'. $this->value['top']    . $unit . $important .';' : '';
        $right  = ( isset( $this->value['right']  ) && $this->value['right']  !== '' ) ? $right  .':'. $this->value['right']  . $unit . $important .';' : '';
        $bottom = ( isset( $this->value['bottom'] ) && $this->value['bottom'] !== '' ) ? $bottom .':'. $this->value['bottom'] . $unit . $important .';' : '';
        $left   = ( isset( $this->value['left']   ) && $this->value['left']   !== '' ) ? $left   .':'. $this->value['left']   . $unit . $important .';' : '';

        if ( $top !== '' || $right !== '' || $bottom !== '' || $left !== '' ) {
          $output = $element .'{'. $top . $right . $bottom . $left .'}';
        }

      }

      $this->parent->output_css .= $output;

      return $output;

    }

  }
}
