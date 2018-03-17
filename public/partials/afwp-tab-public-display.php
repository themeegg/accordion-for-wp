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
$templates  = "default";
$style      = "vertical";

$atts       = apply_filters( 'afwp_tab_args', $atts );

$templates  = apply_filters( 'afwp_tab_templates', $templates );
$style      = apply_filters( 'afwp_tab_styles', $style );

$title_color = '';
$title_background = '';

$query      = new WP_Query( $atts );
$active_tab = 1;
if ( $query->have_posts() ):
	?>
	<div class="afwp-tab-template afwp-tab-shortcode afwp-tab-<?php echo esc_attr($templates); ?>">
		<div class="afwp-tab <?php echo esc_attr($style); ?>">
			<ul class="afwp-tab-list">
				<?php 
				$current_tab = 0;
				while ( $query->have_posts() ):$query->the_post(); 
					$current_tab++;
					$tab_class = ($current_tab==$active_tab) ? ' current ' : '';
					?>
					<li class="afwp-tab-item-wrap">
						<div class="afwp-tab-title" style="background:<?php echo sanitize_hex_color($title_background); ?>; color:<?php echo sanitize_hex_color($title_color); ?>;">
							<a class="afwp-post-link <?php echo esc_attr($tab_class); ?>" href="#post_tab_<?php echo get_the_ID(); ?>"><?php the_title(); ?></a>
						</div>
					</li>
				<?php endwhile; ?>
			</ul>
			<div class="afwp-tab-content-wraper">
				<?php 
				$current_tab = 0;
				while ( $query->have_posts() ):$query->the_post(); 
					$current_tab++;
					$tab_class = ($current_tab==$active_tab) ? ' current ' : '';
					?>
					<div class="afwp-tab-content <?php echo esc_attr($tab_class); ?>" id="post_tab_<?php echo get_the_ID(); ?>">
						<?php the_afwp_excerpt(); ?>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
	<?php
endif;
wp_reset_query();
wp_reset_postdata();