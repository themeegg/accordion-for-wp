<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if(!function_exists('afwp_accordion_templates')){
	function afwp_accordion_templates() {

		return apply_filters(

			'afwp_accordion_templates', array(

				'default'       => esc_html__( 'Default', 'accordion-for-wp' ),
				'template-1'    => esc_html__( 'Template 1', 'accordion-for-wp' ),
				'theme-default' => esc_html__( 'Theme default', 'accordion-for-wp' ),
			)
		);
	}
}

if(!function_exists('afwp_accordion_styles')){
	function afwp_accordion_styles() {

		return apply_filters(

			'afwp_accordion_styles', array(
				'vertical'   => esc_html__( 'Vertical', 'accordion-for-wp' ),
				'horizontal' => esc_html__( 'Horizontal', 'accordion-for-wp' ),
			)
		);
	}
}

if(!function_exists('afwp_accordion_type')){
	function afwp_accordion_type() {

		return apply_filters(

			'afwp_accordion_type', array(
				'accordion'   => esc_html__( 'Accordion', 'accordion-for-wp' ),
				'tab' => esc_html__( 'Tab', 'accordion-for-wp' ),
			)
		);
	}
}

