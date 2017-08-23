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

class Accordion_Shortcode{

    protected $atts;

    /**
    * @param no param
    * @since      1.0.0
    */
    public function __construct(){

        defined('WPINC') or exit;

        add_shortcode( 'afwp_accordion', array( $this, 'afwp_accordion' ) );

    }

    /**
    * @param $atts is shortcode attribute
    * @since      1.0.0
    */
    public function  filter_args($atts){

        /*WP Query Args*/
        $args = array();

        $this->atts=wp_parse_args($atts, $args);

        return $this->atts;

    }

    public function afwp_accordion( $atts, $content = "" ) {

        $args = $this->filter_args($atts);

        $this->template($args);

    }

    public function accordion_args($atts){
        return $this->atts;
    }

    public function template($atts){

        add_filter('afwp_accordion_args', [$this, 'accordion_args'], 10, 1);

        $accordion = new Accordion_For_WP_Loader();

        $accordion->afwp_template_part('public/partials/afwp-accordion-public-display.php');

    }

}

new Accordion_Shortcode();
