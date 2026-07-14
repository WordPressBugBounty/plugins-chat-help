<?php

/**
 * The main class for Settings configurations.
 *
 * @package chat-help-por
 * @subpackage chat-help-por/src/Admin/Views
 */

namespace ThemeAtelier\ChatHelp\Admin\Views;

use ThemeAtelier\ChatHelp\Admin\Schema\SchemaRegistry;
use ThemeAtelier\ChatHelp\Frontend\Helpers\Helpers;

if (! defined('ABSPATH')) {
	die;
}

/**
 * Settings.
 */
class AssignWidget
{
	/**
	 * Returns all terms from all public taxonomies for the taxonomy terms selector.
	 *
	 * @return array term_id => "Taxonomy Label: Term Name"
	 */
	public static function get_all_taxonomy_terms()
	{
		$options    = array();
		$taxonomies = get_taxonomies(array('public' => true), 'objects');
		foreach ($taxonomies as $tax) {
			$terms = get_terms(array('taxonomy' => $tax->name, 'hide_empty' => false));
			if (is_wp_error($terms) || empty($terms)) {
				continue;
			}
			foreach ($terms as $term) {
				$options[$term->term_id] = $tax->label . ': ' . $term->name;
			}
		}
		return $options;
	}

	/**
	 * Create a settings page.
	 *
	 * @param string $prefix The settings.
	 * @return void
	 */
	public static function settings($prefix)
	{
		$capability = Helpers::chat_help_dashboard_capability();
		SchemaRegistry::createOptions(
			$prefix,
			array(
				'menu_title'       => esc_html__('Global Settings', 'chat-help'),
				'menu_type'        => 'submenu', // menu, submenu, options, theme, etc.
				'menu_slug'        => 'assign-widget',
				'theme'            => 'light',
				'show_all_options' => false,
				'show_reset_all'   => false,
				'show_reset_section'   => false,
				'show_search'      => false,
				'show_footer'      => false,
				'show_bar_menu'    => false,
				'framework_title'  => esc_html__('ChatHelp', 'chat-help'),
				'menu_capability'  => $capability,
			)
		);
		SchemaRegistry::createSection(
			$prefix,
			array(
				'name'   => 'assign_widget',
				'title'  => __('Layout', 'chat-help'),
				'fields' => array(

					array(
						'type'    => 'submessage',
						'content' => esc_html__('Assign widget based on pages, posts including any post type and Categories/Taxonomies.', 'chat-help') . ' <a href="https://wpchathelp.com/docs/layout-assignment/" target="_blank">' . esc_html__('See Docs', 'chat-help') . '</a>',
					),
					array(
						'id'                     => 'assign_widget_data',
						'type'                   => 'group',
						'button_title'           => __('Add New', 'chat-help'),
						'accordion_title_prefix' => __('Assign Layout:', 'chat-help'),
						'accordion_title_number' => true,
						'fields'                 => array(

							array(
								'id'      => 'select_by',
								'type'    => 'button_set',
								'title'   => __('Select By', 'chat-help'),
								'options' => array(
									'posts'    => __('Specific Post(s)', 'chat-help'),
									'taxonomy' => __('Categories/Taxonomies', 'chat-help'),
								),
								'default' => 'posts',
							),


							array(
								'id'            => 'widget_post_type',
								'type'          => 'select',
								'title'         => __('Post Type', 'chat-help'),
								'options'       => 'post_type',
								'class'         => 'ta_widget_post_type',
								'multiple_type' => true,
								'attributes'    => array(
									'placeholder' => __('Select Post Type', 'chat-help'),
									'style'       => 'min-width: 150px;',
								),
								'default'       => 'post',
								'dependency'  => array('select_by', '==', 'posts'),
							),

							array(
								'id'          => 'widget_specific_posts',
								'type'        => 'select',
								'title'       => __('Select Post(s)', 'chat-help'),
								'options'     => 'posts',
								'title_help'  => __('Choose the posts to display. Sort the posts position by drag & drop.', 'chat-help'),
								'chosen'      => true,
								'sortable'    => false,
								'ajax'        => false,
								'class'       => 'ta_widget_specific_posts',
								'multiple'    => true,
								'placeholder' => __('Choose Posts', 'chat-help'),
								'query_args'  => array(
									'posts_per_page' => -1,
									'cache_results'  => false,
									'no_found_rows'  => true,
								),
								'dependency'  => array('select_by', '==', 'posts'),
							),
							array(
								'id'          => 'widget_taxonomy_terms',
								'type'        => 'select',
								'title'       => __('Select Categories/Taxonomies', 'chat-help'),
								'options'     => 'chat_help_get_taxonomy_terms',
								'title_help'  => __('Choose the categories or taxonomy terms. The selected widget will show on all posts within these terms.', 'chat-help'),
								'chosen'      => true,
								'multiple'    => true,
								'placeholder' => __('Choose Categories/Terms', 'chat-help'),
								'dependency'  => array('select_by', '==', 'taxonomy'),
							),
							array(
								'id'          => 'select_widget',
								'class'       => 'select_widget',
								'type'        => 'select',
								'title'       => __('Select Layout', 'chat-help'),
								'options'     => 'posts',
								'title_help'  => __('Choose the posts to display. Sort the posts position by drag & drop.', 'chat-help'),
								'placeholder' => __('Choose Layout', 'chat-help'),
								'empty_message' => __('No chat layout is created. Please <a href="' . admin_url( 'post-new.php?post_type=floating_widget' ) . '">create</a> a layout first.', 'chat-help'),
								'query_args'  => array(
									'post_type'		 => 'floating_widget',
									'posts_per_page' => -1,
									'cache_results'  => false,
									'no_found_rows'  => true,
								),
							),
						),
					),
				),
			)
		);
	}
}
