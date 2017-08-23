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

		$this->register_custom_post_type();

	}

	public function register_custom_post_type() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-afwp-accordion-post-type.php';
	}


}

new Accordion_For_WP_Admin_Options();
