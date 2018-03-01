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
class AFWP_Accordion_Shortcode_Default{

	protected $atts;

	protected $template;

	protected $style;

	/**
	 * @param no param
	 *
	 * @since      1.0.0
	 */
	public function __construct() {

		defined( 'WPINC' ) or exit;

		add_shortcode( 'afwp_accordion', array( $this, 'afwp_accordion' ) );
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

	public function afwp_accordion( $atts, $content = "" ) {

		$args = $this->filter_args( $atts );

		$this->style = isset($args['style']) ? $args['style'] : 'vertical';

		$this->template = isset($args['template']) ? $args['template'] : 'template-1';

		ob_start();

		$this->template();

		$output = ob_get_contents();

		ob_get_clean();

		return $output;


	}


	public function accordion_args() {

		return $this->atts;

	}

	public function afwp_templates(){

		return $this->template;

	}

	public function afwp_styles(){

		return $this->style;

	}

	public function template() {

		add_filter( 'afwp_accordion_args', array( $this, 'accordion_args' ), 10, 1 );
		add_filter( 'afwp_accordion_templates', array( $this, 'afwp_templates' ), 10, 1 );
		add_filter( 'afwp_accordion_styles', array( $this, 'afwp_styles' ), 10, 1 );
		$afwp_loader = new Accordion_For_WP_Loader();
		$afwp_loader->afwp_template_part( 'public/partials/afwp-accordion-public-display.php' );


	}

}

new AFWP_Accordion_Shortcode_Default();
