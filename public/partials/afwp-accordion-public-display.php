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
$afwp_args       	= array();
$afwp_templates  	= afwp_sanitize_accordion_templates();
$afwp_style      	= afwp_accordion_styles();
$afwp_content_type 	= afwp_sanitize_accordion_content_type();

$afwp_dropdown_icon = 'fa-toggle-off';
$afwp_active_dp_icon = 'fa-toggle-on';
$afwp_title_color = '';
$afwp_title_background = '';
$afwp_content_color = '';
$afwp_content_background = '';

$args       	= apply_filters( 'afwp_accordion_args', $afwp_args );
$templates  	= apply_filters( 'afwp_accordion_templates', $afwp_templates );
$style      	= apply_filters( 'afwp_accordion_styles', $afwp_style );
$content_type   = apply_filters( 'afwp_accordion_content_type', $afwp_content_type );

$dropdown_icon	= apply_filters( 'afwp_dropdown_icon', $afwp_dropdown_icon);
$active_dp_icon	= apply_filters( 'afwp_active_dp_icon', $afwp_active_dp_icon);
$title_color	= apply_filters( 'afwp_title_color', $afwp_title_color);
$title_background	= apply_filters( 'afwp_title_background', $afwp_title_background);
$content_color	= apply_filters( 'afwp_content_color', $afwp_content_color);
$content_background	= apply_filters( 'afwp_content_background', $afwp_content_background);

$query      = new WP_Query( $args );
if ( $query->have_posts() ):
	?>
	<div class="afwp-accordion-template afwp-shortcode afwp-<?php echo $templates; ?>">
		<div class="afwp-accordion <?php echo $style; ?>">
			<ul class="afwp-accordion-list">
				<?php while ( $query->have_posts() ):$query->the_post(); ?>
					<?php $afwp_post_slug = get_post_field( 'post_name', get_the_ID() ); ?>
					<li class="afwp-accordion-item-wrap">
						<div class="afwp-accordion-title" style="background:<?php echo sanitize_hex_color($title_background); ?>; color:<?php echo sanitize_hex_color($title_color); ?>;">
							<span data-href="#afwp_<?php echo $afwp_post_slug.get_the_ID(); ?>"><?php the_title(); ?></span>
							<?php if(!empty($dropdown_icon)): ?>
								<i 
									class="afwp-toggle-icon fa <?php echo esc_attr($dropdown_icon); ?>" 
									data-dropdown-icon="<?php echo esc_attr($dropdown_icon); ?>" 
									data-active-dp-icon="<?php echo esc_attr($active_dp_icon); ?>" 
									style="color:<?php echo sanitize_hex_color($title_color); ?>;"
								></i>
							<?php endif; ?>
						</div>
						<div class="afwp-content" id="afwp_<?php echo $afwp_post_slug.get_the_ID(); ?>"  style="background:<?php echo sanitize_hex_color($content_background); ?>; color:<?php echo sanitize_hex_color($content_color); ?>;">
							<div class="afwp-content-wraper">
								<?php
								if($content_type=='content'){
									the_content();
								}else{
									the_excerpt();
								}
								?>
							</div>
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
