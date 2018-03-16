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
		$control_ops = array( 'width' => 350, 'height' => 350 );
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

		$post_type  = ! empty( $instance['post_type'] ) ? esc_attr($instance['post_type']) : '';
		$taxonomy   = ! empty( $instance['taxonomy'] ) ? esc_attr($instance['taxonomy']) : '';
		$term       = ! empty( $instance['term'] ) ? absint($instance['term']) : '';
		$no_of_post = ! empty( $instance['no_of_post'] ) ? absint($instance['no_of_post']) : '';

		$dropdown_icon		= isset($instance['dropdown_icon']) ? esc_attr( $instance['dropdown_icon'] ) : 'fa-toggle-off';
		$active_dp_icon		= isset($instance['active_dp_icon']) ? esc_attr( $instance['active_dp_icon'] ) : 'fa-toggle-on';
		$title_color		= isset($instance['title_color']) ? sanitize_hex_color( $instance['title_color'] ) : '';
		$title_background	= isset($instance['title_background']) ? sanitize_hex_color( $instance['title_background'] ) : '';
		$content_color		= isset($instance['content_color']) ? sanitize_hex_color( $instance['content_color'] ) : '';
		$content_background	= isset($instance['content_background']) ? sanitize_hex_color( $instance['content_background'] ) : '';

		$templates      	= empty( $instance['templates'] ) ? 'default' : esc_attr($instance['templates']);
		$style          	= empty( $instance['style'] ) ? 'vertical' : esc_attr($instance['style']);

		$content_type     = ! empty( $instance['content_type'] ) ? esc_attr($instance['content_type']) : 'excerpt';

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
				<div class="afwp-accordion <?php echo esc_attr($style); ?>">
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
								<div class="afwp-content" id="afwp_<?php echo $afwp_post_slug.get_the_ID(); ?>" style="background:<?php echo sanitize_hex_color($content_background); ?>; color:<?php echo sanitize_hex_color($content_color); ?>;">
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
		$instance['title']      = isset($new_instance['title']) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['post_type']  = isset($new_instance['post_type']) ? esc_attr( $new_instance['post_type'] ) : '';
		$instance['taxonomy']   = isset($new_instance['taxonomy']) ? esc_attr( $new_instance['taxonomy'] ) : '';
		$instance['term']       = isset($new_instance['term']) ? esc_attr( $new_instance['term'] ) : '';
		$instance['no_of_post'] = isset($new_instance['no_of_post']) ? absint( $new_instance['no_of_post'] ) : '';
		$instance['content_type'] = isset($new_instance['content_type']) ? esc_attr($new_instance['content_type']) : '';

		$instance['dropdown_icon']     = isset($new_instance['dropdown_icon']) ? esc_attr( $new_instance['dropdown_icon'] ) : '';
		$instance['active_dp_icon']     = isset($new_instance['active_dp_icon']) ? esc_attr( $new_instance['active_dp_icon'] ) : '';
		$instance['title_color']     = isset($new_instance['title_color']) ? esc_attr( $new_instance['title_color'] ) : '';
		$instance['title_background']     = isset($new_instance['title_background']) ? esc_attr( $new_instance['title_background'] ) : '';
		$instance['content_color']     = isset($new_instance['content_color']) ? esc_attr( $new_instance['content_color'] ) : '';
		$instance['content_background']     = isset($new_instance['content_background']) ? esc_attr( $new_instance['content_background'] ) : '';

		$instance['style']     = isset($new_instance['style']) ? esc_attr( $new_instance['style'] ) : '';
		$instance['templates'] = isset($new_instance['templates']) ? esc_attr( $new_instance['templates'] ) : '';

		$instance['active_tab_type'] = isset($new_instance['active_tab_type']) ? esc_attr( $new_instance['active_tab_type'] ) : 'general';

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
			'title'      		=> '',
			'post_type'  		=> '',
			'taxonomy'   		=> '',
			'term'       		=> '',
			'no_of_post' 		=> '5',
			'content_type'		=>'excerpt',

			'templates'  		=> 'default',
			'style'      		=> 'vertical',

			'dropdown_icon'		=> 'fa-toggle-off',
			'active_dp_icon'	=> 'fa-toggle-on',
			'title_color'  		=> '',
			'title_background'  => '',
			'content_color'  	=> '',
			'content_background'=> '',

			'active_tab_type'	=>'general',
		) );

		$title	= isset($instance['title']) ? sanitize_text_field( $instance['title'] ) : '';
		$post_type	= isset($instance['post_type']) ? esc_attr( $instance['post_type'] ) : '';
		$taxonomy	= isset($instance['taxonomy']) ? esc_attr( $instance['taxonomy'] ) : '';
		$term	= isset($instance['term']) ? esc_attr( $instance['term'] ) : '';
		$no_of_post	= isset($instance['no_of_post']) ? absint( $instance['no_of_post'] ) : '';
		$content_type	= isset($instance['content_type']) ? esc_attr( $instance['content_type'] ) : '';

		$templates	= isset($instance['templates']) ? esc_attr( $instance['templates'] ) : '';
		$style	= isset($instance['style']) ? esc_attr( $instance['style'] ) : '';

		$dropdown_icon	= isset($instance['dropdown_icon']) ? esc_attr( $instance['dropdown_icon'] ) : 'fa-toggle-off';
		$active_dp_icon	= isset($instance['active_dp_icon']) ? esc_attr( $instance['active_dp_icon'] ) : 'fa-toggle-on';
		$title_color		= isset($instance['title_color']) ? esc_attr( $instance['title_color'] ) : '';
		$title_background	= isset($instance['title_background']) ? esc_attr( $instance['title_background'] ) : '';
		$content_color		= isset($instance['content_color']) ? esc_attr( $instance['content_color'] ) : '';
		$content_background	= isset($instance['content_background']) ? esc_attr( $instance['content_background'] ) : '';

		$active_tab_type		= isset($instance['active_tab_type']) ? esc_attr( $instance['active_tab_type'] ) : 'general';

		$list_all_tabs = array(
			'general'	=>	array(
				'id'	=> 'afwp_accordion_widget_general'.esc_attr($this->number),
				'label'	=> esc_html__('General', 'accordion-for-wp'),
			),
			'layout'	=>	array(
				'id'	=> 'afwp_accordion_widget_layout'.esc_attr($this->number),
				'label'	=> esc_html__('Layout', 'accordion-for-wp'),
			),
			'design'	=>	array(
				'id'	=> 'afwp_accordion_widget_design'.esc_attr($this->number),
				'label'	=> esc_html__('Design', 'accordion-for-wp'),
			),
		);

		?>
		<div class="afwp-tab-wraper">
			<h5 class="afwp-tab-list nav-tab-wrapper">
				<?php foreach($list_all_tabs as $tab_key=>$tab_details){ ?>
					<label for="tab_<?php echo esc_attr($tab_details['id']); ?>" data-id="#<?php echo esc_attr($tab_details['id']); ?>" class="nav-tab <?php echo ($tab_key == $active_tab_type) ? 'nav-tab-active' : ''; ?>"><?php echo sanitize_text_field($tab_details['label']); ?><input id="tab_<?php echo esc_attr($tab_details['id']); ?>" type="radio" name="<?php echo $this->get_field_name("active_tab_type"); ?>" value="<?php echo esc_attr($tab_key); ?>" <?php checked($active_tab_type, $tab_key); ?> class="afwp-hidden"/></label>
				<?php } ?>
			</h5>
			<div class="afwp-tab-content-wraper">
				<div id="<?php echo esc_attr($list_all_tabs['general']['id']); ?>" class="afwp-tab-content <?php echo ($active_tab_type=='general') ? 'afwp-content-active' : ''; ?>" >
					<p>
						<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'accordion-for-wp' ); ?></label>
						<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
							   name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
							   value="<?php echo esc_attr( $title ); ?>"/></p>
					<p>
						<label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php esc_html_e( 'Post Type:', 'accordion-for-wp' ); ?></label>
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
								name="<?php echo $this->get_field_name( 'term' ); ?>"
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
					<?php
					$content_types = array(
						'excerpt'	=> esc_html__('Short Description', 'accordion-for-wp'),
						'content'	=> esc_html__('Full Content','accordion-for-wp'),
					);
					?>
					<p><label for="<?php echo $this->get_field_id( 'content_type' ); ?>"><?php esc_html_e( 'Content Type:', 'accordion-for-wp' ); ?></label>
						<select class="widefat" id="<?php echo $this->get_field_id( 'content_type' ); ?>"
								name="<?php echo $this->get_field_name( 'content_type' ); ?>"
								value="<?php echo esc_attr( $content_type ); ?>">
							<?php if ( is_array( $content_types ) ): ?>
								<?php foreach ( $content_types as $content_key => $content_value ): ?>
									<option <?php selected($content_key, $content_type); ?>
										value="<?php echo esc_attr($content_key); ?>"><?php echo esc_attr($content_value); ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select></p>
				</div>
				<div id="<?php echo esc_attr($list_all_tabs['layout']['id']); ?>" class="afwp-tab-content <?php echo ($active_tab_type=='layout') ? 'afwp-content-active' : ''; ?> " >
					<p>
						<label for="<?php echo $this->get_field_id( 'templates' ); ?>"><?php esc_html_e( 'Template:', 'accordion-for-wp' ); ?></label>
						<?php $all_templates = afwp_accordion_templates(); ?>
						<select class="widefat" id="<?php echo $this->get_field_id( 'templates' ); ?>"
								name="<?php echo $this->get_field_name( 'templates' ); ?>">
							<?php foreach ( $all_templates as $template_key => $template_value ): ?>
								<option <?php selected( $templates, $template_key, true ); ?>
									value="<?php echo $template_key; ?>"><?php echo $template_value; ?></option>
							<?php endforeach; ?>
						</select>
					</p>
					<p>
						<label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php esc_html_e( 'Style:', 'accordion-for-wp' ); ?></label>
						<?php
						$all_style = afwp_accordion_styles();
						?>
						<select class="widefat" id="<?php echo $this->get_field_id( 'style' ); ?>"
								name="<?php echo $this->get_field_name( 'style' ); ?>">
							<?php foreach ( $all_style as $style_key => $style_value ): ?>
								<option <?php selected( $style, $style_key, true ); ?>
									value="<?php echo $style_key; ?>"><?php echo $style_value; ?></option>
							<?php endforeach; ?>
						</select>
					</p>
				</div>
				<div id="<?php echo esc_attr($list_all_tabs['design']['id']); ?>" class="afwp-tab-content <?php echo ($active_tab_type=='design') ? 'afwp-content-active' : ''; ?> " >
					<p>
						<label for="<?php echo $this->get_field_id( 'dropdown_icon' ); ?>"><?php esc_html_e( 'Dropdown Icon:', 'accordion-for-wp' ); ?></label>
						<input class="widefat afwp_icon_picker" id="<?php echo $this->get_field_id( 'dropdown_icon' ); ?>"
							   name="<?php echo $this->get_field_name( 'dropdown_icon' ); ?>" type="text"
							   value="<?php echo esc_attr( $dropdown_icon ); ?>"/></p>
					<p>
					<p>
						<label for="<?php echo $this->get_field_id( 'active_dp_icon' ); ?>"><?php esc_html_e( 'Active Dropdown Icon:', 'accordion-for-wp' ); ?></label>
						<input class="widefat afwp_icon_picker" id="<?php echo $this->get_field_id( 'active_dp_icon' ); ?>"
							   name="<?php echo $this->get_field_name( 'active_dp_icon' ); ?>" type="text"
							   value="<?php echo esc_attr( $active_dp_icon ); ?>"/></p>
					<p>
					<p>
						<label for="<?php echo $this->get_field_id( 'title_color' ); ?>"><?php esc_html_e( 'Title Color:', 'accordion-for-wp' ); ?></label>
						<input class="afwp_color_picker" id="<?php echo $this->get_field_id( 'title_color' ); ?>" name="<?php echo $this->get_field_name( 'title_color' ); ?>" type="text"
							   value="<?php echo esc_attr( $title_color ); ?>"/></p>
					<p>
					<p>
						<label for="<?php echo $this->get_field_id( 'title_background' ); ?>"><?php esc_html_e( 'Title Background:', 'accordion-for-wp' ); ?></label>
						<input class="afwp_color_picker" id="<?php echo $this->get_field_id( 'title_background' ); ?>"
							   name="<?php echo $this->get_field_name( 'title_background' ); ?>" type="text"
							   value="<?php echo esc_attr( $title_background ); ?>"/></p>
					<p>
					<p>
						<label for="<?php echo $this->get_field_id( 'content_color' ); ?>"><?php esc_html_e( 'Content Color:', 'accordion-for-wp' ); ?></label>
						<input class="afwp_color_picker" id="<?php echo $this->get_field_id( 'content_color' ); ?>"
							   name="<?php echo $this->get_field_name( 'content_color' ); ?>" type="text"
							   value="<?php echo esc_attr( $content_color ); ?>"/></p>
					<p>
					<p>
						<label for="<?php echo $this->get_field_id( 'content_background' ); ?>"><?php esc_html_e( 'Content Background:', 'accordion-for-wp' ); ?></label>
						<input class="afwp_color_picker" id="<?php echo $this->get_field_id( 'content_background' ); ?>"
							   name="<?php echo $this->get_field_name( 'content_background' ); ?>" type="text"
							   value="<?php echo esc_attr( $content_background ); ?>"/></p>
					<p>
				</div>
			</div>
		</div>
		<?php
	}
}

register_widget( 'AFWP_Accordion_Widgets' );