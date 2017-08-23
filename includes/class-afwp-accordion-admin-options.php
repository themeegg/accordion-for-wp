<?php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://themeegg.com/plugins/accordion-for-wp//
 * @since      1.0.0
 *
 * @package    Accordion_For_WP
 * @subpackage Accordion_For_WP/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Accordion_For_WP
 * @subpackage Accordion_For_WP/admin
 * @author     ThemeEgg <themeeggofficial@gmail.com>
 */
class Accordion_For_WP_Admin_Options {

	public function __construct() {

		add_action( 'init', array( $this, 'register_custom_post_types' ) );

		add_filter( 'manage_edit-accordion-group_columns', array( $this, 'accordion_shortcode_column' ), 10, 1 );

		add_action( 'manage_accordion-group_custom_column', array( $this, 'action_custom_columns_content' ), 10, 3 );

	}

	/**
	 * @param $column_id
	 * @param $post_id
	 *
	 * @return string
	 */
	function action_custom_columns_content( $content, $column_id, $taxonomy_id ) {

		//run a switch statement for all of the custom columns created
		switch ( $column_id ) {
			case 'accordion_shortcode':
				return '<span onclick="">[accordion-for-wp id="'.$taxonomy_id.'"]</span>';
				break;

		}
	}

	/**
	 * @param $columns
	 *
	 * @return array
	 */
	function accordion_shortcode_column( $columns ) {

		$key    = 'description';
		$offset = array_search( $key, array_keys( $columns ) );

		$result = array_merge
		(
			array_slice( $columns, 0, $offset ),
			array( 'accordion_shortcode' => __( 'Shortcode', 'accordion-for-wp' ) ),
			array_slice( $columns, $offset, null )
		);

		return $result;
	}

	public function register_custom_post_types() {

		// Add new taxonomy, make it hierarchical (like categories)
		$labels = array(
			'name'              => _x( 'Accordion group', 'taxonomy general name', 'accordion-for-wp' ),
			'singular_name'     => _x( 'Accordion group', 'taxonomy singular name', 'accordion-for-wp' ),
			'search_items'      => __( 'Search accordion group', 'accordion-for-wp' ),
			'all_items'         => __( 'All Accordion groups', 'accordion-for-wp' ),
			'parent_item'       => __( 'Parent Accordion group', 'accordion-for-wp' ),
			'parent_item_colon' => __( 'Parent Accordion group:', 'accordion-for-wp' ),
			'edit_item'         => __( 'Edit Accordion group', 'accordion-for-wp' ),
			'update_item'       => __( 'Update Accordion group', 'accordion-for-wp' ),
			'add_new_item'      => __( 'Add New Accordion group', 'accordion-for-wp' ),
			'new_item_name'     => __( 'New Accordion group Name', 'accordion-for-wp' ),
			'menu_name'         => __( 'Accordion group', 'accordion-for-wp' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'accordion-group' ),
		);

		register_taxonomy( 'accordion-group', array( 'accordion-for-wp' ), $args );

		$labels = array(
			'name'               => _x( 'Accordion', 'post type general name', 'accordion-for-wp' ),
			'singular_name'      => _x( 'Accordion', 'post type singular name', 'accordion-for-wp' ),
			'menu_name'          => _x( 'Accordions', 'admin menu', 'accordion-for-wp' ),
			'name_admin_bar'     => _x( 'Accordion', 'add new on admin bar', 'accordion-for-wp' ),
			'add_new'            => _x( 'Add New', 'book', 'accordion-for-wp' ),
			'add_new_item'       => __( 'Add New Accordion', 'accordion-for-wp' ),
			'new_item'           => __( 'New Accordion', 'accordion-for-wp' ),
			'edit_item'          => __( 'Edit Accordion', 'accordion-for-wp' ),
			'view_item'          => __( 'View Accordion', 'accordion-for-wp' ),
			'all_items'          => __( 'All Accordions', 'accordion-for-wp' ),
			'search_items'       => __( 'Search Accordions', 'accordion-for-wp' ),
			'parent_item_colon'  => __( 'Parent Accordions:', 'accordion-for-wp' ),
			'not_found'          => __( 'No accordions found.', 'accordion-for-wp' ),
			'not_found_in_trash' => __( 'No accordions found in Trash.', 'accordion-for-wp' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'accordion-for-wp' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'accordion-for-wp' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);

		register_post_type( 'accordion-for-wp', $args );
	}



}

new Accordion_For_WP_Admin_Options();
