<?php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The class for accordion shortcode
 *
 * @link       http://themeegg.com/
 * @since      1.1.0
 *
 * @package    Accordion_For_WP
 * @subpackage Accordion_For_WP/public
 */
class AFWP_Accordion_Widgets extends WP_Widget {

	/**
	 * Sets up a new Accordion WIdget instance.
	 *
	 * @since 1.1.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops  = array(
			'classname'                   => 'afwp_accordion_widget',
			'description'                 => esc_html__( 'Widget for Accordion', 'accordion-for-wp' ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array( 'width' => 300, 'height' => 350 );
		parent::__construct( 'afwp_accordion_widget', esc_html__( 'Accordion Post Widget', 'accordion-for-wp' ), $widget_ops, $control_ops );
	}

	/**
	 * Outputs the content for the current Accordion widget instance.
	 *
	 * @since 1.1.0
	 * @access public
	 *
	 * @param array $args Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Accordion widget instance.
	 */
	public function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		$post_type  = ! empty( $instance['post_type'] ) ? $instance['post_type'] : '';
		$taxonomy   = ! empty( $instance['taxonomy'] ) ? $instance['taxonomy'] : '';
		$term       = ! empty( $instance['term'] ) ? $instance['term'] : '';
		$no_of_post = ! empty( $instance['no_of_post'] ) ? $instance['no_of_post'] : '';

		$templates = ! empty( $instance['templates'] ) ? $instance['templates'] : '';
		$style     = ! empty( $instance['style'] ) ? $instance['style'] : '';
		$content_type     = ! empty( $instance['content_type'] ) ? $instance['content_type'] : 'excerpt';

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		$wp_args = array(
			'post_type'      => $post_type,
			'posts_per_page' => $no_of_post,
		);
		if ( $taxonomy && $term ) {
			$wp_args['tax_query'] = array(
				'taxonomy' => $taxonomy,
				'field'    => 'slug',
				'terms'    => $term,
			);
		}
		$query = new WP_Query( $wp_args );
		if ( $query->have_posts() ):
			?>
			<div class="afwp-accordion-template afwp-widget afwp-<?php echo $templates; ?>">
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
		<?php endif; ?>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Handles updating settings for the current Text widget instance.
	 *
	 * @since 1.1.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 *
	 * @return array Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance               = $old_instance;
		$instance['title']      = sanitize_text_field( $new_instance['title'] );
		$instance['post_type']  = sanitize_text_field( $new_instance['post_type'] );
		$instance['taxonomy']   = sanitize_text_field( $new_instance['taxonomy'] );
		$instance['term']       = sanitize_text_field( $new_instance['term'] );
		$instance['no_of_post'] = absint( $new_instance['no_of_post'] );

		$instance['templates'] = sanitize_text_field( $new_instance['templates'] );
		$instance['style']     = sanitize_text_field( $new_instance['style'] );

		return $instance;
	}

	/**
	 * Outputs the Accordion widget settings form.
	 *
	 * @since 1.1.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$instance   = wp_parse_args( (array) $instance, array(
			'title'      => '',
			'post_type'  => '',
			'taxonomy'   => '',
			'term'       => '',
			'no_of_post' => '5',
			'templates'  => 'default',
			'style'      => 'vertical',
		) );
		$title      = sanitize_text_field( $instance['title'] );
		$post_type  = sanitize_text_field( $instance['post_type'] );
		$taxonomy   = sanitize_text_field( $instance['taxonomy'] );
		$term       = sanitize_text_field( $instance['term'] );
		$no_of_post = absint( $instance['no_of_post'] );

		$templates = sanitize_text_field( $instance['templates'] );
		$style     = sanitize_text_field( $instance['style'] );
		?>
		<p><label
				for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'accordion-for-wp' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>"/></p>

		<p><label
				for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php esc_html_e( 'Post Type:', 'accordion-for-wp' ); ?></label>
			<?php
			$args           = array(
				'public' => true,
			);
			$all_post_types = get_post_types( $args, 'objects' );
			?>
			<select class="widefat afwp-widget-post-type" data-accordion-value="post_type"
			        data-accordion-change-id="#<?php echo $this->get_field_id( 'taxonomy' ); ?>"
			        id="<?php echo $this->get_field_id( 'post_type' ); ?>"
			        name="<?php echo $this->get_field_name( 'post_type' ); ?>" type="text"
			        value="<?php echo esc_attr( $post_type ); ?>">
				<?php foreach ( $all_post_types as $post_type_key => $post_type_value ): ?>
					<option <?php echo ( $post_type_key == $post_type ) ? 'selected="selected"' : ''; ?>
						value="<?php echo $post_type_key; ?>"><?php echo $post_type_value->label; ?></option>
				<?php endforeach; ?>
			</select></p>

		<p><label
				for="<?php echo $this->get_field_id( 'taxonomy' ); ?>"><?php esc_html_e( 'Taxonomy:', 'accordion-for-wp' ); ?></label>
			<?php
			$all_object_taxonomies = get_object_taxonomies( $post_type, 'objects' );
			?>
			<select class="widefat afwp-widget-taxonomy" data-accordion-value="taxonomy"
			        data-accordion-change-id="#<?php echo $this->get_field_id( 'term' ); ?>"
			        id="<?php echo $this->get_field_id( 'taxonomy' ); ?>"
			        name="<?php echo $this->get_field_name( 'taxonomy' ); ?>" type="text"
			        value="<?php echo esc_attr( $taxonomy ); ?>">
				<option <?php echo ( $taxonomy ) ? '' : 'selected="selected"'; ?> value="">No Filter</option>
				<?php foreach ( $all_object_taxonomies as $taxonomy_key => $taxonomy_value ): ?>
					<option <?php echo ( $taxonomy_key == $taxonomy ) ? 'selected="selected"' : ''; ?>
						value="<?php echo $taxonomy_key; ?>"><?php echo $taxonomy_value->label; ?></option>
				<?php endforeach; ?>
			</select></p>

		<p><label for="<?php echo $this->get_field_id( 'term' ); ?>"><?php esc_html_e( 'Term:', 'accordion-for-wp' ); ?></label>
			<?php
			$all_terms = get_terms( array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
			) );
			?>
			<select class="widefat" id="<?php echo $this->get_field_id( 'term' ); ?>"
			        name="<?php echo $this->get_field_name( 'term' ); ?>" type="text"
			        value="<?php echo esc_attr( $term ); ?>">
				<option <?php echo ( $term ) ? '' : 'selected="selected"'; ?> value="">No Filter</option>
				<?php if ( is_array( $all_terms ) ): ?>
					<?php foreach ( $all_terms as $term_key => $term_value ): ?>
						<option <?php echo ( $term_value->slug == $term ) ? 'selected="selected"' : ''; ?>
							value="<?php echo $term_value->slug; ?>"><?php echo $term_value->name; ?></option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select></p>

		<p><label
				for="<?php echo $this->get_field_id( 'no_of_post' ); ?>"><?php esc_html_e( 'Show no of post:', 'accordion-for-wp' ); ?></label>
			<input class="widefat" min="1" max="99" id="<?php echo $this->get_field_id( 'no_of_post' ); ?>"
			       name="<?php echo $this->get_field_name( 'no_of_post' ); ?>" type="number"
			       value="<?php echo $no_of_post; ?>"/></p>
		<hr/>
		<p><label
				for="<?php echo $this->get_field_id( 'templates' ); ?>"><?php esc_html_e( 'Template:', 'accordion-for-wp' ); ?></label>
			<?php
			$all_templates = afwp_accordion_templates();
			?>
			<select class="widefat" id="<?php echo $this->get_field_id( 'templates' ); ?>"
			        name="<?php echo $this->get_field_name( 'templates' ); ?>">
				<?php foreach ( $all_templates as $template_key => $template_value ): ?>
					<option <?php selected( $templates, $template_key, true ); ?>
						value="<?php echo $template_key; ?>"><?php echo $template_value; ?></option>
				<?php endforeach; ?>
			</select></p>
		<p><label
				for="<?php echo $this->get_field_id( 'style' ); ?>"><?php esc_html_e( 'Style:', 'accordion-for-wp' ); ?></label>
			<?php
			$all_style = afwp_accordion_styles();
			?>
			<select class="widefat" id="<?php echo $this->get_field_id( 'style' ); ?>"
			        name="<?php echo $this->get_field_name( 'style' ); ?>">
				<?php foreach ( $all_style as $style_key => $style_value ): ?>
					<option <?php selected( $style, $style_key, true ); ?>
						value="<?php echo $style_key; ?>"><?php echo $style_value; ?></option>
				<?php endforeach; ?>
			</select></p>
		<?php
	}

}

register_widget( 'AFWP_Accordion_Widgets' );
