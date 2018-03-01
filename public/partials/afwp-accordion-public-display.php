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
$args       	= array();
$templates  	= afwp_sanitize_accordion_templates();
$style      	= afwp_accordion_styles();
$content_type 	= afwp_sanitize_accordion_content_type();
$args       	= apply_filters( 'afwp_accordion_args', $args );
$templates  	= apply_filters( 'afwp_accordion_templates', $templates );
$style      	= apply_filters( 'afwp_accordion_styles', $style );
$content_type   = apply_filters( 'afwp_accordion_content_type', $content_type );
$content_type 	= 'content';

$query      = new WP_Query( $args );
if ( $query->have_posts() ):
	?>
	<div class="afwp-accordion-template afwp-shortcode afwp-<?php echo $templates; ?>">
		<div class="afwp-accordion <?php echo $style; ?>">
			<ul class="afwp-accordion-list">
				<?php while ( $query->have_posts() ):$query->the_post(); ?>
					<?php $afwp_post_slug = get_post_field( 'post_name', get_the_ID() ); ?>
					<li class="afwp-accordion-item-wrap">
						<a class="afwp-accordion-title" href="#afwp_<?php echo $afwp_post_slug.get_the_ID(); ?>"><?php the_title(); ?></a>
						<div class="afwp-content" id="afwp_<?php echo $afwp_post_slug.get_the_ID(); ?>">
							<?php
							if($content_type=='content'){
								the_content();
							}else{
								the_excerpt();
							}
							?>
						</div>
					</li>
				<?php endwhile; ?>
			</ul>
		</div>
	</div>
	<?php
endif;
wp_reset_query();
wp_reset_postdata();
