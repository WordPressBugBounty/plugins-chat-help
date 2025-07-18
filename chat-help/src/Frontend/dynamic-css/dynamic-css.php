<?php
/**
 * Dynamic CSS
 *
 * @package    idonate-pro
 * @subpackage idonate-pro/src
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$options = get_option( 'cwp_option' );
$bubble_button_tooltip_background = isset($options['bubble_button_tooltip_background']) ? $options['bubble_button_tooltip_background'] : '#f5f7f9';
$bubble_button_tooltip_width = isset( $options['bubble_button_tooltip_width'] ) ? $options['bubble_button_tooltip_width'] : 185;
$bubble_position = isset( $options['bubble-position'] ) ? $options['bubble-position'] : 'right_bottom';
// Right
$right_bottom           = isset( $options['right_bottom'] ) ? $options['right_bottom'] : array();
$right_bottom_value_bottom = isset( $right_bottom['bottom'] ) ? $right_bottom['bottom'] : '30';
$right_bottom_value_right  = isset( $right_bottom['right'] ) ? $right_bottom['right'] : '30';
$right_bottom_unit        = isset( $right_bottom['unit'] ) ? $right_bottom['unit'] : 'px';

// Left
$left_bottom              = isset( $options['left_bottom'] ) ? $options['left_bottom'] : array();
$left_bottom_value_bottom = isset( $left_bottom['bottom'] ) ? $left_bottom['bottom'] : '30';
$left_bottom_value_left   = isset( $left_bottom['left'] ) ? $left_bottom['left'] : '30';
$left_bottom_unit         = isset( $left_bottom['unit'] ) ? $left_bottom['unit'] : 'px';

// Bubble button style
$bubble_button_style = isset($options['opt-button-style']) ? $options['opt-button-style'] : "1";

// Bubble button paddings
$bubble_button_padding = isset($options['bubble-button-padding']) ? $options['bubble-button-padding'] : array();
$bubble_button_padding_top =  isset($bubble_button_padding['top']) ? $bubble_button_padding['top'] : '5';
$bubble_button_padding_right =  isset($bubble_button_padding['right']) ? $bubble_button_padding['right'] : '10';
$bubble_button_padding_bottom =  isset($bubble_button_padding['bottom']) ? $bubble_button_padding['bottom'] : '5';
$bubble_button_padding_left =  isset($bubble_button_padding['left']) ? $bubble_button_padding['left'] : '10';
$bubble_button_padding_unit = isset($bubble_button_padding['unit']) ? $bubble_button_padding['unit'] : 'px';

if ( 'right_bottom' === $bubble_position ) {
    $custom_css .= ".wHelp {bottom: {$right_bottom_value_bottom}{$right_bottom_unit};right: {$right_bottom_value_right}{$right_bottom_unit};}.wHelp__popup{right: 0;}.wHelp .tooltip_text{right:100%;left:auto; margin-right: 12px;}";
}
if ( 'left_bottom' === $bubble_position ) {
    $custom_css .= ".wHelp{left: {$left_bottom_value_left}{$left_bottom_unit};}.wHelp{ bottom: {$left_bottom_value_bottom}{$left_bottom_unit};}.wHelp__popup{left: 0}.wHelp .tooltip_text{left:100%;right:auto; margin-left: 12px;}";
}

$custom_css .= ".wHelp .tooltip_text, .wHelp-multi .tooltip_text {width: {$bubble_button_tooltip_width}px; background-color: {$bubble_button_tooltip_background};} .wHelp .tooltip_text::after, .wHelp-multi .tooltip_text::after{background-color: {$bubble_button_tooltip_background};}";
if(!('1' == $bubble_button_style)) {
$custom_css .= ".wHelp .wHelp-bubble.bubble{padding-top:{$bubble_button_padding_top}{$bubble_button_padding_unit};padding-right:{$bubble_button_padding_right}{$bubble_button_padding_unit};padding-bottom:{$bubble_button_padding_bottom}{$bubble_button_padding_unit};padding-left:{$bubble_button_padding_left}{$bubble_button_padding_unit}";
}