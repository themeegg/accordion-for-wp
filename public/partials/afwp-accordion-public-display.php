<?php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://themeegg.com/
 * @since      1.0.0
 *
 * @package    Accordion_For_WP
 * @subpackage Accordion_For_WP/public/partials
 */
?>
	<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
$atts=array();
$templates="template-1";
$style="vertical";

$atts = apply_filters('afwp_accordion_args', $atts);
$templates = apply_filters('afwp_accordian_templates', $templates);
$style = apply_filters('afwp_accordian_templates', $style);

$query = new WP_Query($atts);
if($query->have_posts()):
	?>
	<div class="afwp-accordion-template afwp-shortcode afwp-<?php echo $templates; ?>">
		<div class="afwp-accordion <?php echo $style; ?>">
			<ul class="afwp-accordion-list">
				<?php while($query->have_posts()):$query->the_post(); ?>
					<li class="afwp-accordian-item-wrap">
						<input type="radio" id="afwp-radio-shortcode-<?php echo get_the_ID(); ?>" name="afwp-radio-shortcode-accordion" checked="checked" />
						<label for="afwp-radio-shortcode-<?php echo get_the_ID(); ?>"><?php the_title(); ?></label>
						<div class="afwp-content">
							<?php the_excerpt(); ?>
						</div>
					</li>
				<?php endwhile; ?>
			</ul>
		</div>
	</div>
	<?php
endif;
