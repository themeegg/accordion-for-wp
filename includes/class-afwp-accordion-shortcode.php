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
class Accordion_Shortcode {

	protected $atts;

	protected $group_accordion_style;

	protected $group_accordion_template;

	protected $group_accordion_atts;

	/**
	 * @param no param
	 *
	 * @since      1.0.0
	 */
	public function __construct() {

		defined( 'WPINC' ) or exit;

		add_shortcode( 'afwp_accordion', array( $this, 'afwp_accordion' ) );
		add_shortcode( 'afwp_group_accordion', array( $this, 'afwp_group_accordion' ) );

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

		$this->template( $args );

	}

	public function afwp_group_accordion( $atts, $content ) {

		if ( ! isset( $atts['id'] ) ) {
			return;
		}

		$taxonomy_id = absint( $atts['id'] );

		$post_limit = isset( $atts['limit'] ) ? $atts['limit'] : - 1;

		$this->group_accordion_template = get_term_meta( $taxonomy_id, 'acwp_term_template', true );

		$this->group_accordion_style = get_term_meta( $taxonomy_id, 'acwp_term_style', true );


		$this->group_accordion_atts = array(
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

		add_filter( 'afwp_accordion_args', [ $this, 'group_accordion_atts' ], 10, 1 );
		add_filter( 'afwp_accordian_templates', [ $this, 'group_accordion_template' ], 10, 1 );
		add_filter( 'afwp_accordian_styles', [ $this, 'group_accordion_style' ], 10, 1 );

		$accordion = new Accordion_For_WP_Loader();

		$accordion->afwp_template_part( 'public/partials/afwp-accordion-public-display.php' );

		/*echo '<pre>';
		print_r( $posts_array );
		echo '</pre>';*/

	}

	public function group_accordion_atts() {

		return $this->group_accordion_atts;

	}

	public function group_accordion_template() {

		if ( ! empty( $this->group_accordion_template ) ) {
			return $this->group_accordion_template;
		}

		return 'template-1';
	}

	public function group_accordion_style() {

		if ( ! empty( $this->group_accordion_style ) ) {
			return $this->group_accordion_style;
		}

		return 'vertical';

	}

	public function accordion_args( $atts ) {
		return $this->atts;
	}

	public function template( $atts ) {

		add_filter( 'afwp_accordion_args', [ $this, 'accordion_args' ], 10, 1 );

		$accordion = new Accordion_For_WP_Loader();

		$accordion->afwp_template_part( 'public/partials/afwp-accordion-public-display.php' );

	}

}

new Accordion_Shortcode();
