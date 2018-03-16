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
class AFWP_Accordion_Shortcode_Group {

	protected $atts;

	protected $content_type;

	protected $style;
	protected $template;

	protected $dropdown_icon;
	protected $active_dp_icon;
	protected $title_color;
	protected $title_background;
	protected $content_color;
	protected $content_background;

	/**
	 * @param no param
	 *
	 * @since      1.0.0
	 */
	public function __construct() {

		defined( 'WPINC' ) or exit;

		add_shortcode( 'afwp_group_accordion', array( $this, 'afwp_group_accordion' ) );
	}

	





	/**
	 * @param $atts is shortcode attribute
	 *
	 * @since      1.0.0
	 */
	public function filter_args( $atts ) {

		/*WP Query Args*/
		$default_args = array();

		$this->atts = wp_parse_args( $atts, $default_args );

		return $this->atts;

	}

	public function afwp_group_accordion( $atts, $content = "" ) {

		if ( ! isset( $atts['id'] ) ) {
			return;
		}

		$taxonomy_id = absint( $atts['id'] );

		$post_limit = isset( $atts['limit'] ) ? $atts['limit'] : - 1;

		$this->template = get_term_meta( $taxonomy_id, 'afwp_term_template', true );

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
		ob_start();

		$this->template();

		$output = ob_get_contents();

		ob_get_clean();

		return $output;

	}

	public function afwp_accordion_args( $atts ) { return $this->atts; }

	public function afwp_accordion_content_type( $atts ) { return $this->content_type; }

	public function afwp_accordion_styles() {
		if ( ! empty( $this->style ) ) {
			return $this->style;
		}
		return 'vertical';
	}
	public function afwp_accordion_templates() {
		if ( ! empty( $this->template ) ) {
			return $this->template;
		}
		return 'default';
	}

	public function afwp_dropdown_icon( $atts ) { return $this->dropdown_icon; }
	public function afwp_active_dp_icon( $atts ) { return $this->active_dp_icon; }

	
	public function template() {

		add_filter( 'afwp_accordion_args', array( $this, 'afwp_accordion_args' ) );

		add_filter( 'afwp_accordion_content_type', array( $this, 'afwp_accordion_content_type' ) );

		add_filter( 'afwp_accordion_styles', array( $this, 'afwp_accordion_styles' ) );
		add_filter( 'afwp_accordion_templates', array( $this, 'afwp_accordion_templates' ) );

		add_filter( 'afwp_dropdown_icon', array( $this, 'afwp_dropdown_icon' ) );
		add_filter( 'afwp_active_dp_icon', array( $this, 'afwp_active_dp_icon' ) );
		

		$afwp_loader = new Accordion_For_WP_Loader();
		$afwp_loader->afwp_template_part( 'public/partials/afwp-accordion-public-display.php' );

	}

}

new AFWP_Accordion_Shortcode_Group();
