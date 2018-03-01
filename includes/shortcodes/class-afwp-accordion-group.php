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
class AFWP_Accordion_Shortcode_Group{

	protected $atts;

	protected $style;

	protected $template;

	/**
	 * @param no param
	 *
	 * @since      1.0.0
	 */
	public function __construct() {

		defined( 'WPINC' ) or exit;

		add_shortcode( 'afwp_group_accordion', array( $this, 'afwp_group_accordion' ) );
	}

	public function afwp_atts() {

		return $this->atts;

	}

	public function afwp_template() {

		if ( ! empty( $this->template ) ) {
			return $this->template;
		}

		return 'template-1';
	}

	public function afwp_style() {

		if ( ! empty( $this->style ) ) {
			return $this->style;
		}

		return 'vertical';

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

	public function afwp_group_accordion( $atts, $content = "" ) {

		if ( ! isset( $atts['id'] ) ){
			return;
		}

		$taxonomy_id = absint( $atts['id'] );

		$post_limit = isset( $atts['limit'] ) ? $atts['limit'] : - 1;

		$this->template = get_term_meta( $taxonomy_id, 'acwp_term_template', true );

		$this->style = get_term_meta( $taxonomy_id, 'acwp_term_style', true );


		$this->atts = array(
			'posts_per_page' => $post_limit,
			'post_type'      => 'accordion-for-wp',
			'tax_query'      => array(
				array(
					'taxonomy' => 'accordion-group',
					'field'    => 'term_id',
					'terms'    => $taxonomy_id,
				)
			)
		);

		add_filter( 'afwp_accordion_args', array( $this, 'afwp_atts' ), 10, 1 );
		add_filter( 'afwp_accordion_templates', array( $this, 'afwp_template' ), 10, 1 );
		add_filter( 'afwp_accordion_styles', array( $this, 'afwp_style' ), 10, 1 );
		$afwp_loader = new Accordion_For_WP_Loader();
		$afwp_loader->afwp_template_part( 'public/partials/afwp-accordion-public-display.php' );

	}


	public function accordion_args( $atts ) {
		return $this->atts;
	}

	public function template( $atts ) {

		add_filter( 'afwp_accordion_args', array( $this, 'accordion_args' ), 10, 1 );

		$afwp_loader = new Accordion_For_WP_Loader();

		$afwp_loader->afwp_template_part( 'public/partials/afwp-accordion-public-display.php' );

	}

}

new AFWP_Accordion_Shortcode_Group();
