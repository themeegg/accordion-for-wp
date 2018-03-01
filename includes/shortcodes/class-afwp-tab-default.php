<?php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The class for accordion shortcode
 *
 * @link       http://themeegg.com/
 * @since      1.0.0
 *
 * @package    Accordion_For_WP
 * @subpackage Accordion_For_WP/public
 */
class AFWP_Tab_Shortcode_Default {

	protected $atts;

	/**
	 * @param no param
	 *
	 * @since      1.0.0
	 */
	public function __construct() {

		defined( 'WPINC' ) or exit;

		add_shortcode( 'afwp_tab', array( $this, 'afwp_tab' ) );
	}

	/**
	 * @param $atts is shortcode attribute
	 *
	 * @since      1.0.0
	 */
	public function filter_args( $atts ) {

		/*WP Query Args*/
		$args = array();

		$this->atts = wp_parse_args( $atts, $args );

		return $this->atts;

	}

	public function afwp_tab( $atts, $content = "" ) {

		$args = $this->filter_args( $atts );

		ob_start();

		$this->template( $args );

		$output = ob_get_contents();

		ob_get_clean();

		return $output;

	}


	public function tab_args( $atts ) {
		return $this->atts;
	}

	public function template( $atts ) {

		add_filter( 'afwp_tab_args', array( $this, 'tab_args' ), 10, 1 );

		$afwp_loader = new Accordion_For_WP_Loader();


		$afwp_loader->afwp_template_part( 'public/partials/afwp-tab-public-display.php' );


	}

}

new AFWP_Tab_Shortcode_Default();
