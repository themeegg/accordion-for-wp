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
$atts       = array();
$templates  = "template-1";
$style      = "vertical";
$atts       = apply_filters( 'afwp_tab_args', $atts );
$templates  = apply_filters( 'afwp_tab_templates', $templates );
$style      = apply_filters( 'afwp_tab_styles', $style );
$query      = new WP_Query( $atts );
if ( $query->have_posts() ):
	?>
	<div class="afwp-tab-template afwp-tab-shortcode afwp-<?php echo $templates; ?>">
		<div class="afwp-tab <?php echo $style; ?>">
			<ul class="afwp-tab-list">
				<?php while ( $query->have_posts() ):$query->the_post(); ?>
					<li class="afwp-tab-item-wrap">
						<a class="afwp-post-link" href="#post_tab_<?php echo get_the_ID(); ?>"><?php the_title(); ?></a>
					</li>
				<?php endwhile; ?>
			</ul>
			<div class="afwp-tab-content-wraper">
				<?php while ( $query->have_posts() ):$query->the_post(); ?>
					<div class="afwp-tab-content" id="post_tab_<?php echo get_the_ID(); ?>">
						<?php the_excerpt(); ?>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
	<?php
endif;
wp_reset_query();
wp_reset_postdata();