<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function afwp_accordion_templates() {

	return apply_filters(

		'afwp_accordion_templates', array(

			'default'       => __( 'Default', 'accordion-for-wp' ),
			'template-1'    => __( 'Template 1', 'accordion-for-wp' ),
			'theme-default' => __( 'Theme default', 'accordion-for-wp' ),
		)
	);
}

function afwp_accordion_styles() {

	return apply_filters(

		'afwp_accordion_styles', array(
			'vertical'   => __( 'Vertical', 'accordion-for-wp' ),
			'horizontal' => __( 'Horizontal', 'accordion-for-wp' ),
		)
	);
}

